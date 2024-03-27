<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title>KapeTann | Registration Form</title>
    <link rel="stylesheet" href="../assets/css/login.css" />
    <link rel="icon" type="image/x-icon" href="../assets/images/favicon.ico"><!-- Favicon / Icon -->
</head>

<body>
    <?php
    require('db.php');
    include('dbcon.php');
    // When form submitted, insert values into the database.
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = stripslashes($_REQUEST['email']);
        $username = mysqli_real_escape_string($con, $username);
        $password = stripslashes($_REQUEST['password']);
        $password = mysqli_real_escape_string($con, $password);
        $status = "disable";
        // $create_datetime = date("Y-m-d H:i:s");
        $query    = "INSERT into `accounts` (username, password, status)
                            VALUES ('$username', '" . md5($password) . "','$status')";
        $result   = mysqli_query($con, $query);
        if ($result) {
            session_start();
            $_SESSION["username"] = $username;
            $_SESSION["password"] = $password;
            $user = [
                'username' => $username,
                'password' => $password,
                'status' => $status
            ];
            $newUser = $database->getReference('users')->push($user);

            if ($newUser) {
                include("verify.php");
            } else {
            }
        } else {
            echo "<div class='form'>
                            <h3>Required fields are missing.</h3><br/>
                        <p class='link'>Click here to <a href='registration.php'>registration</a> again.</p>
                        </div>";
        }
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
        <label for="password">Password:</label>
        <input type="text" class="login-input" name="password" placeholder="Password" required />
        <label for="cfpassword">Confirm password:</label>
        <input type="text" class="login-input" name="cfpassword" placeholder="Confirm password" required>
        <input type="submit" name="login-button" value="Register" class="login-button" id="login-button">
        <p class="link">Already have an account? <a href="/php/login.php">Login here!</a></p>
    </form>
    <?php
    }
    ?>
</body>

</html>