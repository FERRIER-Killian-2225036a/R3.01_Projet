<?php

/**
 * Classe du controller responsable du lien vue/model de l'authentification, ainsi que la récupération d'input
 *
 * cette classe s'occupe de permettre l'authentification (login/sign up/log out) et la récupération de mot de passe,
 * elle est en étroite collaboration avec l'utilitaire du noyau SessionManager, on s'occupe aussi de la récupération
 * des messages d'erreurs pour les afficher dans les vues
 *
 * @see SessionManager
 * @since 1.0
 * @package controller
 * @category authentification
 * @version 1.0
 * @author Tom Carvajal
 */
class ControllerAuth
{
    /**
     * Méthode par défaut du controller, on affiche la vue de login
     *
     * @return void
     */
    public function DefaultAction(): void
    {

        MotorView::show('authentification/login');
    }

    /**
     * Méthode pour afficher la vue de login & essayer de s'authentifier selon les parametres de la requete post
     *
     * @param array|null $A_parametres
     * @param array|null $A_postParams
     * @return void
     */
    public function LoginAction(Array $A_parametres = null, Array $A_postParams = null): void
    {
        MotorView::show('authentification/login');
        if ($_SERVER["REQUEST_METHOD"] ==="POST")
        {
            if (isset($A_postParams["mail"]) && isset($A_postParams["password"])) {
                $status = SessionManager::Login($A_postParams);

                //status = success / erreur type
                if ($status=="success"){
                    //redirection vers page de login
                    header("Location: /");
                    exit;
                }
                else{
                    // affichage message d'erreur a deplacé ?
                    $temp ='<script type="text/javascript">ShowLoginErrorMessage("'.$status.'")</script>';
                    //MotorView::show('authentification/login',Array('script'=>$temp));
                    echo $temp;
                }
            }
            else {
                // message pour demander de remplir les champs
                echo "remplir les champs";
            }
        }
    }

    /**
     * Méthode pour afficher la vue de sign up & essayer de creer son compte selon les parametres de la requete post
     *
     * @param array|null $A_parametres
     * @param array|null $A_postParams
     * @return void
     */
    public function SignUpAction(Array $A_parametres = null, Array $A_postParams = null): void
    {
        MotorView::show('authentification/signUp');

        if ($_SERVER["REQUEST_METHOD"] ==="POST")
        {
            if (isset($A_postParams["mail"]) && isset($A_postParams["pseudo"]) && isset($A_postParams["password"])) {
                $status = SessionManager::SignUp($A_postParams);
                //status = success / erreur type
                if ($status=="success"){
                    //redirection vers page de login
                    header("Location: /");
                    exit;
                }
                else{
                    // affichage message d'erreur a deplacé ?
                    $temp ='<script type="text/javascript">ShowLoginErrorMessage("'.$status.'")</script>';
                    echo $temp;
                }
            }
            else {
                // message pour demander de remplir les champs
                echo "remplir les champs";
            }
        }
    }

    /**
     * Méthode pour se déconnecter.
     *
     * @return void
     */
    public function LogOutAction(): void
    {
        SessionManager::logout();
    }

    /**
     * Méthode pour afficher la vue de récupération de mot de passe & essayer de le récupérer selon les parametres de la requete post
     *
     * @param array|null $A_parametres
     * @param array|null $A_postParams
     * @return void
     */
    public function ForgotPasswordAction(Array $A_parametres = null, Array $A_postParams = null): void
    {
        //TODO implementer la logique de récupération de mot de passe
        MotorView::show('authentification/forgotPassword');
    }

    /*
    public function ChangePasswordAction(Array $A_parametres = null, Array $A_postParams = null): void
    {
        MotorView::show('authentification/changePassword');
    }*/

}