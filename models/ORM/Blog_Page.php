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

    public function createPage($TITLE, $content, $author, $UserId, $dateP = "CURRENT_TIMESTAMP",
                               $NumberOfLikes = 0, $UrlPicture = Constants::PICTURE_URL_DEFAULT, $statusP = "hidden")
    {
        // on crée une page
        try {
            $stmt = $this->conn->prepare("INSERT INTO BLOG_Page (TITLE,content,author,UserId,dateP,NumberOfLikes,UrlPicture,statusP) VALUES (?,?,?,?,?,?,?,?)");
            $stmt->bindParam(1, $TITLE, PDO::PARAM_STR);
            $stmt->bindParam(2, $content, PDO::PARAM_STR);
            $stmt->bindParam(3, $author, PDO::PARAM_STR);
            $stmt->bindParam(4, $UserId, PDO::PARAM_STR);
            $stmt->bindParam(5, $dateP, PDO::PARAM_STR);
            $stmt->bindParam(6, $NumberOfLikes, PDO::PARAM_STR);
            $stmt->bindParam(7, $UrlPicture, PDO::PARAM_STR);
            $stmt->bindParam(8, $statusP, PDO::PARAM_STR);
            $stmt->execute();
            $stmt->closeCursor();

            $id = $this->conn->lastInsertId();
            return $id;
        } catch (ExceptionsDatabase $e) {
            return $e;
        }


    }

    public function deletePage($PageId)
    {
        // on supprime les categoriesPage liés a pageId, puis on supprime l'article
        // ou alors on pourra imaginé a le mettre en innactive
    }

    public function updatePage($PageId, $TITLE, $content, $author, $UserId, $UrlPicture = Constants::PICTURE_URL_DEFAULT, $dateP = "CURRENT_TIMESTAMP",
                               $NumberOfLikes = 0,  $statusP = "hidden")
    {
        // comme create page sauf que l'id est aussi renseigné en param
        if ($this->doesPageIdExist($PageId)) {
            $stmt = $this->conn->prepare("UPDATE BLOG_Page SET TITLE = ?, content = ?, author = ?, UserId = ?, dateP = ?, NumberOfLikes = ?, UrlPicture = ?, statusP = ? WHERE PageId = ?");
            $stmt->bindParam(1, $TITLE, PDO::PARAM_STR);
            $stmt->bindParam(2, $content, PDO::PARAM_STR);
            $stmt->bindParam(3, $author, PDO::PARAM_STR);
            $stmt->bindParam(4, $UserId, PDO::PARAM_STR);
            $stmt->bindParam(5, $dateP, PDO::PARAM_STR);
            $stmt->bindParam(6, $NumberOfLikes, PDO::PARAM_STR);
            $stmt->bindParam(7, $UrlPicture, PDO::PARAM_STR);
            $stmt->bindParam(8, $statusP, PDO::PARAM_STR);
            $stmt->bindParam(9, $PageId, PDO::PARAM_STR);
            $stmt->execute();
            $stmt->closeCursor();
            return true;
        } else return false;
    }

    public function doesPageIdExist($PageId)
    {
        $stmt = $this->conn->prepare("SELECT count(*) FROM BLOG_Page WHERE PageId = ?");
        $stmt->bindParam(1, $PageId, PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->fetchColumn();
        return $count > 0;
    }

    public function changeVisibility($PageId, $statusP)
    {
        // on change la visibilité selon un id
        // si la page existe
        if ($this->doesPageIdExist($PageId)) {
            $stmt = $this->conn->prepare("UPDATE BLOG_Page SET statusP = ? WHERE PageId = ?");
            $stmt->bindParam(1, $statusP, PDO::PARAM_STR);
            $stmt->bindParam(2, $PageId, PDO::PARAM_STR);
            $stmt->execute();
            $stmt->closeCursor();
            return true;
        } else return false;
    }

    public function get5PagesByDate($date = null, $UserId = null)
    {
        // on renvoie les blogs les plus récent si date est null, sinon en renvoi les blogs les plus récent apres
        // la date donnée
        // on note que si userId n'est pas null, on recupere les id d'un user spécifique
        $arrayOfId = null;
        if ($date == null) {
            if ($UserId == null) {
                $stmt = $this->conn->prepare("SELECT DISTINCT PageId FROM BLOG_Page ORDER BY dateP DESC LIMIT 5");
                $stmt->execute();
                $arrayOfId = $stmt->fetchAll(PDO::FETCH_COLUMN); // Stocke le résultat dans le tableau
                $stmt->closeCursor();
            } else {
                $stmt = $this->conn->prepare("SELECT DISTINCT PageId FROM BLOG_Page WHERE UserId = ? ORDER BY dateP DESC LIMIT 5");
                $stmt->bindParam(1, $UserId, PDO::PARAM_STR);
                $stmt->execute();
                $arrayOfId = $stmt->fetchAll(PDO::FETCH_COLUMN); // Stocke le résultat dans le tableau
                $stmt->closeCursor();
            }
        } else {
            if ($UserId == null) {
                $stmt = $this->conn->prepare("SELECT DISTINCT PageId FROM BLOG_Page WHERE dateP < ? ORDER BY dateP DESC LIMIT 5");
                $stmt->bindParam(1, $date, PDO::PARAM_STR);
                $stmt->execute();
                $arrayOfId = $stmt->fetchAll(PDO::FETCH_COLUMN); // Stocke le résultat dans le tableau
                $stmt->closeCursor();
            } else {
                $stmt = $this->conn->prepare("SELECT DISTINCT PageId FROM BLOG_Page WHERE dateP < ? AND UserId = ? ORDER BY dateP DESC LIMIT 5");
                $stmt->bindParam(1, $date, PDO::PARAM_STR);
                $stmt->bindParam(2, $UserId, PDO::PARAM_STR);
                $stmt->execute();
                $arrayOfId = $stmt->fetchAll(PDO::FETCH_COLUMN); // Stocke le résultat dans le tableau
                $stmt->closeCursor();
            }

        }
        return $arrayOfId;
    }


    /*
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

    public function get5pagesByCategory($arrayOfLabel)
    {
        // on recupere les id de la liste de label fournis en param
        // on renvoie les 5 page de blog les plus récentes qui ont les categories correspondantes
        try {
            $arrayOfId = null;

            //getCategoryByLabel renvoie l'id de la category selon le label
            // renvoi false lorsque la category n'existe pas
            for ($i = 0; $i < count($arrayOfLabel); $i++) {
                $res = (new Blog_Category())->getCategoryByLabel($arrayOfLabel[$i]);
                if ($res == false) {
                    return false;
                } else {
                    $arrayOfId[$i] = $res;
                }
            }
            // on a maintenant un tableau d'id de category qu'on va utiliser pour recuperer les id des pages dans la requete sql
            $stmt = $this->conn->prepare("SELECT PageId FROM BLOG_categoryPage WHERE CategoryId IN ? ORDER BY dateP DESC LIMIT 5");
            $stmt->bindParam(1, $arrayOfId, PDO::PARAM_STR);
            $stmt->execute();
            $arrayOfPageId = $stmt->fetchAll(PDO::FETCH_COLUMN); // Stocke le résultat dans le tableau
            return $arrayOfPageId;
        } catch (ExceptionsDatabase $e) {
            return $e;
        }
    }

    public function getValuesById($Id)
    {
        $mapArrayOfPageValues = null;
        try {
            if (!$this->isPageIdExist($Id)) {
                throw new ExceptionsDatabase("This page doesn't exist");
            }

            $stmt = $this->conn->prepare("SELECT * FROM BLOG_Page WHERE PageId = ?");
            $stmt->bindParam(1, $Id, PDO::PARAM_STR);
            $stmt->execute();
            $mapArrayOfPageValues = $stmt->fetch(PDO::FETCH_ASSOC); // Stocke le résultat dans le tableau

            $stmt->closeCursor();
        } catch (ExceptionsDatabase $e) {
            //echo $e->getMessage();
            return $e;
        }

        return $mapArrayOfPageValues; // Retourne le tableau avec les valeurs de la requete
    }

    public function isPageIdExist($Id)
    {
        $stmt = $this->conn->prepare("SELECT count(*) FROM BLOG_Page WHERE PageId = ?");
        $stmt->bindParam(1, $Id, PDO::PARAM_STR);
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
    public function doesPageIdBelongToUser(mixed $idPost, mixed $UserId)
    {
        $stmt = $this->conn->prepare("SELECT count(*) FROM BLOG_Page WHERE PageId = ? AND UserId = ?");
        $stmt->bindParam(1, $idPost, PDO::PARAM_STR);
        $stmt->bindParam(2, $UserId, PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->fetchColumn();
        return $count > 0;
    }

    public function update_img(mixed $idPost, $newImg)
    {
    }

}