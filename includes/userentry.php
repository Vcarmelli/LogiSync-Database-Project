<?php

include_once 'database.php';
include_once 'signup.php';
include_once 'login.php';

if(isset($_POST["signup"])) {

    $name = $_POST["username"];
    $pass = $_POST["password"]; 
    $repass = $_POST["repassword"];
    $email = $_POST["email"];  

    ob_start();
    $signup = new Signup($name, $pass, $repass, $email);

    if ($signup->validateSignUpAccount()) {
        $signup->signupUser();
        //header("location: ../index.php?error=none");
        exit();
    }
    $output = ob_get_clean();
    session_start();
    session_unset();
    $_SESSION["OUTPUT"] = $output;
    //header("location: ../index.php?error=error_signingup");


} else if(isset($_POST['action']) && $_POST['action'] == 'login') {
    $name = $_POST["username"];
    $pass = $_POST["password"]; 

    //ob_start();
    $login = new Login($name, $pass);

    if ($login->validateLogInAccount()) {
        $login->loginUser();
        // header("location: ../index.php?error=none");
        // exit();
        echo "validated";
        exit();
    }

    // $output = ob_get_clean();
    // session_start();
    // session_unset();
    // $_SESSION["OUTPUT"] = $output;
    //header("location: ../index.php?error=error_logingIn");
    
    echo "not valid";
}