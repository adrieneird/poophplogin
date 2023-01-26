<?php

require_once "class/user.php";

class FormLogin {
    public $mail;
    public $password;
    
    public function __construct() {
        $this->password = $this->sanitize('pwd');
        $this->mail = $this->sanitize('mail');
    }
    
    private function sanitize($name) {
        if (isset($_POST[$name])) {
            if (!empty($_POST[$name])) {
                return trim(htmlentities($_POST[$name]));
            }
        }
        return null;
    }
    
    public function process($pdo) {
        $user = new User();
        if ($user->loadFromMail($pdo, $this->mail)) {
            // Comme le mot de passe est haché, on ne peut pas faire autrement
            if (password_verify($this->password, $user->password)) {
                $_SESSION['id'] = $user->id;
            } else {
                echo "Login ou mot de passe incorrect ou inexistant.";
            }
        } else {
            // Pas réussi à charger l'utilisateur à l'aide de son mail
            echo "Login ou mot de passe incorrect ou inexistant.";
        }
    }
}