<?php

/**
 * la Classe Blog_Comment de l'orm pour faire les acces a la base de données et recuperer les valeurs de la table BLOG_Comment
 *
 * les attributs de la table BLOG_Comment sont :
 * - CommentId : int
 * - textC : text
 * - dateC : datetime
 * - UserId : int
 * - PageId : int
 *
 * Cette classe fait le lien entre un post de blog et un commentaire de cette meme page
 *
 * @see Blog_Page
 * @see UserSite
 * @see ControllerMenu
 * @see ControllerPost
 * @see ControllerSettings::MyCommentAction()
 *
 * @package models/ORM
 * @since 1.0
 * @version 1.0
 * @category blog
 * @author Tom Carvajal & Vanessa Guil
 */
class Blog_Comment
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
     * Blog_Comment constructor.
     */
    public function __construct()
    {
        $this->DBBrain = new DBBrain();
        $this->conn = $this->DBBrain->getConn();
    }

    /**
     * Cette methode permet de créer un commentaire
     *
     * @param string $textC
     * @param int $UserId
     * @param int $PageId
     * @return string|false
     */
    public function createComment(string $textC, int $UserId, int $PageId): string|false
    {
        $sql = "INSERT INTO BLOG_Comment (textC, dateC, UserId, PageId) VALUES (:textC, CURRENT_TIMESTAMP, :UserId, :PageId)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':textC', $textC);
        $stmt->bindParam(':UserId', $UserId);
        $stmt->bindParam(':PageId', $PageId);
        $stmt->execute();
        return $this->conn->lastInsertId();
    }

    /**
     * Cette methode permet de récupérer un commentaire (toute ses infos) par son id
     *
     * @param int $CommentId
     * @return array|false
     */
    public function getComment(int $CommentId): false|array
    {
        if ($this->isCommentExist($CommentId)) {
            $sql = "SELECT * FROM BLOG_Comment WHERE CommentId = :CommentId";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':CommentId', $CommentId);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return false;
    }

    /**
     * Cette méthode permet de verifier si une page existe par rapport a son id
     *
     * @param int|string $CommentId
     * @return bool
     */
    private function isCommentExist(int|string $CommentId): bool
    {
        $sql = "SELECT * FROM BLOG_Comment WHERE CommentId = :CommentId";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':CommentId', $CommentId);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return true;
        }
        return false;
    }


    /**
     * Cette methode permet de récupérer tout les commentaire d'un user sous forme de liste d'identifiant de commentaire
     *
     * @param int $UserId
     * @return array|false
     */
    public function getAllCommentIdOfUser(int $UserId): false|array
    {
        $ArrayOfCommentId = array();
        $sql = "SELECT CommentId FROM BLOG_Comment WHERE UserId = :UserId";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':UserId', $UserId);
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $ArrayOfCommentId[] = $row['CommentId'];
        }
        return $ArrayOfCommentId;
    }

    /**
     * Cette méthode permet de récupérer tout les commentaire d'une page sous forme de liste d'identifiant de commentaire
     *
     * @param int $PageId
     * @return false|array
     */
    public function getAllCommentIdOfPage(int $PageId): false|array
    {
        $ArrayOfCommentId = array();
        $sql = "SELECT CommentId FROM BLOG_Comment WHERE PageId = :PageId";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':PageId', $PageId);
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $ArrayOfCommentId[] = $row['CommentId'];
        }
        return $ArrayOfCommentId;
    }

    /**
     * Cette methode permet de mettre a jour un commentaire en changeant son texte, par rapport a son id
     * //TODO changer aussi la date
     *
     * @param int $CommentId
     * @param string $textC
     * @return void
     */
    public function updateComment(int $CommentId, string $textC): void
    {
        if ($this->isCommentExist($CommentId)) {
            $sql = "UPDATE BLOG_Comment SET textC = :textC WHERE CommentId = :CommentId";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':textC', $textC);
            $stmt->execute();
        }
    }

    /**
     * Cette méthode permet de supprimer un commentaire par rapport a son id
     *
     * @param int $CommentId
     * @return void
     */
    public function deleteComment(int $CommentId): void
    {
        if ($this->isCommentExist($CommentId)) {
            $sql = "DELETE FROM BLOG_Comment WHERE CommentId = :CommentId";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':CommentId', $CommentId);
            $stmt->execute();
        }
    }

    /**
     * Cette méthode permet de supprimer tout les commentaires d'un utilisateur
     *
     * @param int $UserId
     * @return void
     */
    public function deleteAllCommentOfUser(int $UserId): void
    {
        $ArrayOfCommentId = $this->getAllCommentIdOfUser($UserId);
        foreach ($ArrayOfCommentId as $CommentId) {
            $this->deleteComment($CommentId);
        }
    }

    /**
     * Cette méthode permet de supprimer tout les commentaires d'une page
     *
     * @param int $PageId
     * @return void
     */
    public function deleteAllCommentOfPage(int $PageId): void
    {
        $ArrayOfCommentId = $this->getAllCommentIdOfPage($PageId);
        foreach ($ArrayOfCommentId as $CommentId) {
            $this->deleteComment($CommentId);
        }
    }

    /**
     * Cette méthode retourne les identifiants des commentaires d'une page avec un status donné et qui contiennent un mot dans son texte
     *
     * @param int|string $inputToSearch
     * @param string $status
     * @return false|array
     */
    public function getCommentIdByResearch(int|string $inputToSearch, string $status): false|array
    {
        if ($status == 'all') {
            $sql = "SELECT CommentId FROM BLOG_Comment WHERE textC LIKE ? LIMIT 5";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(1, '%' . $inputToSearch . '%');
        } else {
            $sql = "SELECT CommentId FROM BLOG_Comment,BLOG_Page WHERE BLOG_Comment.PageId = BLOG_Page.PageId 
                AND BLOG_Page.statusP = ? AND textC LIKE ? LIMIT 5";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $status);
            $stmt->bindValue(2, '%' . $inputToSearch . '%');
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);

        // si la pageId a un status 'inactive/hidden' on ne recupere pas l'id du commentaire

    }

    /**
     * @param string|int $id
     * @return array|false
     */
    public function getPageIdByCommentId(string|int $id): false|array
    {
        $sql = "SELECT PageId FROM BLOG_Comment WHERE CommentId = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Cette méthode permet de recuperer tout les attributs d'un commentaire par rapport a son id
     *
     * @param int $CommentId
     * @return array|ExceptionsDatabase|false
     */
    public function getValuesById(int $CommentId) : array|ExceptionsDatabase|false
    {
        try {
            if (!$this->isCommentExist($CommentId)) {
                throw new ExceptionsDatabase("This comment doesn't exist");
            }
            $stmt = $this->conn->prepare("SELECT * FROM BLOG_Comment WHERE CommentId = ?");
            $stmt->bindParam(1, $CommentId);
            $stmt->execute();
            $mapArrayOfPageValues = $stmt->fetch(PDO::FETCH_ASSOC); // Stocke le résultat dans le tableau
            $stmt->closeCursor();
        } catch (ExceptionsDatabase $e) {
            return $e;
        }
        return $mapArrayOfPageValues;
    }

    /**
     * méthode pour verifier si un commentaire appartient a un user
     *
     * @param int|string $CommentId
     * @param int|string $UserId
     * @return bool
     */
    public function doesCommentIdBelongToUser(int|string $CommentId, int|string $UserId): bool
    {
        if ($this->isCommentExist($CommentId)) {
            $sql = "SELECT * FROM BLOG_Comment WHERE CommentId = :CommentId AND UserId = :UserId";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':CommentId', $CommentId);
            $stmt->bindParam(':UserId', $UserId);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                return true;
            }
        }
        return false;
    }


}