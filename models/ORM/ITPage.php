<?php

class ITPage
{
    private PDO $conn;
    private DBBrain $DBBrain;

    public function __construct()
    {
        $this->DBBrain = new DBBrain();
        $this->conn = $this->DBBrain->getConn();
    }

    public function get5PageById ($pageId) { // je sais pas si on s'en sert killian
        // selection par date (peut être null)
        // on pense aussi a mettre une limite (5 par 5)

    }

    public function get5PagesByDate ($pageDate = null) {
        // selection par date (peut être null)
        // on pense aussi a mettre une limite (5 par 5)

        // si vaut null on recupere la plus récente

        // sinon on recupere celle qui est la plus proche de la date donnée
        $arrayOfId = null;
        // on recupere les 5 id des articles les plus proches de la date donnée trié par ordre chronologique
        try {
            if ($pageDate == null) {
                $stmt = $this->conn->prepare("SELECT ArticleId FROM IT_Article ORDER BY DateIT DESC LIMIT 5");
                $stmt->execute();
                $arrayOfId = $stmt->fetchAll(PDO::FETCH_COLUMN); // Stocke le résultat dans le tableau
                $stmt->closeCursor();
            }
            else {
                $stmt = $this->conn->prepare("SELECT ArticleId FROM IT_Article WHERE DateIT < ? ORDER BY DateIT DESC LIMIT 5");
                $stmt->bindParam(1, $pageDate, PDO::PARAM_STR);
                $stmt->execute();
                $arrayOfId = $stmt->fetchAll(PDO::FETCH_COLUMN); // Stocke le résultat dans le tableau
                $stmt->closeCursor();
            }
            return $arrayOfId;
        } catch (ExceptionsDatabase $e) {
            //echo $e->getMessage();
            return $e;
        }


    }

    public function createPage ($CurrentUserId, $title, $message, $UrlPicture) {
        // on insere un nouvelle article dans la base de donnée avec les parametres donnés
        // on s'en sert pas ??? vu que c'est fait depuis python

        // TODO boucle for pour afficher 5 articles par 5 article en fonction du plus récent (a faire au niveau du controller)


    }

    public function deletePage ($pageId) {
        // on supprime l'article de la base de donnée
    }

    public function getValuesById($Id)
    {
        //$mapArrayOfUserValues = null;
        try {
            if (!$this->isArticleIdExist($Id)) {
                throw new ExceptionsDatabase("This article doesn't exist");
            }

            $stmt = $this->conn->prepare("SELECT * FROM IT_Article WHERE ArticleId = ?");
            $stmt->bindParam(1, $Id, PDO::PARAM_STR);
            $stmt->execute();
            $mapArrayOfUserValues = $stmt->fetch(PDO::FETCH_ASSOC); // Stocke le résultat dans le tableau

            $stmt->closeCursor();
        } catch (ExceptionsDatabase $e) {
            //echo $e->getMessage();
            return $e;
        }

        return $mapArrayOfUserValues; // Retourne le tableau avec les valeurs de la requete
    }

    private function isArticleIdExist($Id)
    {
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM IT_Article WHERE ArticleId = ?");
        $stmt->bindParam(1, $Id, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetchColumn(); // Stocke le résultat dans le tableau
        $stmt->closeCursor();
        return $result > 0;
    }


}