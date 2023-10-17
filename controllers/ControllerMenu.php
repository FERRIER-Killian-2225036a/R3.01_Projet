<?php

class ControllerMenu
{
    public function DefaultAction(): void
    {
        MotorView::show('menu/homeFeed');
    }
    public function ActualityFeedAction(): void
    {
        //TO-DO : récupérer les paramètres (afin de charger d'autres Articles)
        //la requete ressemble à : GET /Menu/ActualityFeed/More

        MotorView::show('menu/actualityFeed');
    }
    public function BlogFeedAction(): void
    {
        //TO-DO : récupérer les paramètres (afin de charger d'autres Blogs)
        //la requete ressemble à : GET /Menu/BlogFeed/More

        //TO-DO : récupérer les params (id) pour bookmark selon id
        //la requete ressemble à :  POST /Menu/BlogFeed/id

        //TO-DO : récupérer les params (new) pour créer un nouveau forum (redirection vers editBlog)
        //la requete ressemble à :  POST /Menu/BlogFeed/new

        //TO-DO : récuperer les params (tri) pour filtrer les résultats
        //la requete ressemble à :  POST /Menu/BlogFeed/Filter
        MotorView::show('menu/blogFeed');
    }
    public function ForumFeedAction(): void
    {
        //TO-DO : récupérer les paramètres (afin de charger d'autres Forums)
        //la requete ressemble à : GET /Menu/ForumFeed/More

        //TO-DO : récupérer les params (id) pour bookmark selon id
        //la requete ressemble à :  POST /Menu/ForumFeed/id

        //TO-DO : récupérer les params (new) pour créer un nouveau forum (redirection vers editBlog)
        //la requete ressemble à :  POST /Menu/ForumFeed/new

        //TO-DO : récuperer les params (tri) pour filtrer les résultats
        //la requete ressemble à :  POST /Menu/ForumFeed/Filter

        MotorView::show('menu/forumFeed');
    }
}