<?php

include_once './includes/signup.php';
include_once './includes/login.php';

if(isset($_POST["signup"])) {

    $uid = $_POST["username"];
    $pwd = $_POST["password"]; 
    $pwdrepeat = $_POST["repassword"];
    $email = $_POST["email"];  


    $signup = new SignupContr($uid, $pwd, $pwdrepeat, $email);

    // running all error handlers
    $signup->signupUser();

    // back to front page
    header("location: ../index.php?error=none");


} else if(isset($_POST["login"])) {
    // grabing the data from html
    $uid = $_POST["username"];
    $pwd = $_POST["password"]; 

    // instantiate signupcontr class
    include "../classes/dbh.classes.php";
    include "../classes/login.classes.php";
    include "../classes/login-contr.classes.php";

    $login = new LoginContr($uid, $pwd);

    // running all error handlers
    $login->loginUser();

    // back to front page
    header("location: ../index.php?error=none");
}