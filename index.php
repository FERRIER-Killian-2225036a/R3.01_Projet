<?php
// Ce fichier est le point d'entrée de notre application

    require 'core/AutoLoad.php';
    Constants::defineFakeConst();


    /*
    si nous n'avons pas d'action précisée on visera celle par défaut
    convention :
    https://cyphub.tech/ControllerNom/NomAction/param1/param2/param3/...
    Notre page par default est / qui correspond a /Menu/HomeFeed
    */

    $S_urlADecortiquer = isset($_GET['url']) ? $_GET['url'] : null;
    $mapOfPostParameters = isset($_POST) ? $_POST : null;

    try {
        $conn = DatabaseManager::getInstance();
    }
    catch (ExceptionsDatabase $O_exception) {
        //echo ('Une erreur s\'est produite lors de la connexion a la base: ' . $O_exception->getMessage());
        error_log('Une erreur s\'est produite lors de la connexion a la base: ' . $O_exception->getMessage());
    }

    MotorView::openBuffer(); // on ouvre le tampon d'affichage, les contrôleurs qui appellent des vues les mettront dedans
    try
    {
        $O_controleur = new MotorController($S_urlADecortiquer, $mapOfPostParameters);
        $O_controleur->run();
    }
    catch (ExceptionsController $O_exception)
    {
        header("HTTP/1.0 404 Not Found");
        //echo ('Une erreur s\'est produite : ' . $O_exception->getMessage());
        error_log('Une erreur s\'est produite : ' . $O_exception->getMessage());

    }

    // Les différentes sous-vues ont été "crachées" dans le tampon d'affichage, on les récupère
    $contentForShow = MotorView::getBufferContent();

    // On affiche le contenu dans la partie body du gabarit général
    MotorView::show('main', array('body' => $contentForShow));





