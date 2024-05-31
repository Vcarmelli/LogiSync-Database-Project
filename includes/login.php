<?php

class Login extends Database {
    private $un;
    private $pw;

    public function __construct($un, $pw) {
        $this->un = $un;
        $this->pw = $pw;
    } 
    public function validateLogInAccount() {
        $valid = true;
        if ($this->isInvalidUsernameOrEmail()) {
            echo "Invalid username or email format";
            $valid = false;
        }

        if ($this->isAccountDoesntExist()) {  
            echo "no acc log in";
            $valid = false;  // usename already in system
        }
        return $valid;
    }

    public function loginUser() {
        $stmt = $this->connect()->prepare('SELECT UserPass FROM accounts WHERE UserName = ? OR UserEmail = ?;');
    
        $stmt->execute(array($this->un, $this->un)); // if user enter either username or email
    
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
        // Check if user exists
        if (!$user) {
            $stmt = null;
            //header("location: ../index.php?error=userNotFound");
            exit();
        }
    
        // Verify password
        $samePass = password_verify($this->pw, $user["UserPass"]);
        // echo "<script>console.log('Unhashed Password: " . $this->pw . "')</script>";
        // echo "<script>console.log('samePass? " . $samePass . "')</script>";
        if ($samePass) {
            session_start();
            $_SESSION["username"] = $this->un;
            $stmt = null;
            //header("location: ../dashboard.php?message=loginSuccess");
            //exit();
        } else {
            $stmt = null;
            //header("location: ../index.php?error=wrongPassword");
            exit();
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
            //header("location: ../index.php?error=stmtfailed");
            exit();
        }

        if($stmt->rowCount() == 0) {
            //header("location: ../index.php?error=usernotfound");
            return true;  // username or email not yet sign up
        }
        return false;    // username or email is already in system 
    }
}