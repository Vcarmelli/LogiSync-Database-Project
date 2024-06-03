<?php

include_once 'database.php';
include_once 'signup.php';
include_once 'login.php';

error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);

if(isset($_POST['action']) && $_POST['action'] == 'signup') {

    $name = $_POST["username"];
    $pass = $_POST["password"]; 
    $repass = $_POST["repassword"];
    $email = $_POST["email"];  

    $signup = new Signup($name, $pass, $repass, $email);
    $signup->validateSignUpAccount();
    $signup->signupUser();

    if (empty($signup->errors)) {
        $response = ['success' => true, 'message' => 'Account created successfully.'];
    } else {
        $response = ['success' => false, 'errors' => $signup->errors];
    }

} else if(isset($_POST['action']) && $_POST['action'] == 'login') {
    $name = $_POST["username"];
    $pass = $_POST["password"]; 

    $login = new Login($name, $pass);
    $login->validateLogInAccount();
    $login->loginUser();

    if (empty($login->errors)) {
        $response = ['success' => true, 'message' => 'Account logged in successfully.'];
    } else {
        $response = ['success' => false, 'errors' => $login->errors];
    }
}

header('Content-Type: application/json');
echo json_encode($response);