<?php

include_once 'database.php';
include_once 'signup.php';
include_once 'login.php';

// error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
header('Content-Type: application/json');
$response = [];

if(isset($_POST['action']) && $_POST['action'] == 'signup') {

    $name = $_POST["username"];
    $pass = $_POST["password"]; 
    $repass = $_POST["repassword"];
    $email = $_POST["email"];  

    $signup = new Signup($name, $pass, $repass, $email);
    $signup->validateSignUpAccount();

    if (empty($signup->errors)) {
        $signup->signupUser();
        $response = ['success' => true, 'message' => 'Account created successfully.'];
    } else {
        $response = ['success' => false, 'errors' => $signup->errors];
    }
    
    echo json_encode($response);

} else if(isset($_POST['action']) && $_POST['action'] == 'login') {
    $name = $_POST["username"];
    $pass = $_POST["password"]; 

    $login = new Login($name, $pass);
    $login->validateLogInAccount();

    if (empty($login->errors)) {
        $login->loginUser();
        $response = ['success' => true, 'message' => 'Account logged in successfully.'];
    } else {
        $response = ['success' => false, 'errors' => $login->errors];
    }
    echo json_encode($response);
}

