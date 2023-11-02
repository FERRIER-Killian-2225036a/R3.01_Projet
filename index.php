<?php
/**
 * Fichier index.php ( index ) point d'entrée de l'application.
 *
 * Ce fichier est le point d'entrée de l'application web.
 * Il initialise les ressources nécessaires, capture les paramètres d'URL et POST,
 * gère les erreurs et contrôle la logique de la page.
 *
 * @see MotorController
 * @see MotorView
 * @see DatabaseManager
 * @see Constants
 * @see AutoLoad
 * @see ExceptionsController
 *
 * @package App
 * @version 1.0
 * @category Point d'entrée
 * @since 1.0
 * @author Killian Ferrier and Tom Carvajal
 */

require 'core/AutoLoad.php';
Constants::defineFakeConst();


/*
 * Si aucune action spécifique n'est précisée, la page par défaut sera celle de la route /Menu/HomeFeed.
 * Convention : https://cyphub.tech/ControllerNom/NomAction/param1/param2/param3/...
 * Notre page par défaut est /, qui correspond à /Menu/HomeFeed.
 */

$S_urlADecortiquer = isset($_GET['url']) ? $_GET['url'] : null;
$mapOfPostParameters = isset($_POST) ? $_POST : null;

try {
    $conn = DatabaseManager::getInstance();
} catch (ExceptionsDatabase $O_exception) {
    //echo ('Une erreur s\'est produite lors de la connexion a la base: ' . $O_exception->getMessage());
    error_log('Une erreur s\'est produite lors de la connexion a la base: ' . $O_exception->getMessage());
}

MotorView::openBuffer(); // on ouvre le tampon d'affichage, les contrôleurs qui appellent des vues les mettront dedans
try {
    $O_controleur = new MotorController($S_urlADecortiquer, $mapOfPostParameters);
    $O_controleur->run();
} catch (ExceptionsController $O_exception) {
    header("HTTP/1.0 404 Not Found");
    //TODO page 404
    //echo ('Une erreur s\'est produite : ' . $O_exception->getMessage());
    error_log('Une erreur s\'est produite : ' . $O_exception->getMessage());
}

// Les différentes sous-vues ont été "crachées" dans le tampon d'affichage, on les récupère
$contentForShow = MotorView::getBufferContent();

// On affiche le contenu dans la partie body du gabarit général
MotorView::show('main', array('body' => $contentForShow));





