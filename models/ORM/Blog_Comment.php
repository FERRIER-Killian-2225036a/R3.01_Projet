<?php

class Blog_Comment
{
    private PDO $conn;
    private DBBrain $DBBrain;

    public function __construct()
    {
        $this->DBBrain = new DBBrain();
        $this->conn = $this->DBBrain->getConn();
    }
    // $CommentId, $textC, $dateC, $UserId, $PageId sont les attributs de la bdd dans la table BLOG_Comment

    public function createComment($textC, $dateC, $UserId, $PageId)
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

    public function getComment($CommentId)
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

    private function isCommentExist($CommentId)
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

    public function getAllCommentIdOfUser($UserId)
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

    public function getAllCommentIdOfPage($PageId)
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

    public function updateComment($CommentId, $textC)
    {
        if ($this->isCommentExist($CommentId)) {
            $sql = "UPDATE BLOG_Comment SET textC = :textC WHERE CommentId = :CommentId";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':textC', $textC);
            $stmt->execute();
        }
    }

    public function deleteComment($CommentId)
    {
        if ($this->isCommentExist($CommentId)) {
            $sql = "DELETE FROM BLOG_Comment WHERE CommentId = :CommentId";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':CommentId', $CommentId);
            $stmt->execute();
        }
    }

    public function deleteAllCommentOfUser($UserId)
    {
        $ArrayOfCommentId = $this->getAllCommentIdOfUser($UserId);
        foreach ($ArrayOfCommentId as $CommentId) {
            $this->deleteComment($CommentId);
        }
    }

    public function deleteAllCommentOfPage($PageId)
    {
        $ArrayOfCommentId = $this->getAllCommentIdOfPage($PageId);
        foreach ($ArrayOfCommentId as $CommentId) {
            $this->deleteComment($CommentId);
        }
    }
}