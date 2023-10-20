<?php
class ITPageModel
{
    private PDO $conn;
    private DBBrain $DBBrain;

    public function __construct()
    {
        $this->DBBrain = new DBBrain();
        $this->conn = $this->DBBrain->getConn();
    }

    public function getPageById ($pageId) {
        // selection par date (peut être null)
    }

    public function getPageByDate ($pageDate) {

    }

    public function createPage ($CurrentUserId, $title, $message, $UrlPicture) {
        // TODO boucle for pour afficher 5 articles par 5 article en fonction du plus récent
    }


}