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
    public function ProfilAction(): void{
        if (SessionManager::isUserConnected()){
            MotorView::show('user/otherUser');
        } else {
            header("Location: /Auth/Login");
            die();
        }

    }



}