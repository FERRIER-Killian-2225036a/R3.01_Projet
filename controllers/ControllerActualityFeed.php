<?php
//deprecated seulement le temps de modifier les actions dans controller menu
class ControllerActualityFeed {
    public function DefaultAction(): void
    {
        MotorView::show('menu/actualityFeed');
    }
}