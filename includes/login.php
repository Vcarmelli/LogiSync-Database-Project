<?php

class Login extends Database {
    protected function getUser($uid, $pwd) {
        $stmt = $this->connect()->prepare('SELECT UserName FROM accounts WHERE UserID = ? OR Email = ?;');

        if(!$stmt->execute(array($uid, $pwd))) {
            $stmt = null;
            header("location: ../index.php?error=stmtfailed");
            exit();
        }

        if($stmt->rowCount() == 0) {
            $stmt = null;
            header("location: ../index.php?error=usernotfound");
            exit();
        }
        $pwdHashed = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $checkPwd = password_verify($pwd, $pwdHashed[0]["UserPass"]); //true if same password

        if($checkPwd == false) {
            $stmt = null;
            header("location: ../index.php?error=wrongpassword");
            exit();
        }
        else if($checkPwd == true) {
            $stmt = $this->connect()->prepare('SELECT * FROM accounts WHERE UserID = ? OR UserEmail = ? AND UserPass = ?;');

            if(!$stmt->execute(array($uid, $uid, $pwd))) {
                $stmt = null;
                header("location: ../index.php?error=stmtfailed");
                exit();
            }

            if($stmt->rowCount() == 0) {
                $stmt = null;
                header("location: ../index.php?error=usernotfound");
                exit();
            }

            $user = $stmt->fetchAll(PDO::FETCH_ASSOC);

            session_start();
            $_SESSION["userid"] = $user[0]["UserID"];
            $_SESSION["username"] = $user[0]["UserName"];

            $stmt = null;
        }
    }
}