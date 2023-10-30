<?php

class Blog_Category
{
    private PDO $conn;
    private DBBrain $DBBrain;

    public function __construct()
    {
        $this->DBBrain = new DBBrain();
        $this->conn = $this->DBBrain->getConn();
    }

    public function createCategory($label, $description = null)
    {
        //si la category avec x label existe
        if ($this->doesCategoryExist($label)) {
            $stmt = $this->conn->prepare("SELECT CategoryId FROM BLOG_Category WHERE label = ?");
            $stmt->bindParam(1, $label, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
            return $result['CategoryId'];
            // on renvoi l'id de la category
        } else { //si la category n'existe pas avec le label, on la crée
            $stmt = $this->conn->prepare("INSERT INTO BLOG_Category (label,description) VALUES (?,?)");
            $stmt->bindParam(1, $label);
            $stmt->bindParam(2, $description);
            error_log("debug : Sucess for insertion");
            return $this->conn->lastInsertId();
            // l'easter egg recursif était une mauvaise idée, note a moi meme ne plus refaire
            // on renvoi l'id de la category
        }
    }

    public function doesCategoryExist($label)
    {
        $stmt = $this->conn->prepare("SELECT count(*) FROM BLOG_Category WHERE label = ?");
        $stmt->bindParam(1, $label, PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->fetchColumn();
        return $count > 0;
    }

    public function getCategoryById($id)
    {
        if ($this->doesCategoryIdExist($id)) {
            $stmt = $this->conn->prepare("SELECT CategoryId FROM BLOG_Category WHERE CategoryId = ?");
            $stmt->bindParam(1, $id, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
            return $result['label'];
        } else return false;
        // renvoie le label d'une category selon son identifiant
    }

    public function doesCategoryIdExist($id)
    {
        $stmt = $this->conn->prepare("SELECT count(*) FROM BLOG_Category WHERE CategoryId = ?");
        $stmt->bindParam(1, $id, PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->fetchColumn();
        return $count > 0;
    }

    public function getCategoryByLabel($label)
    {
        if ($this->doesCategoryExist($label)) {
            $stmt = $this->conn->prepare("SELECT CategoryId FROM BLOG_Category WHERE label = ?");
            $stmt->bindParam(1, $label, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
            return $result['CategoryId'];
            //renvoie l'id si elle existe
        } else return false;
        //renvoi false si elle n'existe pas
    }

    public function removeCategoryById($id)
    {
        //si l'id existe on supprime le tuple // attention contrainte d'intégrité dans categoryPage
        // a voir si on implémente donc...
    }

}