<?php

use PHPUnit\Framework\Constraint\IsNull;

session_start();
require('db.php');

if (!empty($_SESSION)) {
    $username = $_SESSION["username"];
    $stmt = $con->prepare("SELECT otpcode FROM verify WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    if (empty($row['otpcode'])) {
        header("Location: /phpconnect/forgot.php");
        exit();
    }
} else {
    header("Location: /phpconnect/forgot.php");
    exit();
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $code = $_POST['code'];
    $stmt = $con->prepare("SELECT otpcode FROM verify WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    if (!empty($row['otpcode'])) {
        $otpcode = $row['otpcode'];
        if ($code === $otpcode) {
            $insertAccountStmt = $con->prepare("UPDATE verify SET otpcode = NULL WHERE username = ?");
            $insertAccountStmt->bind_param("s", $username);
            if ($insertAccountStmt->execute()) {
                header("Location: /phpconnect/resetpass.php");
            } else {
                echo '<script> alert("Ohno Wrong OTP!"); </script>';
                header("Location: /phpconnect/forgot.php");
                exit;
            }
        }
    } else {
        header("Location: /phpconnect/forgot.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" href="/assets/css/Account.css">
<title>Status</title>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <div class="login-container" id="login-container">
        <div class="form">
            <img id="imglogo1" src="/images/LoGoMinhTam_preview_rev_1.png" alt="img1">
            <h2>Sent code!</h2>
            <form id="form" method="post" style="text-align: center; width: 60%; margin: auto; max-width: 500px; ">
                <div class="form-group">
                    <label for="code">Please check your email:</label>
                    <input type="number" id="code" name="code" placeholder="OTP code" required>
                </div>
                <div class="form-group">
                    <button type="submit" id="signupbtn" name="signupbtn" required>Change Password</button>
                </div>
            </form>

        </div>
    </div>
</body>

</html>