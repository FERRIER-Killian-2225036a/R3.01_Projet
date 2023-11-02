<?php

/**
 * la Classe Blog_PageLike de l'orm pour faire les acces a la base de données et recuperer les valeurs de la table BLOG_PageLike
 *
 * les attributs de la table BLOG_PageLike sont :
 * - PageId : int
 * - UserId : int
 *
 * Cette classe fait le lien entre un enregistrement par un utilisateur et un post de blog
 *
 * note : Like = enregistrement pour nous, c'est la meme chose,
 * cœur = pouce en l'air = signet = bookmark = like = enregistrement
 *
 * @see Blog_Page
 * @see UserSite
 * @see ControllerMenu
 * @see ControllerPost
 * @see ControllerSettings::BookmarkAction()
 *
 * @package models/ORM
 * @since 1.0
 * @version 1.0
 * @category blog
 * @author Tom Carvajal & Vanessa Guil
 */
class Blog_PageLike
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
     * Blog_PageLike constructor.
     */
    public function __construct()
    {
        $this->DBBrain = new DBBrain();
        $this->conn = $this->DBBrain->getConn();
    }

    /**
     * Cette méthode a pour but de creer un like pour un post de blog selon l'utilisateur et le post
     *
     * @param int $PageId
     * @param int $UserId
     * @return void
     */
    public function createPageLike(int $PageId, int $UserId): void
    {
        if (!$this->isPageLikeExist($PageId, $UserId)) {
            $sql = "INSERT INTO BLOG_PageLike (PageId, UserId) VALUES (:PageId, :UserId)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':PageId', $PageId);
            $stmt->bindParam(':UserId', $UserId);
            $stmt->execute();
        }
    }

    /**
     * cette méthode permet de savoir si un post a était liker par un user (se matérialise par la présence ou l'abscence
     * de lien)
     *
     * @param int $PageId
     * @param int $UserId
     * @return bool
     */
    private function isPageLikeExist(int $PageId, int $UserId): bool
    {
        $sql = "SELECT * FROM BLOG_PageLike WHERE PageId = :PageId AND UserId = :UserId";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':PageId', $PageId);
        $stmt->bindParam(':UserId', $UserId);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return true;
        }
        return false;
    }

    /**
     * cette méthode permet de recuperer tout les ids des posts liker par un user
     *
     * @param int $UserId
     * @return array
     */
    public function getAllPageLikeIdOfUser(int $UserId): array
    {
        $ArrayOfPageLikeId = array();
        $sql = "SELECT PageId FROM BLOG_PageLike WHERE UserId = :UserId";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':UserId', $UserId);
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $ArrayOfPageLikeId[] = $row['PageId'];
        }
        return $ArrayOfPageLikeId;
    }

    /**
     * Cette méthode permet de recuperer tout les ids des users qui ont liker un post
     *
     * @param int $PageId
     * @return array
     */
    public function getAllPageLikeIdOfPage(int $PageId): array
    {
        $ArrayOfPageLikeId = array();
        $sql = "SELECT PageId FROM BLOG_PageLike WHERE PageId = :PageId";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':PageId', $PageId);
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $ArrayOfPageLikeId[] = $row['PageId'];
        }
        return $ArrayOfPageLikeId;
    }

    /**
     * Cette méthode permet de supprimer un like d'un post par un user
     *
     * @param int $PageId
     * @param int $UserId
     * @return void
     */
    public function deletePageLike(int $PageId, int $UserId): void
    {
        if ($this->isPageLikeExist($PageId, $UserId)) {
            $sql = "DELETE FROM BLOG_PageLike WHERE PageId = :PageId AND UserId = :UserId";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':PageId', $PageId);
            $stmt->bindParam(':UserId', $UserId);
            $stmt->execute();
        }
    }

    /**
     * Cette méthode permet de supprimer tout les likes d'un post
     *
     * @param int $PageId
     * @return void
     */
    public function deleteAllPageLikeOfPage(int $PageId): void
    {
            $sql = "DELETE FROM BLOG_PageLike WHERE PageId = :PageId";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':PageId', $PageId);
            $stmt->execute();

    }

    /**
     * Cette méthode permet de supprimer tout les likes d'un user
     *
     * @param int $UserId
     * @return void
     */
    public function deleteAllPageLikeOfUser(int $UserId): void
    {
            $sql = "DELETE FROM BLOG_PageLike WHERE UserId = :UserId";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':UserId', $UserId);
            $stmt->execute();
    }


    /**
     * Cette méthode permet de savoir si un post est liker par un user
     *
     * @param int $PageId
     * @param int $UserId
     * @return bool
     */
    public function isBookmarkExist(int $PageId, int $UserId) : bool
    {
        $sql = "SELECT * FROM BLOG_PageLike WHERE PageId = :PageId AND UserId = :UserId";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':PageId', $PageId);
        $stmt->bindParam(':UserId', $UserId);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return true;
        }
        return false;
    }
}