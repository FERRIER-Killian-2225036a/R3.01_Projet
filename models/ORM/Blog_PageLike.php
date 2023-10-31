<?php

class Blog_PageLike
{
    // Like = enregistrement pour nous c'est la meme chose , coeur = pouce en l'air = signet = bookmark = like = enregistrement
    // $PageId & $UserId sont les attributs de la bdd dans la table BLOG_PageLike
    private PDO $conn;
    private DBBrain $DBBrain;

    public function __construct()
    {
        $this->DBBrain = new DBBrain();
        $this->conn = $this->DBBrain->getConn();
    }

    public function createPageLike($PageId, $UserId)
    {
        if (!$this->isPageLikeExist($PageId, $UserId)) {
            $sql = "INSERT INTO BLOG_PageLike (PageId, UserId) VALUES (:PageId, :UserId)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':PageId', $PageId);
            $stmt->bindParam(':UserId', $UserId);
            $stmt->execute();
            return $this->conn->lastInsertId();
        }
        return $this->getPageLike($PageId, $UserId);
    }

    public function getPageLike($PageId, $UserId)
    {
        if ($this->isPageLikeExist($PageId, $UserId)) {
            $sql = "SELECT * FROM BLOG_PageLike WHERE PageId = :PageId AND UserId = :UserId";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':PageId', $PageId);
            $stmt->bindParam(':UserId', $UserId);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return false;
    }

    private function isPageLikeExist($PageId, $UserId)
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

    public function getAllPageLikeIdOfUser($UserId)
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

    public function getAllPageLikeIdOfPage($PageId)
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

    public function deletePageLike($PageId, $UserId)
    {
        if ($this->isPageLikeExist($PageId, $UserId)) {
            $sql = "DELETE FROM BLOG_PageLike WHERE PageId = :PageId AND UserId = :UserId";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':PageId', $PageId);
            $stmt->bindParam(':UserId', $UserId);
            $stmt->execute();
        }
    }

    public function deleteAllPageLikeOfPage($PageId)
    {
            $sql = "DELETE FROM BLOG_PageLike WHERE PageId = :PageId";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':PageId', $PageId);
            $stmt->execute();

    }

    public function deleteAllPageLikeOfUser($UserId)
    {
            $sql = "DELETE FROM BLOG_PageLike WHERE UserId = :UserId";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':UserId', $UserId);
            $stmt->execute();

    }





}