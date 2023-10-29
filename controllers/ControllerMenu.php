<?php

class ControllerMenu
{
    public function DefaultAction(): void
    {
        header("Location: /");
        exit;
    }

    public function ActualityFeedAction(array $A_parametres = null, array $A_postParams = null): void
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
            MotorView::show('menu/actualityFeed', array("actualityTitle" => $obj->getTitle(), "actualityContent" => $obj->getContent(), "actualityAuthor" => $obj->getAuthor(), "actualityDate" => $obj->getDate(), "actualityUrlPicture" => $obj->getUrlPicture(), "actualityLien" => $obj->getLien()));
        }

    }

    public function BlogFeedAction(array $A_parametres = null, array $A_postParams = null): void
    {
        // TODO : récupérer les paramètres (afin de charger d'autres Blogs)
        //la requete ressemble à : GET /Menu/BlogFeed/More

        // TODO : récupérer les params (id) pour bookmark selon id
        //la requete ressemble à :  POST /Menu/BlogFeed/id

        // TODO : récupérer les params (new) pour créer un nouveau forum (redirection vers editBlog)
        //la requete ressemble à :  POST /Menu/BlogFeed/new

        // TODO : récuperer les params (tri) pour filtrer les résultats
        //la requete ressemble à :  POST /Menu/BlogFeed/Filter

        $page = new Blog_Page;

        $ArrayOf5IdByDate = $page->get5PagesByDate();
        $ArrayOfBlogPageModel = array();
        error_log(print_r($ArrayOf5IdByDate));
        foreach ($ArrayOf5IdByDate as $id) {
            $ArrayOfBlogPageModel[] = new BlogPageModel($id);
        }

        foreach ($ArrayOfBlogPageModel as $obj) {
            if ($obj->getStatusP() == "active") {
                MotorView::show('menu/blogFeed', array("blogPostUrl"=>$obj->getPostUrl(),"blogTitle" => $obj->getTITLE(), "blogContent" => $obj->getContent(), "blogAuthor" => $obj->getAuthor(), "blogDate" => $obj->getDateP(), "blogUrlPicture" => $obj->getUrlPicture())); // plus tard il faudra mettre si l'user a bien liké ou non
            }
        }
    }

    public function ForumFeedAction(array $A_parametres = null, array $A_postParams = null): void
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