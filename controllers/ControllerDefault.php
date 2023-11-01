<?php
// adaptation mvc, schéma figma correspond a controller menu action home feed

/**
 *  Classe du controller responsable du lien vue/model de l'onglet menu (page par défault lorsque l'url est vide)
 *
 * @since 1.0
 * @package controller
 * @version 1.0
 * @category menu
 * @author Killian Ferrier & Tom Carvjal
 *
 */
class ControllerDefault {
    public function DefaultAction(): void
    {
        MotorView::show('menu/homeFeed');
    }
}