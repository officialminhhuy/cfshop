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
        $cfpassword = stripslashes($_REQUEST['cfpassword']);
        $cfpassword = mysqli_real_escape_string($con, $cfpassword);
        $status = "disable";
        // $create_datetime = date("Y-m-d H:i:s");
        if ($password == $cfpassword) {
            $query    = "INSERT into `accounts` (username, password, status)
                            VALUES ('$username', '" . md5($password) . "','$status')";
            $result   = mysqli_query($con, $query);
            if ($result) {
                $Name = $_POST["name"];
                $CDOB = $_POST["DOB"];
                $address = $_POST["address"];
                $password = $_POST["password"];
                $insertAccountStmt = $con->prepare("INSERT INTO customer (CName,CDOB,Address,username) VALUES (?,?,?,?)");
                $insertAccountStmt->bind_param("ssss", $Name, $CDOB, $address, $username);
                if ($insertAccountStmt->execute()) {
                    session_start();
                    $_SESSION["username"] = $username;
                    $_SESSION["password"] = $password;
                    $_SESSION["name"] = $Name;
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
                }
            } else {
                echo "<div class='form'>
                            <h3>Required fields are missing.</h3><br/>
                        <p class='link'>Click here to <a href='registration.php'>registration</a> again.</p>
                        </div>";
            }
        } else {
            echo "<script> alert(Confirm password is not match);</script>";
        }
    } else {
    ?>
        <form class="form" action="" method="post">
            <center>
                <img src="../assets/images/logo.png" alt="" class="img img-fluid">
            </center>
            <hr />
            <h1 class="login-title">Registration</h1>
            <label for="name">Full name:</label>
            <input type="text" class="login-input" name="name" placeholder="Your full name" required />
            <label for="DOB">Date of birth:</label>
            <input type="date" class="login-input" name="DOB" required />
            <label for="address">Address:</label>
            <input type="text" class="login-input" name="address" placeholder="Your full name" required />
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