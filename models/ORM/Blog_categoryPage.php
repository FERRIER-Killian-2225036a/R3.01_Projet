<?php

/**
 * la Classe Blog_categoryPage de l'orm pour faire les acces a la base de données et recuperer les valeurs de la table BLOG_categoryPage
 *
 * les attributs de la table BLOG_categoryPage sont :
 * - PageId : int
 * - CategoryId : int
 *
 * Cette classe fait le lien entre un post de blog et une categorie
 *
 * @see Blog_Page
 * @see Blog_Category
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
class Blog_categoryPage
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
     * Blog_categoryPage constructor.
     */
    public function __construct()
    {
        $this->DBBrain = new DBBrain();
        $this->conn = $this->DBBrain->getConn();
    }

    /**
     * Cette methode permet de créer un lien entre une catégorie et une page si le lien n'existe pas déjà
     *
     * @param int $cat_id
     * @param int $page_id
     * @return void
     */
    public function createLinkBetweenCategoryAndPage(int $cat_id, int $page_id): void
    {
        //nouveau tuple dans la bdd dans table categoryPage
        if (!$this->linkBetweenCategoryAndPageExist($cat_id, $page_id ) && $this->NumberOfLinkBtwnCatAndPage($cat_id,$page_id) < 3) {
            $sql = "INSERT INTO BLOG_categoryPage (PageId, CategoryId) VALUES (?,?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $page_id);
            $stmt->bindParam(2, $cat_id);
            $stmt->execute();
            $stmt->closeCursor();
        }
    }

    /*            Fonctionne mais pas encore utile

    public function removeLinkBetweenCategoryAndPage($cat_id, $page_id): void
    {
        // on supprime le tuple , normalement ne pose aucun soucis car pas de contrainte d'intégrité
        // on pensera a appeler cette methodes lorsqu'on constate une différence entre :
        // les tags existants et les tags mit a jour par la modification (post/blogEdit)
        if ($this->linkBetweenCategoryAndPageExist($cat_id, $page_id)) {
            $sql = "DELETE FROM BLOG_categoryPage WHERE PageId = ? AND CategoryId = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $page_id, PDO::PARAM_STR);
            $stmt->bindParam(2, $cat_id, PDO::PARAM_STR);
            $stmt->execute();
            $stmt->closeCursor();
        }
    }*/

    /**
     * Méthode permettant de vérifier si un lien entre une catégorie et une page de blog existe
     *
     * @param int $cat_id
     * @param int $page_id
     * @return bool
     */
    public function linkBetweenCategoryAndPageExist(int $cat_id, int $page_id): bool
    {
        $stmt = $this->conn->prepare("SELECT count(*) FROM BLOG_categoryPage WHERE CategoryId = ? AND PageId = ?");
        $stmt->bindParam(1, $cat_id);
        $stmt->bindParam(2, $page_id);
        $stmt->execute();
        $count = $stmt->fetchColumn();
        return $count > 0;
    }

    /**
     * Méthode pour recuperer les id des categories d'une page de blog (normalement il y en a 3 max)
     *
     * @param int $idPost
     * @return array
     */
    public function getCategoryByPageId(int $idPost): array
    {
        $stmt = $this->conn->prepare("SELECT CategoryId FROM BLOG_categoryPage WHERE PageId = ?");
        $stmt->bindParam(1, $idPost);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        $arrayOfCategoryId = array();
        foreach ($result as $row) { $arrayOfCategoryId[] = (new Blog_Category())->getCategoryById($row['CategoryId']);}
        return $arrayOfCategoryId;
    }

    /**
     * Méthode pour recuperer le nombre de lien entre une catégorie et une page, soit le nombre de catégorie lié a une
     * page
     *
     * @param int $cat_id
     * @param int $page_id
     * @return int
     */
    public function NumberOfLinkBtwnCatAndPage(int $cat_id, int $page_id): int
    { // on renvoie le nombre de catégorie
        $stmt = $this->conn->prepare("SELECT count(*) FROM BLOG_categoryPage WHERE CategoryId = ? AND PageId = ?");
        $stmt->bindParam(1, $cat_id);
        $stmt->bindParam(2, $page_id);
        $stmt->execute();
        return $stmt->fetchColumn(); // renvoie le nombre de lien entre une catégorie et une page
    }

    /**
     * Méthode pour supprimer tous les liens entre une catégorie et une page
     *
     * @param int $page_id
     * @return void
     */
    public function removeAllLinkBetweenCategoryAndPage(int $page_id): void
    {
        $sql = "DELETE FROM BLOG_categoryPage WHERE PageId = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1, $page_id, PDO::PARAM_STR);
        $stmt->execute();
        $stmt->closeCursor();
    }

    /**
     * méthode pour recuperer 5 pages ou moins selon leur catégorie id donnée
     *
     * @param int|string $catId
     * @return false|array
     */
    public function get5PagesByCategory(int|string $catId): false|array
    {
        $stmt = $this->conn->prepare("SELECT PageId FROM BLOG_categoryPage WHERE CategoryId = ? ORDER BY DateBlog DESC LIMIT 5");
        $stmt->bindParam(1, $catId);
        $stmt->execute();
        $arrayOfId = $stmt->fetchAll(PDO::FETCH_COLUMN);
        $stmt->closeCursor();
        return $arrayOfId;
    }
}