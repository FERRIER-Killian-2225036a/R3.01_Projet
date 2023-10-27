<?php

class ControllerPost
{
    public function BlogEditAction(): void
    {
        MotorView::show('post/viewBlogEdit');
    }

}