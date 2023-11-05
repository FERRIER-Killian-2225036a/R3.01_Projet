<?php

// correspond a controller profil

/**
 * la Classe ControllerSettings gere  la gestion des informations utilisateurs et du paramétrage du compte
 *
 * on gere au niveau des parametres :
 * - gestion informations personnelles (Pseudo, mail, mdp, image de profil, [suppression du compte])
 * - gestions des tickets utilisateurs (demande de support & listes des tickets actifs selon leurs status)
 * - gestions de la langue (futur passage en anglais)
 * - gestions des themes (futur passage en theme sombre, voir changement des couleurs)
 *
 * - gestion des enregistrements (like)
 * - gestion des abonnements (follow)
 * - gestion des commentaires de l'utilisateur et des commentaires cités en réponse
 * - gestion des posts de l'utilisateur (suppression, changement de visibilité et redirection vers édition)
 *
 * @since 1.0
 * @package controller
 * @version 1.0
 * @category Settings
 * @author Tom Carvajal & Killian Ferrier
 */
class ControllerSettings
{
    /**
     * redirection lors de l'url null (ex : domaine/auth/ ? )
     *
     * @return void
     */
    public function DefaultAction(): void
    {
        header("Location: /Settings/ManageAccount");
        exit;
        //MotorView::show('profileSettings/manageAccount.php');
    }

    /**
     * Méthode pour afficher avec liaison du model (dans le futur) la vue bookmark (enregistrement)
     *
     * @return void
     */
    public function BookmarkAction(): void
    {
        if (!SessionManager::isUserConnected()) {
            header("Location: /Auth/login ");
            die();
        }
        MotorView::show('profileSettings/bookmark');
        $pageBlogBookmark = (new Blog_PageLike())->getAllPageLikeIdOfUser($_SESSION["UserId"]);

        $ArrayOfBlogPageModel = array();
        foreach ($pageBlogBookmark as $id) {
            $ArrayOfBlogPageModel[] = new BlogPageModel($id);
        }
        $listOfPageId = "";
        foreach ($ArrayOfBlogPageModel as $obj) {
            if ($obj->getStatusP() != "inactive") { // on va rajouter le lien d'édition
                $tagsList = "";
                foreach ($obj->getTags() as $tags) {
                    $tagsList .= "#" . $tags . " - ";
                }
                $listOfPageId .= $obj->getPageId().",";
                MotorView::show('profileSettings/postBlog', array("blogPostUrl" => $obj->getPostUrl(),
                    "blogTitle" => $obj->getTITLE(),
                    "blogContent" => $obj->getContent(), "blogAuthor" => $obj->getAuthor(),
                    "blogDate" => $obj->getDateP(), "blogUrlPicture" => $obj->getUrlPicture(),
                    "blogTags" => $tagsList, "id" => $obj->getPageId()));
            }
        }
        //TODO logique d'affichage des enregistrements (forum)
        ?>
        <script src='/common_scripts/redirect.js'></script>
        <script>
            console.log('<?php echo $listOfPageId; ?>')
            redirect('<?php echo $listOfPageId; ?>');
        </script>
        <?php
        echo '</div></div>';
        echo '<script src="/common_scripts/myPostDisplay.js"></script>';
        echo '<script src="/common_scripts/postOptions.js"></script>';
    }

    /**
     * Méthode pour afficher avec liaison du model (dans le futur) la vue follow (abonnement)
     *
     * @return void
     */
    public function FollowAction(): void
    {
        //TODO ajouté verification et logique d'affichage des abonnements
        if (SessionManager::isUserConnected()){
            $arrayOfFolledUser = (new FollowedUser())->getAllFollowedUser($_SESSION["UserId"]);
            $arrayOfUser = array();
            foreach ($arrayOfFolledUser as $user){
                $arrayOfUser[] = new USERSiteModel($user);
            }
            MotorView::show('profileSettings/follow', array("ArrayOfFollowedUser" => $arrayOfUser)     );

        } else {
            header("Location: /Auth/login ");
            die();
        }
    }

