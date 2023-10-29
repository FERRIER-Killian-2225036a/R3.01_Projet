<?php

class DBBrain
{
    private PDO $conn;
    public function __construct()
    {
        $this->conn= DatabaseManager::getInstance();
    }
    public function getConn(): PDO
{
    return $this->conn;
}

    public function isPasswordNotSafe($password_a): bool
    {
        //FONCTIONNE CORRECTEMENT

        $hashedPassword = strtoupper(sha1($password_a));
        // Prend les 5 premiers caractères du hachage (préfixe)
        $prefix = substr($hashedPassword, 0, 5);
        // Fais une requête à l'API Have I Been Pwned
        $apiUrl = "https://api.pwnedpasswords.com/range/" . $prefix;
        $response = file_get_contents($apiUrl);
        // Recherche le reste du hachage dans la réponse
        $searchTerm = substr($hashedPassword, 5);
        $searchResult = preg_match('/' . $searchTerm . ':(\d+)/', $response, $matches);
        // Si le mot de passe est apparu dans une fuite, retourne false
        if ($searchResult) {
            return true;
        }
        // Si le mot de passe est suffisamment fort, retourne true
        return false;
    }
    public function isValidEmail($mail_a): bool
    {
        return filter_var($mail_a, FILTER_VALIDATE_EMAIL)!== false;
    }

    public function argonifiedPassword($password_a): string
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
    public function isValidPseudo($new_pseudo)
    {
        // fixe une limite de caractère
        if (strlen($new_pseudo) > 20 && strlen($new_pseudo) < 3) {
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