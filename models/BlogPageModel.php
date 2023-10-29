<?php

class BlogPageModel
{
//PageId 	TITLE 	content 	author 	UserId 	dateP 	NumberOfLikes 	UrlPicture 	statusP
    private $PageId;
    private $TITLE;
    private $content;
    private $author;
    private $UserId;
    private $dateP;
    private $NumberOfLikes;
    private $UrlPicture;
    private $statusP;
    private $PostUrl;
    private $PostEditUrl;

    public function getPostUrl(): mixed
    {
        return $this->PostUrl;
    }
    public function getPostEditUrl(): mixed
    {
        return $this->PostEditUrl;
    }

    public function getPageId(): mixed
    {
        return $this->PageId;
    }

    public function getTITLE(): mixed
    {
        return $this->TITLE;
    }

    public function getContent(): mixed
    {
        return $this->content;
    }

    public function getAuthor(): mixed
    {
        return $this->author;
    }

    public function getUserId(): mixed
    {
        return $this->UserId;
    }

    public function getDateP(): mixed
    {
        return $this->dateP;
    }

    public function getNumberOfLikes(): mixed
    {
        return $this->NumberOfLikes;
    }

    public function getUrlPicture(): mixed
    {
        return $this->UrlPicture;
    }

    public function getStatusP(): mixed
    {
        return $this->statusP;
    }


    public function __construct($Id){

        $arrayOfValues = (new Blog_Page())->getValuesById($Id);
        $this->PageId = $arrayOfValues['PageId'];
        $this->TITLE = $arrayOfValues['TITLE'];
        $this->content = $arrayOfValues['content'];
        $this->author = $arrayOfValues['author'];
        $this->UserId = $arrayOfValues['UserId'];
        $this->dateP = $arrayOfValues['dateP'];
        $this->NumberOfLikes = $arrayOfValues['NumberOfLikes'];
        $this->UrlPicture = $arrayOfValues['UrlPicture'];
        if ( $this->UrlPicture == null || $this->UrlPicture == ""){ // TODO ou si la photo n'existe pas sur le serveur ?
            $this->UrlPicture =Constants::PICTURE_URL_DEFAULT;
        }
        $this->statusP = $arrayOfValues['statusP'];
        $this->PostUrl = "/Post/Blog/".$this->PageId;
        $this->PostEditUrl = "/Post/BlogEdit/".$this->PageId;
    }


}