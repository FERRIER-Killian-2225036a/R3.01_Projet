<?php

/**
 * classe utilitaire pour la vérification des images uploadées
 *
 * cette classe s'occupe de vérifier les images uploadées par les utilisateurs, elle vérifie la taille
 * si elle sont safe, au niveau du contenu (par ai via l'api google cloud vision) [adulte, violence, etc...]
 * ou encore du type ( verification Mime type, extension, Magic Number)
 * gere aussi l'unicité du nom du fichier (pour éviter les collisions)
 * on détruit les données exif des images pour éviter les attaques de type exif injection
 * et l'usage d'osint qui pourrait ammener a de potentiel leak d'informations
 *
 * @see ControllerSettings
 * @see ControllerPost
 *
 * @package core
 * @since 1.0
 * @version 1.0
 * @category PictureVerificator
 * @author Tom Carvajal
 */
class PictureVerificator
{
    /**
     * Méthode pour vérifier sur la sécurisation des images uploadées
     *
     * @param $file
     * @param string $uploadDirectory
     * @param array $allowedExtensions
     * @param int $minFileSize
     * @param int $maxFileSize
     * @param bool $square
     * @return array|string
     */
    public static function VerifyImg($file, string $uploadDirectory, array $allowedExtensions,
                                     int $minFileSize, int $maxFileSize, bool $square = false): array|string //TODO mettre a jour l'indice de suspicion
    {
        if ($file['error'] !== UPLOAD_ERR_OK) {
            return "Une erreur est survenue lors de l'upload du fichier.";
        }

        $fileName = $file['name'];
        $fileTmpName = $file['tmp_name'];
        $fileSize = filesize($fileTmpName);

        // Vérification du poids du fichier
        if ($fileSize < $minFileSize || $fileSize > $maxFileSize) {
            return "Erreur : Taille de fichier invalide. La taille du fichier doit être entre 1 Ko et 5 Mo.";
        }

        // Désinfection du nom du fichier
        $fileName = preg_replace('/[^A-Za-z0-9_\-.]/', '', $fileName);
        $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
        // Liste blanche des extensions
        if (!in_array(strtolower($fileExtension), $allowedExtensions)) {
            return "Erreur : Extension de fichier non autorisée.";
        }

        // Vérification du "Magic Number"
        $fileMimeType = mime_content_type($fileTmpName);
        $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif'];

        if (!in_array($fileMimeType, $allowedMimeTypes)) {
            return "Erreur : Type MIME non autorisé.";
        }

        // Génération d'un nom de fichier unique
        $uniqueFileName = uniqid() . '.' . $fileExtension;
        $targetPath = $uploadDirectory . "/" . $uniqueFileName;

        if ( $square ) {
            list($width, $height) = getimagesize($fileTmpName);
            if ($width != $height) {
                return "Erreur : L'image n'est pas carrée.";
            }
        }


            //destruction données exif
            if (in_array(strtolower($fileExtension), ['jpg', 'jpeg'])) { //TODO a voir si on garde des tests sur les
                $image = imagecreatefromjpeg($fileTmpName);             //extensions ou si on fait par rapport
                imagejpeg($image, $targetPath, 100);            // au mime type
                imagedestroy($image);
            } elseif (strtolower($fileExtension) == 'png') {
                $image = imagecreatefrompng($fileTmpName);
                imagepng($image, $targetPath, 9);
                imagedestroy($image);
            } elseif (strtolower($fileExtension) == 'gif') {
                $image = imagecreatefromgif($fileTmpName);
                imagegif($image, $targetPath);
                imagedestroy($image);
            } else {
                return "Erreur : bypass du type detecter" ;
            }


            if (move_uploaded_file($fileTmpName, $targetPath)) {
                // Vérification de la sécurité avec Google Cloud Vision
                $imageContent = file_get_contents($targetPath);
                //error_log('usage api');
                $url = 'https://vision.googleapis.com/v1/images:annotate?key=' . Constants::$API_KEY_GOOGLE_VISION;

                $requestData = ['requests' => [['image' => ['content' => base64_encode($imageContent)],
                    'features' => [['type' => 'SAFE_SEARCH_DETECTION']]]]];


                $options = ['http' => ['header' => 'Content-Type: application/json',
                    'method' => 'POST', 'content' => json_encode($requestData)]];

                $context = stream_context_create($options);
                $response = file_get_contents($url, false, $context);
                //error_log($response);
                $responseData = json_decode($response, true);
                //  error_log($responseData);
                if (isset($responseData['responses'][0]['safeSearchAnnotation']['adult'])) {
                    if ($responseData['responses'][0]['safeSearchAnnotation']['adult'] == 'VERY_LIKELY' || $responseData['responses'][0]['safeSearchAnnotation']['violence'] == 'VERY_LIKELY') {
                        unlink($targetPath); // Supprimez l'image non sécurisée
                        return "Erreur : L'image n'est pas sécurisée.";
                    } else {
                        error_log('image securisee');
                        return ["success",$uniqueFileName];
                    }
                } else {
                    unlink($targetPath); // Supprimez l'image non sécurisée
                    return "Erreur : Impossible de vérifier la sécurité de l'image.";
                }
            } else {

                return "Erreur : problème de téléchargement du fichier.";
            }

    }
}
