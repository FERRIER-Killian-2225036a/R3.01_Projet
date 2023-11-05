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
                            foreach($arrayOfPageId as $id){
                                $arrayOfBlogPageModel[] = new BlogPageModel($id);
                            }
                            MotorView::show('user/otherUser',array("User"=>$userModel,
                                "Postes"=>$arrayOfBlogPageModel
                                ));

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