<?php

/**
 * La classe PictureVerificator est un utilitaire pour la vérification des images uploadées.
 *
 * Cette classe s'occupe de vérifier les images uploadées par les utilisateurs, elle vérifie la taille,
 * si elles sont sûres au niveau du contenu (via l'API Google Cloud Vision) [adulte, violence, etc...],
 * le type (vérification Mime type, extension, Magic Number),
 * gère aussi l'unicité du nom du fichier (pour éviter les collisions),
 * détruit les données EXIF des images pour éviter les attaques de type exif injection
 * et l'usage d'OSINT qui pourrait amener à des fuites potentielles d'informations.
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
     * Méthode pour vérifier la sécurisation des images uploadées.
     *
     * @param array $file
     * @param string $uploadDirectory
     * @param array $allowedExtensions
     * @param int $minFileSize
     * @param int $maxFileSize
     * @param bool $square
     * @return array|string
     */
    public static function VerifyImg(array $file, string $uploadDirectory, array $allowedExtensions, int $minFileSize, int $maxFileSize, bool $square = false): array|string
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

        // Destruction des données EXIF
        $image = null;
        if (in_array(strtolower($fileExtension), ['jpg', 'jpeg'])) {
            $image = imagecreatefromjpeg($fileTmpName);
        } elseif (strtolower($fileExtension) == 'png') {
            $image = imagecreatefrompng($fileTmpName);
        } elseif (strtolower($fileExtension) == 'gif') {
            $image = imagecreatefromgif($fileTmpName);
        }

        if ($image !== null) {
            // Suppression des données EXIF
            imagejpeg($image, $fileTmpName, 100);
            imagedestroy($image);
        } else {
            return "Erreur : type de fichier non pris en charge";
        }

        if ($square) {
            $image = imagecreatefromstring(file_get_contents($targetPath));
            $imageWidth = imagesx($image);
            $imageHeight = imagesy($image);
            $size = min($imageWidth, $imageHeight);

            // Crée une nouvelle image carrée vide
            $squareImage = imagecreatetruecolor($size, $size);

            // Copie la partie centrale de l'image originale dans l'image carrée
            $x = 0;
            $y = 0;
            if ($imageWidth > $imageHeight) {
                $x = ($imageWidth - $imageHeight) / 2;
            } elseif ($imageHeight > $imageWidth) {
                $y = ($imageHeight - $imageWidth) / 2;
            }
            imagecopy($squareImage, $image, 0, 0, $x, $y, $size, $size);
            imagejpeg($squareImage, $fileTmpName, 100);
            imagedestroy($image);
            imagedestroy($squareImage);
        }

        if (move_uploaded_file($fileTmpName, $targetPath)) {
            // Vérification de la sécurité avec Google Cloud Vision
            $imageContent = file_get_contents($targetPath);
            $url = 'https://vision.googleapis.com/v1/images:annotate?key=' . Constants::$API_KEY_GOOGLE_VISION;

            $requestData = [
                'requests' => [
                    [
                        'image' => ['content' => base64_encode($imageContent)],
                        'features' => [['type' => 'SAFE_SEARCH_DETECTION']]
                    ]
                ]
            ];

            $options = [
                'http' => [
                    'header' => 'Content-Type: application/json',
                    'method' => 'POST',
                    'content' => json_encode($requestData)
                ]
            ];

            $context = stream_context_create($options);
            $response = file_get_contents($url, false, $context);
            $responseData = json_decode($response, true);

            if (
                isset($responseData['responses'][0]['safeSearchAnnotation']['adult']) &&
                ($responseData['responses'][0]['safeSearchAnnotation']['adult'] === 'VERY_LIKELY' ||
                    $responseData['responses'][0]['safeSearchAnnotation']['violence'] === 'VERY_LIKELY')
            ) {
                unlink($targetPath); // Supprimez l'image non sécurisée
                return "Erreur : L'image n'est pas sécurisée.";
            } else {
                return ["success", $uniqueFileName];
            }
        } else {
            return "Erreur : problème de téléchargement du fichier.";
        }
    }
}
