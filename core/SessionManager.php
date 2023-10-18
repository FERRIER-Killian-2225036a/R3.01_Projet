<?php

class SessionManager
{
    //TODO limité taille entrée utilisateur: pseudo, mail, password
    public static function SignUp($A_postParams)
    {
        $status = ((new UserSiteModel)->createUser(
            $A_postParams["pseudo"],
            $A_postParams["mail"],
            $A_postParams["password"]));

        if ($status instanceof ExceptionsDatabase) {
            return "Error : " . $status->getMessage();
        } else {
            session_start();
            $_SESSION["UserId"] = $status;
            $_SESSION['Ip'] = $_SERVER['REMOTE_ADDR'];
            $_SESSION['Username'] = strtolower($A_postParams['pseudo']);
            return "success";
        }
    }

    public static function Login($A_postParams)
    {
        // on vérifie qu'il n'y est pas une session active
        if (session_status()==PHP_SESSION_ACTIVE){
            if (isset($_SESSION["UserId"])) {
                //on redirege vers la page d'accueil
                header("Location: /");
            }
            return "success";
        }
        else {
            // essai de se connecter

            // TODO to change
            $status = ((new UserSiteModel)->loginUser(
                $A_postParams["mail"],
                $A_postParams["password"]));

            if ($status instanceof ExceptionsDatabase) {
                return "Error : " . $status->getMessage();
            } else {

                return "success";

            }
        }
    }

    public static function disconnect()
    {   //TODO CORRIGER CA
        if (session_status()==PHP_SESSION_ACTIVE){
            if (isset($_SESSION["UserId"])) {
                $id = $_SESSION["UserId"];
                ((new UserSiteModel)->disconnectUser($id));
                session_unset();
                session_destroy();
                header("Location: /");
            }
        }else {
            session_start();
            session_unset();
            session_destroy();
            header("Location: /");
        }
    }
    public static function logout() //alias
    {
        self::disconnect();
    }
}