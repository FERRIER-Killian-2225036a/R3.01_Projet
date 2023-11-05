<?php

/**
 * la classe ControllerUser gere les profils des autres utilisateurs
 *
 * ainsi, on se servira dans le futur de ce controller pour afficher les profils des autres utilisateurs
 * afin de voir leurs postes, leurs profils, pour pouvoir s'abonner, de filtrer le contenu...
 * Pour voir le nombre d'abonnées, de posts, d'abonnement. On pourra liker depuis la page, copier les liens
 * et accéder aux vues des postes
 *
 * @since 1.0
 * @package controller
 * @version 1.0
 * @category User
 * @author Tom Carvajal & Killian Ferrier
 */
class ControllerUser
{
    //follow pour post dans /User/Profil/{id}

    /**
     * Méthode par défaut du controller, on redirige vers la page /User/Profil
     *
     * @return void
     */
    public function DefaultAction(): void
    {
        header("Location: /User/Profil");
        die();
    }

    /**
     * Méthode pour afficher la vue du profil d'un user en mode spectateur
     *
     * @return void
     */
    public function ProfilAction(array $A_parametres = null, array $A_postParams = null): void
    {
        if (SessionManager::isUserConnected()) {
            if ($_SERVER["REQUEST_METHOD"] === "POST") {
                if ($A_parametres !== null && $A_parametres[0] !== null) {
                    $valideInt = filter_var($A_parametres[0], FILTER_VALIDATE_INT);
                    if ((new UserSite())->isUserIDExists($valideInt)) {
                        $userOfPage = new USERSiteModel($valideInt);
                        if (isset($A_postParams["follow"])) { //TODO verif bdd car dyslexie
                            if ($userOfPage->isFollowed( $_SESSION["UserId"])) {
                                $userOfPage->removeFollower( $_SESSION["UserId"]);
                            } else {
                                $userOfPage->addFollower( $_SESSION["UserId"]);
                            }
                            header("Location: /User/Profil/" . $valideInt);
                            die();

                        }
                    }

                }

            } else {
                if ($A_parametres !== null && $A_parametres[0] !== null) {
                    $valideInt = filter_var($A_parametres[0], FILTER_VALIDATE_INT);
                    if ((new UserSite())->isUserIDExists($valideInt)) {
                        $userModel = new USERSiteModel($valideInt);
                        $arrayOfPageId = (new Blog_Page())->get5PagesByDate(null, $valideInt);
                        $arrayOfBlogPageModel = array();
                        if ($userModel->getStatus()!="banned"){
                            MotorView::show('user/otherUser',array("User"=>$userModel));
                            foreach($arrayOfPageId as $id){
                                $arrayOfBlogPageModel[] = new BlogPageModel($id);
                            }
                            foreach ($arrayOfBlogPageModel as $obj) {
                                if ($obj->getStatusP() == "active") { // on va rajouter le lien d'édition
                                    $tagsList = "";
                                    foreach ($obj->getTags() as $tags) {
                                        $tagsList .= "#" . $tags . " - ";
                                    }
                                    MotorView::show('profileSettings/postBlog', array("blogTitle" => $obj->getTITLE(),
                                        "blogContent" => $obj->getContent(), "blogAuthor" => $obj->getAuthor(),
                                        "blogDate" => $obj->getDateP(), "blogUrlPicture" => $obj->getUrlPicture(),
                                        "blogTags" => $tagsList, "id" => $obj->getPageId()));
                                }
                            }
                            echo '</div></div>';
                            echo '<script>const dropdown = document.querySelectorAll(".dropdown"); for (let i = 1; i<dropdown.length; i++){dropdown[i].style.display = "none";};</script>';
                            ?>
                            <script src='/common_scripts/redirect.js'></script>
                            <script>
                                console.log('<?php echo $arrayOfPageId; ?>')
                                redirect('<?php echo $arrayOfPageId; ?>');
                                // Script pour le changement du bouton suivre
                                // Sélection du bouton suivre
                                const followedButton = document.getElementsByClassName('followButton');
                                // Récupération du boolen pour savoir si on suit l'utilisateur qui a posté
                                let boolIsFollowed = <?php echo $mapView['BoolIsFollowed'] ? 1 : 0 ?>; // TODO php mauvais user, a changer (author au lieu de user) pas sure a verif ?
                                // Condition si l'utilisateur est suivi
                                if (boolIsFollowed === 1) {
                                    for (let i = 0; i < followedButton.length; ++i) {
                                        // On change le texte du bouton
                                        followedButton[i].innerHTML = 'Suivi';
                                        // On met le fond en violet
                                        followedButton[i].style.backgroundColor = 'var(--purple)';
                                        // On met le texte en blanc
                                        followedButton[i].style.color = 'white';
                                    }
                                }
                            </script>
                            <?php
                            echo '</div></div>';
                            echo '<script src="/common_scripts/myPostDisplay.js"></script>';
                            echo '<script src="/common_scripts/maxTextSize.js"></script>';

                        }

                    }
                }
            }

        } else {
            header("Location: /Auth/Login");
            die();
        }

    }


}