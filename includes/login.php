<?php

class Login extends Database {
    private $un;
    private $pw;
    public $errors = [];

    public function __construct($un, $pw) {
        $this->un = $un;
        $this->pw = $pw;
    } 
    public function validateLogInAccount() {
    
        if ($this->isInvalidUsernameOrEmail()) {
            $this->errors['usernameLI'] = "Invalid username or email.";
        }

        if ($this->isAccountDoesntExist()) { 
            $this->errors['passwordLI'] = "This account doesn't exist.";  // username not in system
        }
    }

    public function loginUser() {
        $stmt = $this->connect()->prepare('SELECT UserPass FROM accounts WHERE UserName = ? OR UserEmail = ?;');
    
        if(!$stmt->execute(array($this->un, $this->un))) { // if user enter either username or email
            $stmt = null;
            $this->errors['query'] = "Query statement failed.";
            return;
        } 
    
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
        // Check if user exists
        if (!$user) {
            $stmt = null;
            $this->errors['passwordLI'] = "This account doesn't exist.";
            return; 
        }
        
        // User exists, then verify password
        $samePass = password_verify($this->pw, $user["UserPass"]);
        
        if ($samePass) {
            session_start();
            $_SESSION["username"] = $this->un;
            $stmt = null;
        } else {
            $stmt = null;
            $this->errors['passwordLI'] = "Wrong password.";
            return; 
        }
    }
    

    private function isInvalidUsernameOrEmail() {
        // Check if the input is a valid username
        if (preg_match('/^[a-zA-Z0-9]+$/', $this->un)) {
            return false;
        }
        // Check if the input is a valid email
        if (filter_var($this->un, FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        return true; // Neither a valid email nor a valid username
    }


    private function isAccountDoesntExist() {
        $stmt = $this->connect()->prepare('SELECT UserID FROM accounts WHERE UserName = ? OR UserEmail = ?;');

        if(!$stmt->execute(array($this->un, $this->un))) {
            $stmt = null;
            $this->errors['query'] = "Query statement failed.";
        }

        if($stmt->rowCount() == 0) {
            //header("location: ../index.php?error=usernotfound");
            return true;  // username or email not yet sign up
        }
        return false;    // username or email is already in system 
    }
}