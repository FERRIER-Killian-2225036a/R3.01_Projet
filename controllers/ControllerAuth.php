<?php

class ControllerAuth
{
// methode static ?
    public function DefaultAction(): void
    {

        MotorView::show('authentication/login');
    }

    public function LoginAction(Array $A_parametres = null, Array $A_postParams = null): void
    {

        MotorView::show('authentication/login');
    }

    public function SignUpAction(Array $A_parametres = null, Array $A_postParams = null): void
    {

        MotorView::show('authentication/signUp');
    }

    public function LogoutAction(Array $A_parametres = null, Array $A_postParams = null): void
    {

        MotorView::show('authentication/logout');
    }

    public function ForgotPasswordAction(Array $A_parametres = null, Array $A_postParams = null): void
    {

        MotorView::show('authentication/forgotPassword');
    }
    public function ChangePasswordAction(Array $A_parametres = null, Array $A_postParams = null): void
    {

        MotorView::show('authentication/changePassword');
    }

}