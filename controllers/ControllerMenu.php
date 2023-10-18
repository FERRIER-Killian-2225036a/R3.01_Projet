<?php

class ControllerMenu
{
    public function DefaultAction(): void
    {
        MotorView::show('menu/homeFeed');
    }
    public function ActualityFeedAction(Array $A_parametres = null, Array $A_postParams = null): void
    {
        //print_r($A_parametres);
        //print_r($A_postParams);
        // TODO : récupérer les paramètres (afin de charger d'autres Articles)
        //la requete ressemble à : GET /Menu/ActualityFeed/More

        MotorView::show('menu/actualityFeed');
    }
    public function BlogFeedAction(Array $A_parametres = null, Array $A_postParams = null): void
    {
        // TODO : récupérer les paramètres (afin de charger d'autres Blogs)
        //la requete ressemble à : GET /Menu/BlogFeed/More

        // TODO : récupérer les params (id) pour bookmark selon id
        //la requete ressemble à :  POST /Menu/BlogFeed/id

        // TODO : récupérer les params (new) pour créer un nouveau forum (redirection vers editBlog)
        //la requete ressemble à :  POST /Menu/BlogFeed/new

        // TODO : récuperer les params (tri) pour filtrer les résultats
        //la requete ressemble à :  POST /Menu/BlogFeed/Filter
        MotorView::show('menu/blogFeed');
    }
    public function ForumFeedAction(Array $A_parametres = null, Array $A_postParams = null): void
    {
        // TODO : récupérer les paramètres (afin de charger d'autres Forums)
        //la requete ressemble à : GET /Menu/ForumFeed/More

        // TODO : récupérer les params (id) pour bookmark selon id
        //la requete ressemble à :  POST /Menu/ForumFeed/id

        // TODO : récupérer les params (new) pour créer un nouveau forum (redirection vers editBlog)
        //la requete ressemble à :  POST /Menu/ForumFeed/new

        // TODO : récuperer les params (tri) pour filtrer les résultats
        //la requete ressemble à :  POST /Menu/ForumFeed/Filter

        MotorView::show('menu/forumFeed');
    }
}