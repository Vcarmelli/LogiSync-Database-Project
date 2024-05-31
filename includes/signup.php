<!-- database related stuffs -->

<?php

class Signup extends Dbh {

    protected function setUser($un, $pw, $email) {
        $stmt = $this->connect()->prepare('INSERT INTO accounts (UserName, UserPass, UserEmail) VALUES (?, ?, ?);');

        $hashedPwd = password_hash($pw, PASSWORD_DEFAULT);

        if(!$stmt->execute(array($un, $hashedPwd, $email))) {
            $stmt = null;
            header("location: ../index.php?error=stmtfailed");
            exit();
        }

        $stmt = null;
    }
    protected function checkUser($un, $email) {
        $stmt = $this->connect()->prepare('SELECT UserName FROM accounts WHERE UserID = ? OR UserEmail = ?;');

        if(!$stmt->execute(array($un, $email))) {
            $stmt = null;
            header("location: ../index.php?error=stmtfailed");
            exit();
        }

        $resultCheck = false; 
        if($stmt->rowCount() > 0) {
            $resultCheck = false;
        }
        else {
            $resultCheck = true;
        }
        
        return $resultCheck;
    }
}