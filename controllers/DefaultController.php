<?php
class DefaultController {
    public function DefaultAction(): void
    {
        MotorView::show('menu/homeFeed');
    }
}