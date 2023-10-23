<?php

class ControllerMenu
{
    public function DefaultAction(): void
    {
        header("Location: /");
    }
    public function ActualityFeedAction(Array $A_parametres = null, Array $A_postParams = null): void
    {
        //print_r($A_parametres);
        //print_r($A_postParams);
        // TODO : récupérer les paramètres (afin de charger d'autres Articles)
        //la requete ressemble à : GET /Menu/ActualityFeed/More
        $page = new ITPage;

        $ArrayOf5IdByDate = $page->get5PagesByDate();
        $ArrayOfITPageModel = array();
        foreach ($ArrayOf5IdByDate as $id) {
            $ArrayOfITPageModel[] = new ITPageModel($id);
        }

        foreach ($ArrayOfITPageModel as $obj) {
            MotorView::show('menu/actualityPost', array("actualityTitle"=>$obj->getTitle()));
            MotorView::show('menu/actualityPost', array("actualityContent"=>$obj->getContent()));
            MotorView::show('menu/actualityPost', array("actualityAuthor"=>$obj->getAuthor()));
            MotorView::show('menu/actualityPost', array("actualityDate"=>$obj->getDate()));
            MotorView::show('menu/actualityPost', array("actualityUrlPicture"=>$obj->getUrlPicture()));
            MotorView::show('menu/actualityPost', array("actualityLien"=>$obj->getLien()));
        }

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