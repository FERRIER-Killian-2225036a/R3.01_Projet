<?php

/**
 * la Classe Blog_Category de l'orm pour faire les acces a la base de données et recuperer les valeurs de la table BLOG_Category
 *
 * les attributs de la table BLOG_Category sont :
 * - CategoryId : int
 * - label : varchar(150)
 * - description : text
 *
 * Cette classe concerne les catégories des blogs, on fait le lien d'une catégorie avec une page grace a la table
 * BLOG_CategoryPage.
 *
 *
 * @see Blog_Page
 * @see Blog_categoryPage
 * @see UserSite
 * @see ControllerMenu
 * @see ControllerPost
 *
 * @package models/ORM
 * @since 1.0
 * @version 1.0
 * @category blog
 * @author Tom Carvajal & Vanessa Guil
 */
class Blog_Category
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
     * Blog_Category constructor.
     */
    public function __construct()
    {
        $this->DBBrain = new DBBrain();
        $this->conn = $this->DBBrain->getConn();
    }

    /**
     * Méthode pour créer une catégorie
     *
     * @param string $label
     * @param string|null $description
     * @return false|string
     */
    public function createCategory(string $label,?string $description = null) : false|string
    {
        //si la category avec x label existe
        if ($this->doesCategoryExist($label)) {
            $stmt = $this->conn->prepare("SELECT CategoryId FROM BLOG_Category WHERE label = ?");
            $stmt->bindParam(1, $label);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
            return $result['CategoryId'];
            // on renvoi l'id de la category
        } else { //si la category n'existe pas avec le label, on la crée
            $stmt = $this->conn->prepare("INSERT INTO BLOG_Category (label,description) VALUES (?,?)");
            $stmt->bindParam(1, $label);
            $stmt->bindParam(2, $description);
            $stmt->execute();
            $stmt->closeCursor();
            return $this->conn->lastInsertId();
            // on renvoi l'id de la category
        }
    }


    /**
     * Méthode pour vérifier si une catégorie existe par rapport a un label
     *
     * @see Blog_Category::doesCategoryIdExist()
     * @param string $label
     * @return bool
     */
    public function doesCategoryExist(string $label): bool
    {
        $stmt = $this->conn->prepare("SELECT count(*) FROM BLOG_Category WHERE label = ?");
        $stmt->bindParam(1, $label);
        $stmt->execute();
        $count = $stmt->fetchColumn();
        return $count > 0;
    }

    /**
     * Méthode pour vérifier si une catégorie existe par rapport a un id
     *
     * @see Blog_Category::doesCategoryExist()
     * @param int $id
     * @return bool
     */
    public function doesCategoryIdExist(int $id): bool
    {
        $stmt = $this->conn->prepare("SELECT count(*) FROM BLOG_Category WHERE CategoryId = ?");
        $stmt->bindParam(1, $id);
        $stmt->execute();
        $count = $stmt->fetchColumn();
        return $count > 0;
    }

    /**
     * Méthode pour récupérer un label de categorie par rapport a son id
     *
     * @param int $id
     * @return string|false
     */
    public function getCategoryById(int $id): false|string
    {
        if ($this->doesCategoryIdExist($id)) {
            $stmt = $this->conn->prepare("SELECT label FROM BLOG_Category WHERE CategoryId = ?");
            $stmt->bindParam(1, $id);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
            return $result['label'];
        } else return false;
        // renvoie le label d'une category selon son identifiant ou false
    }


    /**
     * Méthode pour récupérer un id de categorie par rapport a son label
     *
     * @param string $label
     * @return string|false
     */
    public function getCategoryByLabel(string $label): false|string
    {
        if ($this->doesCategoryExist($label)) {
            $stmt = $this->conn->prepare("SELECT CategoryId FROM BLOG_Category WHERE label = ?");
            $stmt->bindParam(1, $label );
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
            return $result['CategoryId']; //renvoie l'id si elle existe
        } else return false;              //renvoi false si elle n'existe pas

    }

    /*
    public function removeCategoryById($id)
    {
        //si l'id existe on supprime le tuple // attention contrainte d'intégrité dans categoryPage
        // a voir si on implémente donc...
    }
    */

    /**
     * renvoie un tableau de toutes les identifiants de categorie ou l'input est dans la chaine du lable ou description
     *
     * @param int|string $inputToSearch
     * @return bool|array
     */
    public function getCategoryIdByResearch(int|string $inputToSearch): bool|array
    {
        $sql = "SELECT CategoryId FROM BLOG_Category WHERE label LIKE ? OR description LIKE ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, '%' . $inputToSearch . '%');
        $stmt->bindValue(2, '%' . $inputToSearch . '%');

        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $result;
    }

}