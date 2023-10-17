<?php
// adaptation mvc, schéma figma correspond a controller menu action home feed
class ControllerDefault {
    public function DefaultAction(): void
    {
        MotorView::show('menu/homeFeed');
    }
}