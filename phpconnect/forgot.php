<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title>KapeTann | Reset Form</title>
    <link rel="stylesheet" href="../assets/css/login.css" />
    <link rel="icon" type="image/x-icon" href="../assets/images/favicon.ico"><!-- Favicon / Icon -->
</head>

<body>
    <?php
    require('db.php');
    include('dbcon.php');
    // When form submitted, insert values into the database.
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['email'];
        $stmt = $con->prepare("SELECT username FROM accounts WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows == 1) {
            session_start();
            $_SESSION["username"] = $username;
            $stmt = $con->prepare("SELECT username FROM verify WHERE username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows == 1) {
                $stmt = $con->prepare("SELECT username FROM verify WHERE username = ? AND otpcode IS NULL");
                $stmt->bind_param("s", $username);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result->num_rows == 1) {

                    include('phpmailer.php');
                } else {
                    echo '<script> alert("Please check your email");</script>';
                    header("Location: /phpconnect/reset.php");
                }
            } else {
                $insertAccountStmt = $con->prepare("INSERT INTO verify (username) VALUES (?)");
                $insertAccountStmt->bind_param("s", $username);
                if ($insertAccountStmt->execute()) {
                    include('phpmailer.php');
                } else {
                    echo 'Please reload!';
                }
            }
        } else {
            echo '<script> alert(" Email is never Sign up yet "); </script>';
            header("Refresh:0");
            exit;
        }

        $stmt->close();
    } else {
    ?>
        <form class="form" action="" method="post">
            <center>
                <img src="../assets/images/logo.png" alt="" class="img img-fluid">
            </center>
            <hr />
            <h1 class="login-title">Registration</h1>
            <label for="email">Email:</label>
            <input type="text" class="login-input" name="email" placeholder="Example@gmail.com" required />
            <input type="submit" name="login-button" value="Register" class="login-button" id="login-button">
            <p class="link">Already have an account? <a href="/php/login.php">Login here!</a></p>
        </form>
    <?php
    }
    ?>
</body>

</html>