<?php


/**
 * La classe SearchModel est responsable du lien Model / vue pour la recherche situé dans le header
 *
 * On gere l'affichage de suggestion de lien selon le role utilisateur, ainsi un modo peut chercher
 * une ip par exemple, mais un utilisateur lambda ne peut pas et est limité a certaines zone de la bdd
 *
 * Recherche -> (connecté & modo)
 * [IT_Articles] -> title, content.
 * [USERSite] -> Pseudo , Mail, UserID, LastIpAdress
 * [FORUM_Page] -> title, message.
 * [FORUM_Comment] -> textComment
 * [FORUM_Category] -> label, description
 * [Blog_Page] -> TITLE, content.
 * [BLOG_Comment] -> textC
 * [BLOG_Category] -> label, description
 * [BLACKLIST] -> UserID["pseudo"] ,Reason
 * [METE] -> UserID["pseudo"],Reason
 *
 * Recherche -> (connecté)
 * [IT_Articles] -> title, content.
 * [USERSite] -> Pseudo                    si mec pas BlackList
 * [FORUM_Page] -> title, message.         si status == "active"
 * [FORUM_Comment] -> textComment          si status.Page == "active"
 * [FORUM_Category] -> label, description
 * [Blog_Page] -> TITLE, content.          si status.Page == "active"
 * [BLOG_Comment] -> textC                 si status.Page == "active"
 * [BLOG_Category] -> label, description
 *
 * Recherche -> (pas connecté)
 * [IT_Articles] -> title, content.
 * [USERSite] -> Pseudo                    si mec pas BlackList
 *
 * @package models
 * @since 1.0
 * @version 1.0
 * @category search
 * @author Tom Carvajal
 */
class SearchModel
{
    /**
     * @var array $arrayOfResult contient les resultats de la recherche
     */
    private array $arrayOfResult = array();

    /**
     * méthode de recherche pour les utilisateurs non connectés
     *
     * @param string|int $inputToSearch
     * @return array
     */
    public function researchAsNobody(string|int $inputToSearch): array
    {
        $arrayOfResult["IT_Articles"] = (new ITPage())->getArticleIDByResearch($inputToSearch);
        $arrayOfResult["USERSite"] = (new UserSite())->getUserIdByPseudo($inputToSearch, false); // deuxieme arguement enlever les blackLists
        $arrayOfUrl = $this->transformSearchResultToUrl($arrayOfResult);
        return $arrayOfUrl;
    }

    /**
     * renvoie les urls des résultats de la recherche
     *
     * @param array $arrayOfResult
     * @return array
     */
    private function transformSearchResultToUrl(array $arrayOfResult): array
    {
        $arrayOfUrl = array();
        foreach ($arrayOfResult as $key => $value) {
            switch ($key) {
                case "IT_Articles":
                    if ($value != false) {
                        foreach ($value as $id) {
                            $arrayOfUrl[$key][] = (new ITPage())->getLinkById($id);
                        }
                    }
                    break;
                case "USERSite":
                    if ($value != false) {
                        foreach ($value as $idUsers) {
                            foreach ($idUsers as $id) {
                                $arrayOfUrl[$key][] = "/User/Profil/" . $id;
                            }
                        }
                    }
                    break;
                case "BLOG_Page":
                    if ($value != false) {
                        foreach ($value as $id) {
                                $arrayOfUrl[$key][] = "/Post/Blog/" . $id;

                        }
                    }
                    break;
                case "BLOG_Comment":
                    if ($value != false) {
                        foreach ($value as $idComments) {
                            foreach ($idComments as $id) {
                                $arrayOfUrl[$key][] = "/Post/Blog/" . (new Blog_Comment())->getPageIdByCommentId($id);
                            }
                        }
                    }
                    break;
                case "BLOG_Category":
                    if ($value != false) {
                        // a ce niveau la on a donc des categories id

                        //nous on veut les urls des pages
                        $pages = array();

                        foreach ($value as $catIdList){
                            foreach($catIdList as $catId){
                                $pages[] = (new Blog_categoryPage())->get5PagesByCategory($catId);
                            }
                            // on recupere les 5 pages les plus récentes qui ont la catégorie donnée
                        }
                        foreach ($pages as $page){
                            foreach ($page as $id) {
                                $arrayOfUrl[$key][] = "/Post/Blog/" . $id;
                            }
                        }

                    }
                    break;
                case "BLACKLIST":
                    if ($value != false) {
                        foreach ($value as $idBlackList) {
                            foreach ($idBlackList as $id) {
                                $arrayOfUrl[$key][] = "/User/Profil/" . (new BlacklistUser())->getUserIdByBlacklistId($id);
                            }
                        }
                    }
                    break;
                case "MUTE":
                    if ($value != false) {
                        foreach ($value as $idMute) {
                            foreach ($idMute as $id){
                                $arrayOfUrl[$key][] = "/User/Profil/" . (new MutedUser())->getUserIdByMuteId($id);

                            }
                        }
                    }
                    break;

            }
        }

        return $arrayOfUrl;
    }

