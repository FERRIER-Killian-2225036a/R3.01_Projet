<?php

/**
 * la classe MotorView est une classe PRINCIPALE du framework, elle est responsable de l'affichage en buffer et appelle les différentes vues
 * depuis les controllers
 *
 * @see index.php
 * @see /views
 *
 *
 * @package core
 * @since 1.0
 * @version 1.0
 * @category motorView
 * @author Tom Carvajal & Killian Ferrier
 */
final class MotorView
{
    /**
     * cette methode permet d'ouvrir un tampon de sortie, afin de pouvoir l'afficher plus tard
     *
     * @return void
     */
    public static function openBuffer(): void
    {
        // On démarre le tampon de sortie, on va l'appeler "tampon principal"
        ob_start();
    }

    /**
     * cette methode permet de retourner le contenu du tampon principal
     *
     * @return false|string
     */
    public static function getBufferContent(): false|string
    {
        // On retourne le contenu du tampon principal
        return ob_get_clean();
    }

    /**
     * cette methode permet d'afficher le contenu du tampon principal
     *
     * Note : $mapView contiendra des données dans un tableau associatif qui serra énormément utilisé dans les vues
     *
     * @param string $viewPath
     * @param array $mapOfModelContent
     * @return void
     */
    public static function show (string $viewPath, array $mapOfModelContent = array()): void
    {
        $S_file = constants::viewsDirectory() . $viewPath . '.php';

        $mapView = $mapOfModelContent;
        // Démarrage d'un sous-tampon
        ob_start();
        include $S_file; // c'est dans ce fichier que sera utilisé mapView, la vue est inclue dans le sous-tampon
        ob_end_flush();
    }
}