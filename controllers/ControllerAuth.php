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
        //print_r($A_parametres);
        print_r($A_postParams);
        MotorView::show('authentification/login');
    }

    public function SignUpAction(Array $A_parametres = null, Array $A_postParams = null): void
    {
        MotorView::show('authentification/signUp');
        if (isset($A_postParams["mail"]) && isset($A_postParams["pseudo"]) && isset($A_postParams["password"])) {
            (new UserSiteModel)->createUser($A_postParams["pseudo"], $A_postParams["test"], $A_postParams["password"]);
            echo "success";
        }
        echo "erreur :c";
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