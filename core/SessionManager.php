<?php

class SessionManager
{

    public static function SignUp($A_postParams)
    {
        $status = ((new UserSiteModel)->createUser(
            $A_postParams["pseudo"],
            $A_postParams["mail"],
            $A_postParams["password"]));

        if ($status instanceof ExceptionsDatabase) {
            return "Error : " . $status->getMessage();
        } else {
            return "success";
        }
    }
}