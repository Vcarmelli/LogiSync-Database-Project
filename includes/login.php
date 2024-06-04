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
            $this->errors['usernameLI'] = "This account doesn't exist.";  // username not in system
        }

        if ($this->passwordNotMatch()) {
            $this->errors['passwordLI'] = "Wrong password.";
        }
    }

    public function loginUser() {
        session_start();
        $_SESSION["username"] = $this->un;
    }

    private function passwordNotMatch() {
        $stmt = $this->connect()->prepare('SELECT UserPass FROM accounts WHERE UserName = ? OR UserEmail = ?;');
    
        if(!$stmt->execute(array($this->un, $this->un))) { // if user enter either username or email
            $stmt = null;
            $this->errors['query'] = "Query statement failed.";
            return false;
        } 
    
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        $samePass = password_verify($this->pw, $user["UserPass"]);
        
        if ($samePass) {
            $stmt = null;
            return false;
        } else {
            $stmt = null;
            return true;
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
            return true;
        }

        if($stmt->rowCount() == 0) {
            //header("location: ../index.php?error=usernotfound");
            return true;  // username or email not yet sign up
        }
        return false;    // username or email is already in system 
    }
}