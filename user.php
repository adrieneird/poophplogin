<?php
class User {
    public $id;
    public $nickname;
    public $mail;
    public $password;
    public $last_login;
    
    public function __construct($id = null) {
        $this->id = $id;
    }
    
    public function loadNickname($pdo) {
        $query = "SELECT nickname FROM user WHERE id=:id";
        $stmt = $pdo->prepare($query);
        $stmt->execute(['id' => $this->id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->nickname = $row['nickname'];
        return $this->nickname;
    }
    
    public function loadFromMail($pdo, $mail) {
        $query = "SELECT id, password FROM user WHERE mail=:mail";
        $stmt = $pdo->prepare($query);
        $stmt->execute(['mail' => $mail]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $this->mail = $mail;
            $this->id = $row['id'];
            $this->password = $row['password'];
            
            return true;
        }
        return false;
    }
    
    public function save($pdo) {
        if (!$this->id) {
            // Nouvel utilisateur = INSERT INTO
            $query = "INSERT INTO user (nickname, mail, password) VALUES (:pseudo, :mail, :pwd)";
            $stmt = $pdo->prepare($query);
            if ($stmt->execute(['mail' => $this->mail, 'pseudo' => $this->nickname, 'pwd' => $this->password])) {
                // Initialiser la session
                $this->id = $pdo->lastInsertId();
                $_SESSION['id'] = $this->id;
            }
        } else {
            // Utilisateur existant = UPDATE
            $query = "UPDATE user SET nickname=:nickname, password=:password, mail=:mail, last_login=:last_login WHERE id=:id";
            $stmt = $pdo->prepare($query);
            $stmt->execute(['id' => $this->id, 'mail' => $this->mail, 'pseudo' => $this->nickname, 'pwd' => $this->password, 'last_login' => $this->last_login]);
        }
    }
}