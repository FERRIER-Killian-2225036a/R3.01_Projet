<?php

class Blog_Page
{
    private PDO $conn;
    private DBBrain $DBBrain;

    public function __construct()
    {
        $this->DBBrain = new DBBrain();
        $this->conn = $this->DBBrain->getConn();
    }



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
    }
}