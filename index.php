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
    print_r($S_urlADecortiquer);


    session_start();

    if ($S_urlADecortiquer != '' && $S_urlADecortiquer != '/' && $S_urlADecortiquer != 'Menu' &&
        $S_urlADecortiquer != 'Menu/HomeFeed' && $S_urlADecortiquer != 'Menu/ActualityFeed' &&
        $S_urlADecortiquer != 'Menu/BlogFeed' && $S_urlADecortiquer != 'Menu/ForumFeed' &&
        $S_urlADecortiquer != 'Auth' && $S_urlADecortiquer != 'Auth/Login' &&
        $S_urlADecortiquer != 'Auth/SignUp' )
    {
        if (!isset($_SESSION['user'])) {
            // L'utilisateur n'est pas authentifié, redirige vers la page de connexion

            header('Location: /Auth/Login');
            echo "on doit te rediriger";

            exit;
        }
    }

    try {
        $conn = DatabaseManager::getInstance();
    }
    catch (ExceptionsDatabase $O_exception) {
        echo ('Une erreur s\'est produite : ' . $O_exception->getMessage());
    }



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
