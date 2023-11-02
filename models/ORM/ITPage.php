<?php

/**
 * la Classe ITPage de l'orm pour faire les acces a la base de données et recuperer les valeurs de la table IT_Article
 *
 * les attributs de la table IT_Article sont :
 * - ArticleId : int
 * - title : varchar(150)
 * - content : text
 * - author : varchar(25)
 * - UserId : int
 * - dateIT : datetime
 * - numberOfLikes : int
 * - UrlPicture : text
 * - Lien : text
 *
 * Cette classe fait permet de récuperer les données des articles d'actualité stocké dans notre bdd
 * qu'on a recuperer avec notre scrappeur
 *
 * @see ControllerMenu
 * @see UserSite
 * @see ITPageModel
 *
 * @package models/ORM
 * @since 1.0
 * @version 1.0
 * @category actuality
 * @author Tom Carvajal & Vanessa Guil & Killian Ferrier
 */
class ITPage
{
    /**
     * @var PDO $conn variable de connexion a la base de données
     */
    private PDO $conn;

    /**
     * @var DBBrain $DBBrain variable pour recuperer le cerveau de la bdd (méthodes utiles)
     */
    private DBBrain $DBBrain;

    /**
     * ITPage constructor.
     */
    public function __construct()
    {
        $this->DBBrain = new DBBrain();
        $this->conn = $this->DBBrain->getConn();
    }


    /**
     * Cette méthode permet de recuperer 5 articles d'actualités trié par ordre chronologique, a partir
     * d'une date donnée, ou depuis la plus récente si abscence de parametre
     *
     * @param string|null $pageDate
     * @return array|Exception|ExceptionsDatabase|false
     */
    public function get5PagesByDate(string $pageDate = null): bool|ExceptionsDatabase|Exception|array
    {
        // selection par date (peut être null)
        // on pense aussi a mettre une limite (5 par 5)

        // si vaut null on recupere la plus récente

        // sinon on recupere celle qui est la plus proche de la date donnée
        // on recupere les 5 id des articles les plus proches de la date donnée trié par ordre chronologique
        try {
            if ($pageDate == null) {
                $stmt = $this->conn->prepare("SELECT ArticleId FROM IT_Article ORDER BY DateIT DESC LIMIT 5");
            } else {
                $stmt = $this->conn->prepare("SELECT ArticleId FROM IT_Article WHERE DateIT < ? ORDER BY DateIT DESC LIMIT 5");
                $stmt->bindParam(1, $pageDate);
            }
            // Stocke le résultat dans le tableau
            $stmt->execute();
            $arrayOfId = $stmt->fetchAll(PDO::FETCH_COLUMN);
            $stmt->closeCursor();
            return $arrayOfId;
        } catch (ExceptionsDatabase $e) {
            return $e;
        }
    }


    /**
     * Cette méthode permet de lier un article (au niveau du model) a un identifiant d'article.
     *
     * @see ITPageModel
     *
     * @param int $Id
     * @return Exception|ExceptionsDatabase|array
     */
    public function getValuesById(int $Id): ExceptionsDatabase|Exception|array
    {
        try {
            if (!$this->isArticleIdExist($Id)) {
                throw new ExceptionsDatabase("This article doesn't exist");
            }
            $stmt = $this->conn->prepare("SELECT * FROM IT_Article WHERE ArticleId = ?");
            $stmt->bindParam(1, $Id);
            $stmt->execute();
            $mapArrayOfUserValues = $stmt->fetch(PDO::FETCH_ASSOC); // Stocke le résultat dans le tableau
            $stmt->closeCursor();
        } catch (ExceptionsDatabase $e) {
            return $e;
        }
        return $mapArrayOfUserValues; // Retourne le tableau avec les valeurs de la requete
    }

    /**
     * Cette méthode permet de savoir si un article existe par rapport a son id
     *
     * @param int $Id
     * @return bool
     */
    public function isArticleIdExist(int $Id): bool
    {
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM IT_Article WHERE ArticleId = ?");
        $stmt->bindParam(1, $Id);
        $stmt->execute();
        $result = $stmt->fetchColumn(); // Stocke le résultat dans le tableau
        $stmt->closeCursor();
        return $result > 0;
    }

    /*
    public function createPage ($CurrentUserId, $title, $message, $UrlPicture) {
    // on insere un nouvelle article dans la base de donnée avec les parametres donnés
    // on s'en sert pas ??? vu que c'est fait depuis python
    }*/

    /*
    public function deletePage ($pageId) {
        // on supprime l'article de la base de donnée
    }*/

    /*
    public function get5PageById ($pageId) { // je sais pas si on s'en sert killian
    // selection par date (peut être null)
    // on pense aussi a mettre une limite (5 par 5)
    }*/


}