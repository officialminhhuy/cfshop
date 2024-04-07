<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title>KapeTann | Login Form</title>
    <link rel="stylesheet" href="../assets/css/login.css" />
    <link rel="icon" type="image/x-icon" href="../assets/images/favicon.ico"><!-- Favicon / Icon -->
    <script src="https://accounts.google.com/gsi/client" async defer></script>
</head>

<body>
    <?php
    require('db.php');
    session_start();

    if (!empty($_SESSION)) {
        $username = $_SESSION["username"];
        $query    = "SELECT username FROM `employees` WHERE username='$username'";
        $result = mysqli_query($con, $query);
        $rows = mysqli_num_rows($result);
        if ($rows == 1) {
            header("Location: Admin.php");
        } else {

            header("Location: index.php");
        }
    }

    if (isset($_POST['email'])) {
        $username = stripslashes($_REQUEST['email']); // removes backslashes
        $username = mysqli_real_escape_string($con, $username);
        $password = stripslashes($_REQUEST['password']);
        $password = mysqli_real_escape_string($con, $password);
        // Check user is exist in the database
        $query    = "SELECT * FROM `Accounts` WHERE username='$username'
                            AND password='" . md5($password) . "'";
        $result = mysqli_query($con, $query);
        $rows = mysqli_num_rows($result);
        if ($rows == 1) {
            $query    = "SELECT status FROM `Accounts` WHERE username='$username'";
            $result = mysqli_query($con, $query);
            $row = mysqli_fetch_assoc($result);
            $status = "active";
            if ($row['status'] == $status) {
                $_SESSION['username'] = $username;
                $_SESSION['password'] = $password;
                $query    = "SELECT username FROM `employees` WHERE username='$username'";
                $result = mysqli_query($con, $query);
                $rows = mysqli_num_rows($result);
                if ($rows == 1) {
                    echo "<script>alert('Login Successful');</script>";
                    $stmt = $con->prepare("SELECT EName FROM employees WHERE username = ?");
                    $stmt->bind_param("s", $username);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if ($result->num_rows === 1) {
                        $row = $result->fetch_assoc();
                        $name = $row['EName'];
                        $_SESSION['name'] = $name;
                    }
                    header("Refresh:0; url=/php/Admin.php");
                } else {
                    echo "<script>alert('Login Successful');</script>";
                    $stmt = $con->prepare("SELECT CName FROM customer WHERE username = ?");
                    $stmt->bind_param("s", $username);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if ($result->num_rows === 1) {
                        $row = $result->fetch_assoc();
                        $name = $row['CName'];
                        $_SESSION['name'] = $name;
                    }
                    header("Refresh:0; url=/php/index.php");
                }
            } else {
                echo "<div class='form'>
                        <h3>Your account have been disable!</h3><br/>
                        <p class='link'><a href='login.php'>Got it</a></p>
                        </div>";
            }
        } else {
            echo "<div class='form'>
                        <h3>Incorrect Username/password.</h3><br/>
                        <p class='link'><a href='login.php'>Gotit</a></p>
                        </div>";
        }
    } else {
    ?>
    <form class="form" method="post" name="login">
        <center>
            <img src="../assets/images/logo.png" alt="" class="img img-fluid">
        </center>
        <hr />
        <h1 class="login-title">Login</h1>
        <input type="text" class="login-input" name="email" placeholder="Email" autofocus="true" />
        <input type="password" class="login-input" name="password" id="showpass" placeholder="Password" />
        <input type="checkbox" onclick="myFunction()" style="margin-bottom: 20px;">Show Password </br>
        <a href="/phpconnect/forgot.php">Forgotten password? </a>
        <input type="submit" value="Login" name="submit" class="login-button" />
        <p class="link">Don't have an account? <a href="/phpconnect/registration.php">Register here!</a></p>
        <hr />

        <div id="g_id_onload" data-client_id="838321752460-6ah497tdpkbekj7lfj5so48suaqhu1e7.apps.googleusercontent.com"
            data-context="signin" data-ux_mode="popup" data-login_uri="https://kapetanncoffeeshop.infinityfreeapp.com"
            data-auto_prompt="false">
        </div>

        <div class="g_id_signin" data-type="standard" data-shape="rectangular" data-theme="outline"
            data-text="signin_with" data-size="large" data-logo_alignment="center" data-callback="onSignIn">
        </div>
    </form>
    <?php
    }
    ?>

    <script src="js/script.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <script>
    function myFunction() {
        var x = document.getElementById("showpass");

        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }
    </script>

</body>

</html>