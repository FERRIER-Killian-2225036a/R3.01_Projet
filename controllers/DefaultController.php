<?php
class defaultController {
    public function DefaultAction(): void
    {
        MotorView::show('menu/homeFeed');
    }
}