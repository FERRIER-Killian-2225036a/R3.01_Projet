<?php
class ITPageModel
{
    private $id;
    private $title;
    private $content;
    private $author;
    private $userId;
    private $date;
    private $urlPicture;
    private $lien;

    public function getId(): mixed
    {
        return $this->id;
    }
    public function getTitle(): mixed
    {
        return $this->title;
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
        return $this->userId;
    }
    public function getDate(): mixed
    {
        return $this->date;
    }
    public function getUrlPicture(): mixed
    {
        return $this->urlPicture;
    }
    public function getLien(): mixed
    {
        return $this->lien;
    }


    //contructeur fabriqué a partir d'un tableau associatif généré par notre bdd sql dans itpage
    public function __construct($Id)
    {   // on pourra combiné ca avec get5PagesByDate de l'orm qui permet de recuperer les 5 derniers articles selon une potentiel
        // date donnée, on aura a rappellé a chaque fois cette fonction avec la date du dernier article affiché (donc dans le controller)
        $arrayOfValues = (new ITPage())->getValuesById($Id);
        print_r($arrayOfValues);
        $this->id = $arrayOfValues['ArticleId'];
        $this->title = $arrayOfValues['Title'];
        $this->content = $arrayOfValues['Content'];
        $this->author =$arrayOfValues['Author'];
        $this->userId = $arrayOfValues['UserId'];
        $this->date = $arrayOfValues['Date'];
        $this->urlPicture =$arrayOfValues['UrlPicture'];
        $this->lien = $arrayOfValues['Lien'];
    }


}