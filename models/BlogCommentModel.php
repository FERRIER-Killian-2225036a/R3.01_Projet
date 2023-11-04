<?php

/**
 * la Classe BlogCommentModel est un objet comment qui contient les infos d'un commentaire afin de limité
 * les requetes SQL
 *
 *  les attributs de la table BLOG_Comment sont :
 *  - CommentId : int
 *  - textC : text
 *  - dateC : datetime
 *  - UserId : int
 *  - PageId : int
 *
 * @see Blog_Page
 * @see UserSite
 * @see ControllerMenu
 * @see ControllerPost
 * @see ControllerSettings::MyCommentAction()
 *
 * @package models
 * @since 1.0
 * @version 1.0
 * @category blog
 * @author Tom Carvajal
 */
class BlogCommentModel
{
    /**
     * @var int $CommentId
     */
    private int $CommentId;
    /**
     * @var string $textC
     */
    private string $textC;
    /**
     * @var string $dateC
     */
    private string $dateC;
    /**
     * @var int $UserId
     */
    private int $UserId;
    /**
     * @var USERSiteModel $User pour pouvoir recuperer, pseudo, img, etc
     */
    private USERSiteModel $User;
    /**
     * @var int $PageId
     */
    private int $PageId;

    /**
     * @var BlogPageModel $BlogPage pour pouvoir recuperer le titre de la page du blog
     */
    private BlogPageModel $BlogPage;

    public function __construct($CommentId)
    {
        $arrayOfValues = (new Blog_Comment())->getValuesById($CommentId);
        $this->CommentId = $arrayOfValues['CommentId'];
        $this->textC = $arrayOfValues['textC'];
        $this->dateC = $arrayOfValues['dateC'];
        $this->UserId = $arrayOfValues['UserId'];
        $this->PageId = $arrayOfValues['PageId'];
        $this->User = new USERSiteModel($this->UserId);
        $this->BlogPage = new BlogPageModel($this->PageId);

    }

    /**
     * @return int
     */
    public function getCommentId(): int
    {
        return $this->CommentId;
    }

    /**
     * @return string
     */
    public function getTextC(): string
    {
        return $this->textC;
    }

    /**
     * @return string
     */
    public function getDateC(): string
    {
        return $this->dateC;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->UserId;
    }

    /**
     * @return USERSiteModel
     */
    public function getUser(): USERSiteModel
    {
        return $this->User;
    }

    /**
     * @return int
     */
    public function getPageId(): int
    {
        return $this->PageId;
    }

    /**
     * @return BlogPageModel
     */
    public function getBlogPage(): BlogPageModel
    {
        return $this->BlogPage;
    }
}
