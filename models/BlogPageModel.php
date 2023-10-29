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
        $this->statusP = $arrayOfValues['statusP'];
    }


}