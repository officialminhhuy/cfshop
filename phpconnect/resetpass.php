<?php
session_start();
require('db.php');
// if (!empty($_SESSION)) {
//     $username = $_SESSION["username"];
//     $stmt = $con->prepare("SELECT otpcode FROM verify WHERE username = ?");
//     $stmt->bind_param("s", $username);
//     $stmt->execute();
//     $result = $stmt->get_result();
//     $row = $result->fetch_assoc();
//     if (empty($row['otpcode'])) {
//         header("Location: /phpconnect/forgot.php");
//         exit();
//     }
// } else {
//     header("Location: /phpconnect/forgot.php");
//     exit();
// }
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_SESSION["username"];
    $password = $_POST['password'];
    $password = stripslashes($_REQUEST['password']);
    $password = mysqli_real_escape_string($con, $password);
    $query = "UPDATE accounts SET password = '" . md5($password) . "' WHERE username = '$username'";
    $result   = mysqli_query($con, $query);
    if ($result) {
        $_SESSION["username"] = $username;
        $_SESSION["password"] = $password;
        header("Location: /phpconnect/Sucess.php");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" href="/assets/css/Account.css">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <div class="login-container" id="login-container">
        <div class="form">
            <img id="imglogo1" src="/images/LoGoMinhTam_preview_rev_1.png" alt="img1">
            <h2>Final Step</h2>
            <p>Please complete for get your account back!</p>

            <form id="form" method="post" style="text-align: center; width: 60%; margin: auto; max-width: 500px; ">
                <div class="form-group">
                    <label for="password">New Password:</label>
                    <input type="password" id="password" name="password"
                        pattern=".*[A-Z].*[!@#$%^&*()-=_+{}[];':.,/<>?`~].*" minlength="8" maxlength="16"
                        title="Password must contain at least one UPPERCASE and special character" required>
                </div>
                <div class="form-group">
                    <label for="cfpassword">Confirm Password:</label>
                    <input type="password" id="cfpassword" name="cfpassword" title="The confirm password not match"
                        required>
                </div>
                <div class="form-group">
                    <button type="submit" id="signupbtn" name="signupbtn" required>Change Password</button>
                </div>
            </form>

        </div>
    </div>
</body>
<script>
function myFunction() {
    var x = document.getElementById("password");
    var y = document.getElementById("cfpassword");

    if (x.type === "password") {
        x.type = "text";
        y.type = "text"; // Change type to text for y element
    } else {
        x.type = "password";
        y.type = "password"; // Change type to password for y element
    }
}
</script>


</html>