    /**
     * méthode de recherche pour les utilisateurs connectés
     *
     * @param string|int $inputToSearch
     * @return array
     */
    public function researchAsUser(string|int $inputToSearch): array
    {
        $arrayOfResult["IT_Articles"] = (new ITPage())->getArticleIDByResearch($inputToSearch);
        $arrayOfResult["USERSite"] = (new UserSite())->getUserIdByPseudo($inputToSearch, false);
        //$arrayOfResult["FORUM_Page"] = (new ForumPage())->getPageIdByResearch($inputToSearch,'active');
        //$arrayOfResult["FORUM_Comment"] = (new ForumComment())->getCommentIdByResearch($inputToSearch,'active');
        //$arrayOfResult["FORUM_Category"] = (new ForumCategory())->getCategoryIdByResearch($inputToSearch);
        $arrayOfResult["BLOG_Page"] = (new Blog_Page())->getPageIdByResearch($inputToSearch, 'active');
        $arrayOfResult["BLOG_Comment"] = (new Blog_Comment())->getCommentIdByResearch($inputToSearch, 'active');
        $arrayOfResult["BLOG_Category"] = (new Blog_Category())->getCategoryIdByResearch($inputToSearch);
        $arrayOfUrl = $this->transformSearchResultToUrl($arrayOfResult);
        return $arrayOfUrl;
    }

    /**
     * méthode de recherche pour les utilisateurs connectés en tant que modérateur
     *
     * @param int|string $inputToSearch
     * @return array
     */
    public function researchAsStaff(int|string $inputToSearch): array
    {
        $arrayOfResult["IT_Articles"] = (new ITPage())->getArticleIDByResearch($inputToSearch);
        $arrayOfResult["USERSite"] = (new UserSite())->getUserIdByResearch($inputToSearch, true);
        //$arrayOfResult["FORUM_Page"] = (new ForumPage())->getPageIdByResearch($inputToSearch,'all');
        //$arrayOfResult["FORUM_Comment"] = (new ForumComment())->getCommentIdByResearch($inputToSearch,'all');
        //$arrayOfResult["FORUM_Category"] = (new ForumCategory())->getCategoryIdByResearch($inputToSearch);
        $arrayOfResult["BLOG_Page"] = (new Blog_Page())->getPageIdByResearch($inputToSearch, 'all');
        $arrayOfResult["BLOG_Comment"] = (new Blog_Comment())->getCommentIdByResearch($inputToSearch, 'all');
        $arrayOfResult["BLOG_Category"] = (new Blog_Category())->getCategoryIdByResearch($inputToSearch);
        $arrayOfResult["BLACKLIST"] = (new BlacklistUser())->getIdBlacklistByResearch($inputToSearch);
        $arrayOfResult["MUTE"] = (new MutedUser())->getIdMuteByResearch($inputToSearch);
        $arrayOfUrl = $this->transformSearchResultToUrl($arrayOfResult);
        return $arrayOfUrl;

    }


}