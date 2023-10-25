<?php
// correspond a controller profil
class ControllerSettings
{

    public function DefaultAction(): void
    {
        header("Location: /Settings/ManageAccount");
        //MotorView::show('profileSettings/manageAccount.php');
    }

    public function ManageAccountAction(): void
    {
        MotorView::show('profileSettings/manageAccount');
    }

}
?>