    /**
     * Méthode pour afficher avec liaison du model (dans le futur) la vue language (langue)
     * on pourra changer la langue du site (futur passage en anglais) ?
     * il faudra implementer un mécanisme type fichier.po pour la traduction
     * Demande une grande refactorisation des vues, voir une implémentation des liens pour le contenu a traduire
     * stocké dans la base de donnée ?
     *
     * @return void
     */
    public function LanguageAction(): void
    {
        //TODO ajouté verification et remodeler tout l'affichage pour la traduction
        if (SessionManager::isUserConnected()){
            MotorView::show('profileSettings/language');
        } else {
            header("Location: /Auth/login ");
            die();
        }
    }

    /**
     * Méthode pour afficher avec liaison du model (dans le futur) la vue manageAccount (gestion du compte)
     * on peut changer le pseudo, le mail, le mot de passe, l'image de profil
     * {et supprimer le compte (pas encore sure car contrainte bdd)}
     *
     * @param array|null $A_parametres
     * @param array|null $A_postParams
     * @return void
     */
    public function ManageAccountAction(array $A_parametres = null, array $A_postParams = null): void
    {
        if (SessionManager::isUserConnected()) {
            MotorView::show('profileSettings/manageAccount');
        } else {
            header("Location: /Auth/login");
            die();
        }
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            if (SessionManager::isUserConnected()) { //TODO reflechir a encore plus de sécurisation
                // premier post, on change l'image de profil de l'utilisateur dans le model par le fichier uploader
                if (isset($A_postParams["ChangeProfilePicture"])) {
                    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
                    $minFileSize = 1000; // Taille minimale en octets
                    $maxFileSize = 5000000; // Taille maximale en octets (ici, 5 Mo)
                    $uploadDirectory = Constants::mediaDirectoryUsers() . $_SESSION["UserId"];

                    if (!is_dir($uploadDirectory)) {
                        if (mkdir($uploadDirectory)) { // création dossier
                            error_log("Le dossier a été créé avec succès.");
                        } else {
                            error_log("Une erreur est survenue lors de la création du dossier.");
                        }
                    } else {
                        $nomFichier = $_SESSION["UrlPicture"];
                        if ($nomFichier !== null) { // on fait de la place sur le serveur
                            // on supprime toutes images sauf celle en cours d'utilisations
                            $files = glob($uploadDirectory . '/*'); // recup tout les noms des fichiers
                            foreach ($files as $file) { // parcours fichiers
                                if (is_file($file) && $file !== $nomFichier)
                                    unlink($file); // suppression
                            }
                        }
                    }

                    try {
                        $result = PictureVerificator::VerifyImg($_FILES['ProfilePicture'], $uploadDirectory,
                            $allowedExtensions, $minFileSize, $maxFileSize,true); //TODO redimensionner l'image automatiquement
                        if ($result[0] != "success") {
                            // TODO appel script js pour modifier la page avec un message d'erreur
                            $temp = '<script type="text/javascript">ShowLoginErrorMessage("' . $result[0] . '")</script>';
                            echo $result;
                            // throw new ExceptionsUpload($result);
                        } else {
                            (new UserSite)->update_picture($_SESSION["UserId"],
                                Constants::MEDIA_DIRECTORY_USERS . $_SESSION["UserId"] . "/" . $result[1]);
                            $_SESSION['UrlPicture'] = Constants::MEDIA_DIRECTORY_USERS . $_SESSION["UserId"] . "/" . $result[1];
                            //synchronisation de la session au niveau de l'image
                            header("Location: /Settings/ManageAccount"); // actualisation de la page
                        } // maj bdd de l'image

                    } catch (ExceptionsUpload $e) {
                        //TODO on pensera a afficher un message d'erreur sur le site
                        error_log($e->getMessage());
                    }

                } // deuxieme post, on supprime la photo
                elseif (isset($A_postParams["DeleteProfilePicture"])) {
                    $nomFichier = $_SESSION["UrlPicture"];
                    if ($nomFichier !== null) { // on fait de la place sur le serveur
                        // on supprime toutes images sauf celle en cours d'utilisations
                        $files = glob(Constants::mediaDirectoryUsers() . $_SESSION["UserId"] . '/*'); // recup tout les noms des fichiers
                        foreach ($files as $file) { // parcours fichiers
                            if (is_file($file) && $file !== $nomFichier)
                                unlink($file); // suppression
                        }
                    }
                    (new UserSite)->remove_picture($_SESSION["UserId"]);
                    $_SESSION['UrlPicture'] = null;
                    header("Location: /Settings/ManageAccount"); // actualisation de la page
                } // troisieme post, on change le pseudo
                elseif (isset($A_postParams["ChangeUsername"])) {

                    try {
                        $status = (new UserSite)->update_pseudo($_SESSION["UserId"], $A_postParams["username"]);
                        if (!($status instanceof ExceptionsDatabase)) {
                            $_SESSION['Username'] = $A_postParams["username"];
                            header("Location: /Settings/ManageAccount"); // actualisation de la page
                        } else {
                            throw $status;
                        }
                    } catch (ExceptionsDatabase $e) { //TODO il faudra afficher erreurs sur le site
                        echo $e->getMessage();
                        $temp = '<script type="text/javascript">ShowLoginErrorMessage("' . $e->getMessage() . '")</script>';
                        // error_log( "Error : " . $e->getMessage());
                    }
                } // quatrieme post, on change le mail
                elseif (isset($A_postParams["ChangeMail"])) {
                    try {
                        $status = (new UserSite)->update_mail($_SESSION["UserId"], $A_postParams["mail"]);
                        if (!($status instanceof ExceptionsDatabase)) {
                            $_SESSION['Mail'] = $A_postParams["mail"];
                            header("Location: /Settings/ManageAccount"); // actualisation de la page
                        } else {
                            throw $status;
                        }

                    } catch (ExceptionsDatabase $e) {
                        //echo $e->getMessage();
                        error_log("Error : " . $e->getMessage());
                    }
                } // quatrieme post, on change le mot de passe apres avoir verifier le mot de passe actuel
                elseif (isset($A_postParams["ChangePassword"])) {
                    try {
                        // on verif si l'ancien mdp est le bon
                        $result = (new UserSite)->checkPassword($_SESSION["UserId"], $A_postParams["oldPassword"]);
                        if (!$result) {
                            throw new ExceptionsDatabase("mot de passe incorrect");
                        }
                        // on essai de changer le mdp
                        $status = (new UserSite)->update_password($_SESSION["UserId"], $A_postParams["newPassword"]);
                        if (!($status instanceof ExceptionsDatabase)) {
                            header("Location: /Settings/ManageAccount"); // actualisation de la page
                        } else {
                            throw $status;
                        }


                    } catch (ExceptionsDatabase $e) {
                        //echo $e->getMessage();
                        error_log("Error : " . $e->getMessage());
                    }
                }

                // cinquieme post, on supprime le compte //TODO implementer plus tard
                // $status = (new UserSite)->remove_user($_SESSION["UserId"])); soucis, il faudrait verifier son mdp


            } else {
                error_log("warning : nobody is connected"); // TODO log
                header("Location: / ");
                exit;
            }
        }

    }

    /**
     * Méthode pour afficher avec liaison du model (dans le futur) la vue myComment (commentaire)
     *
     * @return void
     */
    public function MyCommentAction(): void
    {

        if (SessionManager::isUserConnected()){
            $arrayOfUserCommentId = (new Blog_Comment())->getAllCommentIdOfUser($_SESSION["UserId"]);
            $comments = array();
            foreach ($arrayOfUserCommentId as $commentId){
                $comments[] = new BlogCommentModel($commentId);
            }
            MotorView::show('profileSettings/myComment', array("ArrayOfComment" => $comments));
        } else {
            header("Location: /Auth/login ");
            die();
        }
        //TODO géré POST pour supprimer commentaire
    }


    /**
     * Méthode pour afficher avec liaison du model la vue myPost (post blog & plus tard aussi forum)
     *
     * @see BlogPageModel
     * @see Blog_Page
     * @return void
     */
    public function MyPostAction(): void
    {

        // on va recupere du model les blogs (plus tard les forums)
        // d'un membre selon son identifiant et les afficher sur sa page,
        if (!SessionManager::isUserConnected()) {
            header("Location: /Auth/login ");
            die();
        }
        MotorView::show('profileSettings/myPost');
        $pageBlog = new Blog_Page();
        $ArrayOf5IdByDate = $pageBlog->get5PagesByDate(null, $_SESSION["UserId"]);
        $ArrayOfBlogPageModel = array();
        foreach ($ArrayOf5IdByDate as $id) {
            $ArrayOfBlogPageModel[] = new BlogPageModel($id);
        }
        foreach ($ArrayOfBlogPageModel as $obj) {
            if ($obj->getStatusP() != "inactive") { // on va rajouter le lien d'édition
                $tagsList = "";
                foreach ($obj->getTags() as $tags) {
                    $tagsList .= "#" . $tags . " - ";
                }
                MotorView::show('profileSettings/postBlog', array("blogPostEditUrl" => $obj->getPostEditUrl(), "blogTitle" => $obj->getTITLE(),
                    "blogContent" => $obj->getContent(), "blogAuthor" => $obj->getAuthor(),
                    "blogDate" => $obj->getDateP(), "blogUrlPicture" => $obj->getUrlPicture(),
                    "blogTags" => $tagsList, "id" => $obj->getPageId(), "statusP" => $obj->getStatusP()));
            }
        }
        echo '</div></div>';
        echo '<script src="/common_scripts/myPostDisplay.js"></script>';
        echo '<script src="/common_scripts/postOptions.js"></script>';
        // recup requete, verif connexion + droits + propriétés
        // si la requete est une demande de modification de post, on va le rediriger selon l'identifiant de son poste
        // on aura donc notre logique de controlleur dans /Post/blog(ou forum)Edit

        // si la requete est une demande de changement de visibilité, on va changer la visibilité du model blogPage apres verif

    }

    /**
     * Méthode de gestion coté utilisateur des tickets de support depuis la vue des parametres
     * on peut créer un ticket de support, voir les tickets actifs, voir les tickets clos
     * on verifie que l'utilisateur est connecté, on verifie que la requete est bien un post,
     * on sécurise les inputs et on les envois au model pour créer un ticket de support
     *
     * @param array|null $A_parametres
     * @param array|null $A_postParams
     * @return void
     */
    public function SupportAction(array $A_parametres = null, array $A_postParams = null): void
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            if (SessionManager::isUserConnected()) {
                if (isset($A_postParams["SubmitSupport"]) && isset($A_postParams["Content"]) && isset($A_postParams["Subject"])) {
                    $Content = $A_postParams["Content"];
                    $Content = htmlspecialchars($Content);
                    $Subject = $A_postParams["Subject"];
                    $Subject = htmlspecialchars($Subject);
                    if (strlen($Subject) > 200) {
                        $Subject = substr($Subject, 0, 200);
                    }
                    if ($Subject != "" && $Content != "") {
                        $status = (new Ticket())->createTicket($_SESSION["Mail"], $Content, "inProgress", $Subject, $_SESSION["UserId"]);
                        if ($status != false) {
                            header("Location: /Settings/Support");
                            die();
                        } else {
                            error_log("error : ticket not created, issues with db");
                        }
                    } else {
                        error_log("error : ticket not created, empty fields");
                    }
                }
                (new UserSite)->incrementAlertLevelUser($_SESSION["UserId"]);
                error_log("error : invalid or malicious request");
            } else {
                header("Location: / ");
                die();
            }
        }
        if (SessionManager::isUserConnected()) {
            $tempTicket = new Ticket();
            $ArrayOfTicketId = $tempTicket->getAllTicketIdOfUser($_SESSION["UserId"]);
            $ArrayOfTicket = array();
            foreach ($ArrayOfTicketId as $id) {
                $ArrayOfTicket[] = new TicketModel($id);
            }
            MotorView::show('profileSettings/support', array("ArrayOfTicket" => $ArrayOfTicket));
        } else {
            header("Location: / ");
            die();
        }
    }

    public function ThemeAction(): void
    {
        if (SessionManager::isUserConnected()){
            MotorView::show('profileSettings/theme');
        } else {
            header("Location: /Auth/login ");
            die();
        }
    }

}
