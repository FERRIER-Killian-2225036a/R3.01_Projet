<?php
// Ce fichier est le point d'entrée de votre application

    require 'core/AutoLoad.php';
    /*
     url pour notre premier test MVC Hello World,
     nous n'avons pas d'action précisée on visera celle par défaut
     /index.php?ctrl=helloworld
     /helloworld
     /controleur/nom_action/whatever/whatever2/

    */
/*
    $S_controleur = isset($_GET['ctrl']) ? $_GET['ctrl'] : null;
    $S_action = isset($_GET['action']) ? $_GET['action'] : null;

    Vue::ouvrirTampon(); //  /Noyau/Vue.php : on ouvre le tampon d'affichage, les contrôleurs qui appellent des vues les mettront dedans
    $O_controleur = new Controleur($S_controleur, $S_action);
*/
    //print_r($_GET);

    $S_urlADecortiquer = isset($_GET['url']) ? $_GET['url'] : null;
    $mapOfPostParameters = isset($_POST) ? $_POST : null;
    //print_r($S_urlADecortiquer);

MotorView::openBuffer(); // on ouvre le tampon d'affichage, les contrôleurs qui appellent des vues les mettront dedans
    try
    {
        $O_controleur = new MotorController($S_urlADecortiquer, $mapOfPostParameters);
        $O_controleur->run();
    }
    catch (ExceptionsController $O_exception)
    {
        echo ('Une erreur s\'est produite : ' . $O_exception->getMessage());
    }


    // Les différentes sous-vues ont été "crachées" dans le tampon d'affichage, on les récupère
    $contentForShow = MotorView::getBufferContent();

    // On affiche le contenu dans la partie body du gabarit général
    MotorView::show('main', array('body' => $contentForShow));
