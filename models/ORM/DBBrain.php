<?php

/**
 * Classe de l'orm Principal avec des utilitaires contenant des méthodes utiles pour la base de données
 * Ainsi que que l'attribut de connexion à la base de données
 *
 * //TODO on pourrait dans le futur faire en sorte que toutes les classes de l'orm hérite de celle ci,
 * et meme pousser le truc plus loin en généralisant les méthodes de l'orm avec les CRUD de base
 * et la specialisation pour les classes filles
 *
 * @package models/ORM
 * @since 1.0
 * @version 1.0
 * @category dbBrain
 * @author Tom Carvajal & Vanessa Guil
 */
class DBBrain
{
    /**
     * @var PDO $conn variable de connexion a la base de données
     */
    private PDO $conn;

    /**
     * DBBrain constructor.
     */
    public function __construct()
    {
        $this->conn = DatabaseManager::getInstance();
    }

    /**
     * cette methode est un getteur pour l'attribut connexion
     *
     * @return PDO
     */
    public function getConn(): PDO
    {
        return $this->conn;
    }

    /**
     * Cette méthode permet de savoir si un mot de passe (clair) est sécurisé (présence dans bdd leak) ou non
     * @param string $password_a
     * @return bool
     */
    public function isPasswordNotSafe(string $password_a): bool
    {
        $hashedPassword = strtoupper(sha1($password_a));
        $prefix = substr($hashedPassword, 0, 5); // Prend les 5 premiers caractères du hachage (préfixe)
        $apiUrl = "https://api.pwnedpasswords.com/range/" . $prefix; // Fais une requête à l'API Have I Been Pwned
        $response = file_get_contents($apiUrl);                     // Recherche le reste du hachage dans la réponse
        $searchTerm = substr($hashedPassword, 5);
        $searchResult = preg_match('/' . $searchTerm . ':(\d+)/', $response);
        // Si le mot de passe est apparu dans un leak d'have i been pwnd, retourne false
        if ($searchResult) {
            return true;
        }
        // Si le mot de passe est suffisamment fort, retourne true
        return false;
    }

    /**
     * Cette méthode permet de savoir si un email donner en paramètre est valide ou non
     *
     * @param string $mail_a
     * @return bool
     */
    public function isValidEmail(string $mail_a): bool
    {
        return filter_var($mail_a, FILTER_VALIDATE_EMAIL) !== false;
    }

    /**
     * Cette méthode permet de hasher le mot de passe en utilisant l'algo ARGON2ID (algo tres lent)
     * et en ajoutant un poivre (pour eviter les attaques par rainbow table)
     *
     * @param string $password_a
     * @return string
     */
    public function argonifiedPassword(string $password_a): string
    {
        // on ajoute un poivre
        $pwd_peppered = hash_hmac("sha256", $password_a, Constants::$PEPPER);
        // on utilise l'algo de hachage ARGON2ID
        $options = [ // configuration minimale recommandé par OWASP TOP 10 (cheat sheet)
            'memory_cost' => 65536, // 19 MiB en kibibytes (1024 * 19)
            'time_cost' => 2, // 2 itérations
            'threads' => 1, // Degré de parallélisme de 1
        ];

        // on utilisera password_verify($passwordFromUser, $storedHashedPassword)) pour verifier le mot de passe
        // lors de la connexion
        return password_hash($pwd_peppered, PASSWORD_ARGON2ID, $options);
    }

    /**
     * Cette méthode permet de savoir si un pseudo est valide ou non
     *
     * @param string $new_pseudo
     * @return bool|string
     */
    public function isValidPseudo(string $new_pseudo): bool|string
    {
        // fixe une limite de caractère
        if (strlen($new_pseudo) > 20 || strlen($new_pseudo) < 3) {
            return false;
        }
        //verifie que le pseudo est uniquement composé de caractère alphanumérique ou d'espace, avec au moins un caractère
        if (!preg_match('/^[a-zA-Z0-9 _]+$/', $new_pseudo)) {
            return false;
        }
        // remplace les espaces par des underscore
        if (preg_match('/\s/', $new_pseudo)) {
            $new_pseudo = str_replace(' ', '_', $new_pseudo);
        }
        return $new_pseudo;

    }
}