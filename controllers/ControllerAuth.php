<?php

class ControllerAuth
{
// methode static ?
    public function DefaultAction(): void
    {

        MotorView::show('auth/login');
    }

    public function LoginAction(Array $A_parametres = null, Array $A_postParams = null): void
    {

        MotorView::show('auth/login');
    }

    public function SignUpAction(Array $A_parametres = null, Array $A_postParams = null): void
    {

        MotorView::show('auth/signUp');
    }

    public function LogoutAction(Array $A_parametres = null, Array $A_postParams = null): void
    {

        MotorView::show('auth/logout');
    }

    public function ForgotPasswordAction(Array $A_parametres = null, Array $A_postParams = null): void
    {

        MotorView::show('auth/forgotPassword');
    }
    public function ChangePasswordAction(Array $A_parametres = null, Array $A_postParams = null): void
    {

        MotorView::show('auth/changePassword');
    }

}