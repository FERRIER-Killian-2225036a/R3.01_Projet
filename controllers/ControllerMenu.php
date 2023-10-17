<?php

class ControllerMenu
{
    public function DefaultAction(): void
    {
        MotorView::show('menu/homeFeed');
    }
    public function ActualityFeedAction(): void
    {
        MotorView::show('menu/actualityFeed');
    }
    public function BlogFeedAction(): void  
    {
        MotorView::show('menu/blogFeed');
    }
    public function ForumFeedAction(): void
    {
        MotorView::show('menu/forumFeed');
    }
}