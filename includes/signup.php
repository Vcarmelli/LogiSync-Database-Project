<?php

class Signup extends Database {
    private $un;
    private $pw;
    private $repw;
    private $email;
    public $errors = [];

    public function __construct($un, $pw, $repw, $email) {
        $this->un = $un;
        $this->pw = $pw;
        $this->repw = $repw;
        $this->email = $email;
    }
    public function validateSignUpAccount() {
        if ($this->isInvalidUsername()) {
            $this->errors['username'] = "Invalid username.";
        }

        if ($this->isInvalidEmail()) {
            $this->errors['email'] = "Invalid email.";
        }

        if ($this->passwordNotMatch()) {
            $this->errors['repassword'] = "Password doesn't match.";
        }

        if ($this->isUserTaken()) {
            if ($this->errors['username']) {
                $this->errors['email'] = "This email already exist.";
            } else {
                $this->errors['username'] = "This username already exist.";
            }
        }
    }

    public function signupUser() {
        $stmt = $this->connect()->prepare('INSERT INTO accounts (UserName, UserPass, UserEmail) VALUES (?, ?, ?);');

        $hashedPwd = password_hash($this->pw, PASSWORD_DEFAULT);

        if(!$stmt->execute(array($this->un, $hashedPwd, $this->email))) {
            $stmt = null;
            $this->errors['query'] = "Query statement failed.";
            return;
        }
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
        $stmt = $this->connect()->prepare('SELECT UserName FROM accounts WHERE UserName = ? OR UserEmail = ?;');

        if(!$stmt->execute(array($this->un, $this->email))) {
            $stmt = null;
            $this->errors['query'] = "Query statement failed.";
            return;
        }

        if ($stmt->rowCount() > 0) {
            return true; // username or email is already taken
        }
        return false; // username or email is not yet taken
    }
}