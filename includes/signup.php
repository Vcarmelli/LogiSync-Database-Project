<?php

class Signup extends Database {
    private $un;
    private $pw;
    private $repw;
    private $email;

    public function __construct($un, $pw, $repw, $email) {
        $this->un = $un;
        $this->pw = $pw;
        $this->repw = $repw;
        $this->email = $email;
    }
    public function validateSignUpAccount() {
        $valid = true;
        if ($this->isInvalidUsername()) {
            echo "invalid un sign up";
            $valid = false;
        }

        if ($this->isInvalidEmail()) {
            echo "invalid em sign up";
            $valid = false;
        }

        if ($this->passwordNotMatch()) {
            echo "pass not match sign up";
            $valid = false;
        }

        if ($this->isUserTaken()) {
            echo "un taken sign up";
            $valid = false;
        }
        
        return $valid;
    }

    public function signupUser() {
        $stmt = $this->connect()->prepare('INSERT INTO accounts (UserName, UserPass, UserEmail) VALUES (?, ?, ?);');

        $hashedPwd = password_hash($this->pw, PASSWORD_DEFAULT);

        if(!$stmt->execute(array($this->un, $hashedPwd, $this->email))) {
            $stmt = null;
            //header("location: ../index.php?error=stmtfailed");
            exit();
        }
        //header("location: ../index.php?message=signupSuccess");
        $stmt = null;
    }

    private function isInvalidUsername() {
        if (preg_match('/^[a-zA-Z0-9]+$/', $this->un)) {
            return false; // valid name
        }
        return true; // invalid name
    }

    private function isInvalidEmail() {
        if (filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            return false; // valid email
        }
        return true; // invalid email
    }

    private function passwordNotMatch() {
        if ($this->pw === $this->repw) {
            return false; //password are match
        }
        return true; // pass not match
    }

    private function isUserTaken() {
        $stmt = $this->connect()->prepare('SELECT UserName FROM accounts WHERE UserID = ? OR UserEmail = ?;');

        if(!$stmt->execute(array($this->un, $this->email))) {
            $stmt = null;
            //header("location: ../index.php?error=stmtfailed");
            exit();
        }

        if ($stmt->rowCount() > 0) {
            return true; // username or email is already taken
        }
        return false; // username or email is not yet taken
    }
}