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

        if (!$this->accountExist()) { 
            $this->errors['usernameLI'] = "This account doesn't exist.";  // username not in system
        } else {
            if ($this->isInvalidUsernameOrEmail()) {
                $this->errors['usernameLI'] = "Invalid username or email.";
            }

            if ($this->passwordNotMatch()) {
                $this->errors['passwordLI'] = "Wrong password.";
            }
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


    private function accountExist() {
        $query = "SELECT COUNT(UserID) AS userCount FROM accounts
                  WHERE LOWER(UserName) = LOWER(:userName)
                  OR LOWER(userEmail) = LOWER(:userName)";

        $stmt = $this->connect()->prepare($query);
        $stmt->bindParam(':userName', $this->un);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['userCount'] > 0; // true if username or email is already in system, false if user is not in the system
    }
}