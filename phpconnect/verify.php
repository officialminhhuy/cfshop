<?php
include("dbcon.php");

if (isset($_POST['login-button'])) {
    $username = $_POST['email'];
    $password = $_POST['password'];
    // $status = "disable";
    $userProperties = [
        'email' => $username,
        'emailVerified' => false,
        // 'phoneNumber' => '+84' $phone,
        'password' => 'secretPassword',
        // 'displayName' => 'John Doe',
        // 'photoUrl' => 'http://www.example.com/12345678/photo.png',
        'disabled' => false,
    ];
    $createdUser = $auth->createUser($userProperties);
    if ($createdUser) {
        session_start();
        $_SESSION["username"] = $username;
        $_SESSION["password"] = $password;
        $_SESSION['status'] = " Create successfully!";
        $auth->sendEmailVerificationLink($username);
        header("Location: status.php");
        exit();
    } else {
        $_SESSION['status'] = " Create not successful!";
        header("Location: registration.php");
        exit();
    }
}
