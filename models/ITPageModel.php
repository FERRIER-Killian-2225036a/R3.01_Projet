<?php

/**
 * Classe de du model directement en lien avec l'orm , on a cette classe pour eviter de trop faire
 * de requete de lecture sur les données de l'actualité (IT).
 *
 * Cette classe principale concerne les données des articles scrapé que l'on charge de la bdd
 *
 * @see UserSite
 * @see ControllerMenu
 *
 * @package models
 * @since 1.0
 * @version 1.0
 * @category Actualité
 * @author Tom Carvajal & Killian Ferrier
 */
class ITPageModel
{
    /**
     * @var int L'identifiant de l'article.
     */
    private int $id;

    /**
     * @var string Le titre de l'article.
     */
    private string $title;

    /**
     * @var string Le contenu de l'article.
     */
    private string $content;

    /**
     * @var string L'auteur de l'article.
     */
    private string $author;

    /**
     * @var int L'identifiant de l'utilisateur ayant écrit l'article.
     * @see Constants on a un user par defaut qui écrit les articles
     */
    private int $userId;

    /**
     * @var string La date de publication de l'article.
     */
    private string $date;

    /**
     * @var string L'URL de l'image de l'article.
     */
    private string $urlPicture;

    /**
     * @var string L'URL de l'article.
     */
    private string $lien;

    /**
     * contructeur fabriqué a partir d'un tableau associatif généré par notre bdd sql dans itpage
     *
     * @param int $Id
     */
    public function __construct(int $Id)
    {   // on pourra combiné ca avec get5PagesByDate de l'orm qui permet de recuperer les 5 derniers articles selon une potentiel
        // date donnée, on aura a rappellé a chaque fois cette fonction avec la date du dernier article affiché (donc dans le controller)
        $arrayOfValues = (new ITPage())->getValuesById($Id);
        $this->id = $arrayOfValues['ArticleId'];
        $this->title = $arrayOfValues['title'];
        $this->content = $arrayOfValues['content'];
        $this->author = $arrayOfValues['author'];
        $this->userId = $arrayOfValues['UserId'];
        $this->date = $arrayOfValues['dateIT'];
        $this->urlPicture = $arrayOfValues['UrlPicture'];
        $this->lien = $arrayOfValues['Lien'];
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @return string
     */
    public function getAuthor(): string
    {
        return $this->author;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @return string
     */
    public function getDate(): string
    {
        return $this->date;
    }

    /**
     * @return string
     */
    public function getUrlPicture(): string
    {
        return $this->urlPicture;
    }

    /**
     * @return string
     */
    public function getLien(): string
    {
        return $this->lien;
    }


}