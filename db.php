<?php

class Db {
    private $host = "db.3wa.io";
    private $user = "adrienboeglin";
    private $pwd = "59a6226e81d4068118e5f88f966dc992";
    private $db = "adrienboeglin_login";
    private $pdo;
    
    public function __construct() {
        $dsn = 'mysql:dbname='.$this->db.';host='.$this->host;
        //Créer la connexion à la BDD
        $this->pdo = new PDO($dsn, $this->user, $this->pwd);
    }
    
    public function getDb() {
        return $this->pdo;
    }
}