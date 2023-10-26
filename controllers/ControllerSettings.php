<?php

// correspond a controller profil
class ControllerSettings
{

    public function DefaultAction(): void
    {
        header("Location: /Settings/ManageAccount");
        //MotorView::show('profileSettings/manageAccount.php');
    }

    public function ManageAccountAction(Array $A_parametres = null,array $A_postParams = null): void
    {
        MotorView::show('profileSettings/manageAccount');
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            if (SessionManager::isUserConnected()) { //TODO reflechir a plus de sécurisation
                // premier post, on change l'image de profil de l'utilisateur dans le model par le fichier uploader
                if (isset($A_postParams["ChangeProfilePicture"])) {
                    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
                    $minFileSize = 1000; // Taille minimale en octets
                    $maxFileSize = 5000000; // Taille maximale en octets (ici, 5 Mo)
                    $uploadDirectory = Constants::mediaDirectoryUsers()  . $_SESSION["UserId"] ;

                    if (!is_dir($uploadDirectory)) {
                        if (mkdir($uploadDirectory)) { // création dossier
                            error_log("Le dossier a été créé avec succès.");
                        } else {
                            error_log("Une erreur est survenue lors de la création du dossier.");
                        }
                    }
                    else {
                        $nomFichier = $_SESSION["UrlPicture"];
                        if ( $nomFichier !== null ){ // on fait de la place sur le serveur
                            // on supprime toutes images sauf celle en cours d'utilisations
                            $files = glob($uploadDirectory . '/*'); // recup tout les noms des fichiers
                            foreach($files as $file){ // parcours fichiers
                                if(is_file($file) && $file !== $nomFichier)
                                    unlink($file); // suppression
                            }
                        }
                    }

                    try {
                        $result = PictureVerificator::VerifyImg($_FILES['ProfilePicture'], $uploadDirectory,
                                                                       $allowedExtensions, $minFileSize, $maxFileSize,true);
                        if ($result[0] != "success") {
                            // TODO appel script js pour modifier la page avec un message d'erreur
                            throw new ExceptionsUpload($result);
                        }
                        else {
                            (new UserSite)->update_picture($_SESSION["UserId"],
                                                Constants::MEDIA_DIRECTORY_USERS.$_SESSION["UserId"]."/".$result[1]);
                            $_SESSION['UrlPicture'] = Constants::MEDIA_DIRECTORY_USERS.$_SESSION["UserId"]."/".$result[1];
                            //synchronisation de la session au niveau de l'image
                        } // maj bdd de l'image

                    } catch (ExceptionsUpload $e) {
                        // on pensera a afficher un message d'erreur sur le site
                        error_log( $e->getMessage());
                    }

                } else {

                    echo "Une erreur est survenue lors de l'upload du fichier.";
                }
                // deuxieme post, on supprime la photo

                // troisieme post, on change le pseudo

                // quatrieme post, on change le mail

                // quatrieme post, on change le mot de passe

                // cinquieme post, on supprime le compte


            } else {
                error_log( "warning : nobody is connected"); // TODO log
                header("Location: / ");
            }
        }

    }


    public function LanguageAction(): void
    {
        MotorView::show('profileSettings/language');
    }
}

?>