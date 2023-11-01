<?php

/**
 *  Classe du controller responsable du lien vue/model de l'onglet menu mais surtout des différents feeds
 *
 * on gère ici le feed Actualité, le feed Blog (et le feed Forum pas encore implémenté)
 *
 * @since 1.0
 * @package controller
 * @version 1.0
 * @category menu
 * @author Killian Ferrier and Tom Carvajal
 *
 */
class ControllerMenu
{

    /**
     * Méthode par défaut du controller, on redirige vers la page d'accueil
     *
     * @see /controllers/ControllerDefault.php
     * @return void
     */
    public function DefaultAction(): void
    {
        header("Location: /");
        die();
    }

    /**
     * Méthode pour afficher la vue du feed d'actualité en récupérant les 5 derniers articles de notre scrappeur
     *
     * @link https://www.notion.so/tapes-de-d-veloppement-2c12d5d38de04394ab70ed95efcb0257?pvs=4#61f56df593594469982d463f68972133
     * @param array|null $A_parametres
     * @param array|null $A_postParams
     * @return void
     */
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

    /**
     *  Méthode pour afficher la vue du feed de blog en récupérant les 5 derniers posts publics de notre base de données
     *
     * on gère ici les request pour récupérer plus de blog,
     * on gère ici les request pour filtrer les blogs,
     * on gère ici les request pour liker/enregistrer un blog
     *
     *
     * @see /models/BlogPageModel.php
     * @see /models/Orm/Blog_Page.php
     * @param array|null $A_parametres
     * @param array|null $A_postParams
     * @return void
     */
    public function BlogFeedAction(array $A_parametres = null, array $A_postParams = null): void
    {
        // TODO : récupérer les paramètres (afin de charger d'autres Blogs)
        //la requete ressemble à : GET /Menu/BlogFeed/More

        // TODO : récupérer les params (id) pour bookmark selon id
        //la requete ressemble à :  POST /Menu/BlogFeed/id

        // TODO : récuperer les params (tri) pour filtrer les résultats
        //la requete ressemble à :  POST /Menu/BlogFeed/Filter

        $page = new Blog_Page;

        $ArrayOf5IdByDate = $page->get5PagesByDate();
        $ArrayOfBlogPageModel = array();
        foreach ($ArrayOf5IdByDate as $id) {
            $ArrayOfBlogPageModel[] = new BlogPageModel($id);
        }

        foreach ($ArrayOfBlogPageModel as $obj) {
            error_log("statusP : " . $obj->getStatusP());
            if ($obj->getStatusP() == "active") {
                $tagsList = "";
                foreach ($obj->getTags() as $tags ){
                    $tagsList .= "#".$tags ." - ";
                }
                MotorView::show('menu/blogFeed', array("blogPostUrl"=>$obj->getPostUrl(),
                                                                "blogTitle" => $obj->getTITLE(),
                                                                "blogContent" => $obj->getContent(),
                                                                "blogAuthor" => $obj->getAuthor(),
                                                                "blogDate" => $obj->getDateP(),
                                                                "blogUrlPicture" => $obj->getUrlPicture(),
                                                                "Tags"=>$tagsList)); // plus tard il faudra mettre si l'user a bien liké ou non
            }
        }
    }

    /**
     * Méthode pour afficher la vue du feed de forum en récupérant les 5 derniers posts publics de notre base de données
     *
     * @see /models/ForumPageModel.php // TODO : créer le ForumPageModel
     * @see /models/Orm/Forum_Page.php // TODO : créer le Forum_Page
     * @param array|null $A_parametres
     * @param array|null $A_postParams
     * @return void
     */
    public function ForumFeedAction(array $A_parametres = null, array $A_postParams = null): void
    {
        // TODO : récupérer les paramètres (afin de charger d'autres Forums)
        //la requete ressemble à : GET /Menu/ForumFeed/More

        // TODO : récupérer les params (id) pour bookmark selon id
        //la requete ressemble à :  POST /Menu/ForumFeed/id

        // TODO : récuperer les params (tri) pour filtrer les résultats
        //la requete ressemble à :  POST /Menu/ForumFeed/Filter

        MotorView::show('menu/forumFeed');
    }
}