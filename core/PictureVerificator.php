<?php

class PictureVerificator
{
    public static function handleFileUpload($file, $uploadDirectory, $allowedExtensions, $minFileSize, $maxFileSize) {
        error_log('handleFileUpload');
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
        $fileName = preg_replace('/[^A-Za-z0-9_\-\.]/', '', $fileName);
        $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
        error_log("desinfection du nom du fichier");
        // Liste blanche des extensions
        if (!in_array(strtolower($fileExtension), $allowedExtensions)) {
            return "Erreur : Extension de fichier non autorisée.";
        }

        // Vérification de la magie (Magic Number)
        $fileMimeType = mime_content_type($fileTmpName);
        $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif'];

        if (!in_array($fileMimeType, $allowedMimeTypes)) {
            return "Erreur : Type MIME non autorisé.";
        }

        // Génération d'un nom de fichier unique
        $uniqueFileName = uniqid() . '.' . $fileExtension;
        $targetPath = $uploadDirectory . $uniqueFileName;
        error_log("generation d'un nom de fichier unique");

        if (move_uploaded_file($fileTmpName, $targetPath)) {
            // Vérification de la sécurité avec Google Cloud Vision
            $imageContent = file_get_contents($targetPath);
            error_log('usage api');
            $url = 'https://vision.googleapis.com/v1/images:annotate?key=' . Constants::API_KEY_GOOGLE_VISION;

            $requestData = ['requests' => [['image' => ['content' => base64_encode($imageContent)],
                            'features' => [['type' => 'SAFE_SEARCH_DETECTION']]]]];


            $options = ['http' => ['header' => 'Content-Type: application/json',
                       'method' => 'POST','content' => json_encode($requestData)]];

            $context = stream_context_create($options);
            $response = file_get_contents($url, false, $context);
            error_log($response);
            $responseData = json_decode($response, true);
            //  error_log($responseData);
            if (isset($responseData['responses'][0]['safeSearchAnnotation']['adult'])) {
                if ($responseData['responses'][0]['safeSearchAnnotation']['adult'] == 'VERY_LIKELY' || $responseData['responses'][0]['safeSearchAnnotation']['violence'] == 'VERY_LIKELY') {
                    unlink($targetPath); // Supprimez l'image non sécurisée
                    return "Erreur : L'image n'est pas sécurisée.";
                } else {
                    error_log('image securisee');
                    return "success";
                }
            } else {
                unlink($targetPath); // Supprimez l'image non sécurisée
                return "Impossible de vérifier la sécurité de l'image.";
            }
        } else {

            return "Une erreur est survenue lors du téléchargement du fichier.";
        }
    }
}