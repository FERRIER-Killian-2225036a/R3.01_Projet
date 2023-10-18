<?php

class ControllerAuth
{
// methode static ?
    public function DefaultAction(): void
    {

        MotorView::show('authentification/login');
    }

    public function LoginAction(Array $A_parametres = null, Array $A_postParams = null): void
    {
        MotorView::show('authentification/login');
        //print_r($A_parametres);
        print_r($A_postParams);
        if ($_SERVER["REQUEST_METHOD"] ==="POST")
        {
            if (isset($A_postParams["mail"]) && isset($A_postParams["password"])) {
                $status = SessionManager::Login($A_postParams);

                //status = success / erreur type
                if ($status=="success"){
                    //redirection vers page de login
                    echo "success";
                    header("Location: /");
                }
                else{
                    // affichage message d'erreur a deplacé ?
                    echo $status;
                }
            }
            else {
                // message pour demander de remplir les champs
                echo "remplir les champs";
            }
        }
    }

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
                }
                else{
                    // affichage message d'erreur a deplacé ?
                    echo $status;
                }
            }
            else {
                // message pour demander de remplir les champs
                echo "remplir les champs";
            }
        }
    }
    public function LogoutAction(Array $A_parametres = null, Array $A_postParams = null): void
    {

        //MotorView::show('authentification/logout');
    }

    public function ForgotPasswordAction(Array $A_parametres = null, Array $A_postParams = null): void
    {

        MotorView::show('authentification/forgotPassword');
    }
    public function ChangePasswordAction(Array $A_parametres = null, Array $A_postParams = null): void
    {

        MotorView::show('authentification/changePassword');
    }

}