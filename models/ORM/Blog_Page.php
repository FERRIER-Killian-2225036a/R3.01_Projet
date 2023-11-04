<?php

/**
 * la Classe Blog_Page de l'orm pour faire les acces a la base de données et recuperer les valeurs de la table BLOG_Page
 *
 * les attributs de la table BLOG_Page sont :
 * - PageId : int
 * - TITLE : varchar(150)
 * - content : text
 * - author : varchar(50)
 * - UserId : int
 * - dateP : datetime
 * - NumberOfLikes : int
 * - UrlPicture : text
 * - statusP : enum('active','inactive','hidden')
 *
 * Cette classe est la classe principale du model des blogs
 *
 * @see Blog_Comment
 * @see Blog_categoryPage
 * @see Blog_Category
 * @see UserSite
 * @see BlogPageModel
 * @see ControllerMenu
 * @see ControllerPost
 * @see ControllerSettings::MyPostAction()
 *
 * @package models/ORM
 * @since 1.0
 * @version 1.0
 * @category blog
 * @author Tom Carvajal & Vanessa Guil
 */
class Blog_Page
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
     * Blog_Page constructor.
     */
    public function __construct()
    {
        $this->DBBrain = new DBBrain();
        $this->conn = $this->DBBrain->getConn();
    }

    /**
     * Cette méthode permet de créer une page de blog
     *
     * @param string $TITLE
     * @param string $content
     * @param string $author
     * @param int $UserId
     * @param int $NumberOfLikes
     * @param string $UrlPicture
     * @param string $statusP
     * @return Exception|ExceptionsDatabase|false|string
     */
    public function createPage(string $TITLE, string $content, string $author, int $UserId,
                               int    $NumberOfLikes = 0, string $UrlPicture = Constants::PICTURE_URL_DEFAULT,
                               string $statusP = "active"): bool|ExceptionsDatabase|Exception|string
    {
        // on crée une page
        try {
            $stmt = $this->conn->prepare("INSERT INTO BLOG_Page (TITLE,content,author,UserId,dateP,NumberOfLikes,UrlPicture,statusP) VALUES (?,?,?,?,CURRENT_TIMESTAMP,?,?,?)");
            $stmt->bindParam(1, $TITLE);
            $stmt->bindParam(2, $content);
            $stmt->bindParam(3, $author);
            $stmt->bindParam(4, $UserId);
            $stmt->bindParam(5, $NumberOfLikes);
            $stmt->bindParam(6, $UrlPicture);
            $stmt->bindParam(7, $statusP);
            $stmt->execute();
            $stmt->closeCursor();

            return $this->conn->lastInsertId(); // string de l'id de la page
        } catch (ExceptionsDatabase $e) {
            return $e;
        }


    }

    /**
     * Cette méthode permet de supprimer une page de blog
     *
     * @param int $PageId
     * @return bool
     */
    public function deletePage(int $PageId): bool
    {
        if ($this->doesPageIdExist($PageId)) {
            // on supprime les liens vers les categories de la page
            (new Blog_categoryPage())->removeAllLinkBetweenCategoryAndPage($PageId);
            (new Blog_PageLike())->deleteAllPageLikeOfPage($PageId);
            (new Blog_Comment())->deleteAllCommentOfPage($PageId);
            
            $stmt = $this->conn->prepare("DELETE FROM BLOG_Page WHERE PageId = ?");
            $stmt->bindParam(1, $PageId);
            $stmt->execute();
            $stmt->closeCursor();
            return true;
        } else return false;
        // on supprime les categoriesPage liés a pageId, puis on supprime l'article
        // ou alors on pourra imaginé a le mettre en innactive
    }

    /**
     * Méthode pour verifier si une page existe par rapport a son id
     *
     * @param int $PageId
     * @return bool
     */
    public function doesPageIdExist(int $PageId): bool
    {
        $stmt = $this->conn->prepare("SELECT count(*) FROM BLOG_Page WHERE PageId = ?");
        $stmt->bindParam(1, $PageId);
        $stmt->execute();
        $count = $stmt->fetchColumn();
        return $count > 0;
    }

    /**
     * Cette méthode permet de mettre a jour une page de blog
     *
     * @param int $PageId
     * @param string $TITLE
     * @param string|null $content
     * @param string|null $author
     * @param int $UserId
     * @param string|null $UrlPicture
     * @param int $NumberOfLikes
     * @param string $statusP
     * @return bool
     */
    public function updatePage(int     $PageId, string $TITLE, ?string $content, ?string $author, int $UserId,
                               ?string $UrlPicture = Constants::PICTURE_URL_DEFAULT,
                               int     $NumberOfLikes = 0, string $statusP = "hidden"): bool
    {
        // comme create page sauf que l'id est aussi renseigné en param
        if ($this->doesPageIdExist($PageId)) {
            $stmt = $this->conn->prepare("UPDATE BLOG_Page SET TITLE = ?, content = ?, author = ?, UserId = ?, NumberOfLikes = ?, UrlPicture = ?, statusP = ? WHERE PageId = ?");
            $stmt->bindParam(1, $TITLE);
            $stmt->bindParam(2, $content);
            $stmt->bindParam(3, $author);
            $stmt->bindParam(4, $UserId);
            $stmt->bindParam(5, $NumberOfLikes);
            $stmt->bindParam(6, $UrlPicture);
            $stmt->bindParam(7, $statusP);
            $stmt->bindParam(8, $PageId);
            $stmt->execute();
            $stmt->closeCursor();
            return true;
        } else return false;
    }

    /**
     * méthode pour changer la visibilité d'une page de blog
     *
     * @param int $PageId
     * @param string $statusP
     * @return bool
     */
    public function changeVisibility(int $PageId, string $statusP): bool
    {
        // on change la visibilité selon un id
        // si la page existe
        if ($this->doesPageIdExist($PageId)) {
            $stmt = $this->conn->prepare("UPDATE BLOG_Page SET statusP = ? WHERE PageId = ?");
            $stmt->bindParam(1, $statusP);
            $stmt->bindParam(2, $PageId);
            $stmt->execute();
            $stmt->closeCursor();
            return true;
        } else return false;
    }

    /**
     * Méthode pour récupérer 5 pages de blog trié par date, à partir d'une potentielle date,
     * et appartenant potentiellement a un user
     *
     * @param string|null $date
     * @param int|null $UserId
     * @return array|false
     */
    public function get5PagesByDate(string $date = null, int $UserId = null): false|array
    {
        // on renvoie les blogs les plus récent si date est null, sinon en renvoi les blogs les plus récent apres
        // la date donnée
        // on note que si userId n'est pas null, on recupere les id d'un user spécifique
        if ($date == null) {
            if ($UserId == null) {
                $stmt = $this->conn->prepare("SELECT DISTINCT PageId FROM BLOG_Page ORDER BY dateP DESC LIMIT 5");
            } else {
                $stmt = $this->conn->prepare("SELECT DISTINCT PageId FROM BLOG_Page WHERE UserId = ? ORDER BY dateP DESC LIMIT 5");
                $stmt->bindParam(1, $UserId);
            }
        } else {
            if ($UserId == null) {
                $stmt = $this->conn->prepare("SELECT DISTINCT PageId FROM BLOG_Page WHERE dateP < ? ORDER BY dateP DESC LIMIT 5");
                $stmt->bindParam(1, $date);
            } else {
                $stmt = $this->conn->prepare("SELECT DISTINCT PageId FROM BLOG_Page WHERE dateP < ? AND UserId = ? ORDER BY dateP DESC LIMIT 5");
                $stmt->bindParam(1, $date);
                $stmt->bindParam(2, $UserId);
            }
        }
        // Stocke le résultat dans le tableau
        $stmt->execute();
        $arrayOfId = $stmt->fetchAll(PDO::FETCH_COLUMN);
        $stmt->closeCursor();
        return $arrayOfId;
    }

    /*                          fonctionne mais pas utilisé
    public function getPageById($pageId) {
        try {
            $stmt = $this->conn->prepare("SELECT TITLE, content, author,UserId, dateP, NumberOfLikes, UrlPicture FROM BLOG_Page WHERE PageId = ? AND statusP = 'active'");
            $stmt->bindParam("1", $pageId);
            $stmt->execute();
            //$stmt->bindValue($title, $content, $author, $dateP, $NumberOfLikes, $UrlPicture);
            $stmt->fetch();
            $stmt->close();

            return [
                'title' => $title,
                'content' => $content,
                'author' => $author,
                'dateP' => $dateP,
                'NumberOfLikes' => $NumberOfLikes,
                'UrlPicture' => $UrlPicture
            ];
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }*/



    /**
     * Méthode pour recuperer toutes les valeurs d'un post par rapport a son identifiant
     *
     * @param int $Id
     * @return Exception|ExceptionsDatabase|false|array
     */
    public function getValuesById(int $Id): bool|ExceptionsDatabase|Exception|array
    {
        try {
            if (!$this->isPageIdExist($Id)) {
                throw new ExceptionsDatabase("This page doesn't exist");
            }

            $stmt = $this->conn->prepare("SELECT * FROM BLOG_Page WHERE PageId = ?");
            $stmt->bindParam(1, $Id);
            $stmt->execute();
            $mapArrayOfPageValues = $stmt->fetch(PDO::FETCH_ASSOC); // Stocke le résultat dans le tableau
            $stmt->closeCursor();
        } catch (ExceptionsDatabase $e) {
            return $e;
        }
        return $mapArrayOfPageValues; // Retourne le tableau avec les valeurs de la requete
    }

    /**
     * Méthode pour verifier si une page éxiste par rapport a un identifiant
     *
     * @param int $Id
     * @return bool
     */
    public function isPageIdExist(int $Id): bool
    {
        $stmt = $this->conn->prepare("SELECT count(*) FROM BLOG_Page WHERE PageId = ?");
        $stmt->bindParam(1, $Id);
        $stmt->execute();
        $count = $stmt->fetchColumn();
        return $count > 0;
    }
    /*
        public function getValuesByUserId(mixed $UserId)
        {
            $mapArrayOfPageValues = null;
            try {
                if (!(new UserSite)->isUserIDExists($UserId)) {
                    throw new ExceptionsDatabase("This user doesn't exist");
                }

                $stmt = $this->conn->prepare("SELECT * FROM BLOG_Page WHERE UserId = ?");
                $stmt->bindParam(1, $UserId, PDO::PARAM_STR);
                $stmt->execute();
                $mapArrayOfPageValues = $stmt->fetch(PDO::FETCH_ASSOC); // Stocke le résultat dans le tableau

                $stmt->closeCursor();
            } catch (ExceptionsDatabase $e) {
                //echo $e->getMessage();
                return $e;
            }

            return $mapArrayOfPageValues; // Retourne le tableau avec les valeurs de la requete
        }
    */

    /**
     * méthode pour dire si une page appartient a un utilisateur
     *
     * @param int $idPost
     * @param int $UserId
     * @return bool
     */
    public function doesPageIdBelongToUser(int $idPost, int $UserId): bool
    {
        $stmt = $this->conn->prepare("SELECT count(*) FROM BLOG_Page WHERE PageId = ? AND UserId = ?");
        $stmt->bindParam(1, $idPost);
        $stmt->bindParam(2, $UserId);
        $stmt->execute();
        $count = $stmt->fetchColumn();
        return $count > 0;
    }

    /**
     * méthode pour mettre a jour le chemin d'une image dans la base de données pour les posts
     *
     * @param mixed $idPost
     * @param string $newImg
     * @return void
     */
    public function update_img(int $idPost, string $newImg): void
    {
        $stmt = $this->conn->prepare("UPDATE BLOG_Page SET UrlPicture = ? WHERE PageId = ?");
        $stmt->bindParam(1, $newImg);
        $stmt->bindParam(2, $idPost);
        $stmt->execute();
        $stmt->closeCursor();
    }

    /**
     * Cette méthode permet de recuperer l'identifiant des pages dont la recherche correspond a l'input
     *
     * @param int|string $inputToSearch
     * @param string $status
     * @return false|array
     */
    public function getPageIdByResearch(int|string $inputToSearch, string $status): false|array
    {
        if ($status == "all") {
            $stmt = $this->conn->prepare("SELECT PageId FROM BLOG_Page WHERE TITLE LIKE ? OR content LIKE ? LIMIT 5");
            $stmt->bindValue(1, "%$inputToSearch%");
            $stmt->bindValue(2, "%$inputToSearch%");
        } else {
            $stmt = $this->conn->prepare("SELECT PageId FROM BLOG_Page WHERE (TITLE LIKE ? OR content LIKE ?) AND statusP = ? LIMIT 5");
            $stmt->bindValue(1, "%$inputToSearch%");
            $stmt->bindValue(2, "%$inputToSearch%");
            $stmt->bindValue(3, $status);
        }
        $stmt->execute();
        $arrayOfId = $stmt->fetchAll(PDO::FETCH_COLUMN);
        $stmt->closeCursor();
        return $arrayOfId;
    }

}