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
     * @param string $dateC
     * @param int $UserId
     * @param int $PageId
     * @return string|false
     */
    public function createComment(string $textC, string $dateC, int $UserId, int $PageId): string|false
    {
        $sql = "INSERT INTO BLOG_Comment (textC, dateC, UserId, PageId) VALUES (:textC, :dateC, :UserId, :PageId)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':textC', $textC);
        $stmt->bindParam(':dateC', $dateC);
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
     * @param int $CommentId
     * @return bool
     */
    private function isCommentExist(int $CommentId): bool
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
}