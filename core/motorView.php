<?php
final class motorView
{
    public static function openBuffer(): void
    {
        // On démarre le tampon de sortie, on va l'appeler "tampon principal"
        ob_start();
    }

    public static function getBufferContent(): false|string
    {
        // On retourne le contenu du tampon principal
        return ob_get_clean();
    }

    public static function show ($viewPath, $mapOfModelContent = array()): void
    {
        $S_file = constants::viewsDirectory() . $viewPath . '.php';

        $mapView = $mapOfModelContent;
        // Démarrage d'un sous-tampon
        ob_start();
        include $S_file; // c'est dans ce fichier que sera utilisé A_vue, la vue est inclue dans le sous-tampon
        ob_end_flush();
    }
}