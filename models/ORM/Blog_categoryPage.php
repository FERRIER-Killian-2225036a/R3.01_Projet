<?php

class Blog_categoryPage
{
    private PDO $conn;
    private DBBrain $DBBrain;

public function __construct()
    {
        $this->DBBrain = new DBBrain();
        $this->conn = $this->DBBrain->getConn();
    }

    public function createLinkBetweenCategoryAndPage($cat_id,$page_id){
        //nouveau tuple dans la bdd dans table categoryPage
        $sql = "INSERT INTO BLOG_categoryPage (PageId,CategoryId) VALUES (?,?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1, $page_id, PDO::PARAM_STR);
        $stmt->bindParam(2, $cat_id, PDO::PARAM_STR);
        $stmt->execute();
        $stmt->closeCursor();
    }

    public function removeLinkBetweenCategoryAndPage($cat_id,$page_id){
        // on supprime le tuple , normalement ne pose aucun soucis car pas de contrainte d'intégrité
        // on pensera a appeler cette methodes lorsqu'on constate une différence entre :
        // les tags existants et les tags mit a jour par la modification (post/blogEdit)
        if ($this->linkBetweenCategoryAndPageExist($cat_id,$page_id)){
            $sql = "DELETE FROM BLOG_categoryPage WHERE PageId = ? AND CategoryId = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $page_id, PDO::PARAM_STR);
            $stmt->bindParam(2, $cat_id, PDO::PARAM_STR);
            $stmt->execute();
            $stmt->closeCursor();
        }

    }

    private function linkBetweenCategoryAndPageExist($cat_id, $page_id)
    {
        $stmt = $this->conn->prepare("SELECT count(*) FROM BLOG_categoryPage WHERE CategoryId = ? AND PageId = ?");
        $stmt->bindParam(1, $cat_id, PDO::PARAM_STR);
        $stmt->bindParam(2, $page_id, PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->fetchColumn();
        return $count > 0;
    }

}