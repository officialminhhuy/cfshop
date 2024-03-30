<?php
include("db.php");
include("dbcon.php");
include("auth.php");

try {
    $user = $auth->getUserByEmail($username);
    if ($user->emailVerified) {
        echo 'Email is verified';
        $status = "active";
        $insertAccountStmt = $con->prepare("UPDATE accounts SET status = ? WHERE username = ?");
        $insertAccountStmt->bind_param("ss", $status, $username);
        if ($insertAccountStmt->execute()) {
            header("Location: /php/index.php");
        }
    } else {
        echo 'Hi,';
        echo $username;
        echo '</br></br>';
        echo 'Please check your email to complete! After that comeback and reload this page';
    }
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}
