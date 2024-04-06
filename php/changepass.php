<?php
include("db.php");
include("auth_session.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $oldp = $_POST['oldp'];
    $newp = $_POST['newp'];
    $comp = $_POST['comp'];
    $stmt = $con->prepare("SELECT password FROM accounts WHERE username = ? AND password = '" . md5($oldp) . "'");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 1) {
        if ($newp === $comp) {
            $stmt = $con->prepare("UPDATE accounts SET password = '" . md5($newp) . "' WHERE username = ?");
            $stmt->bind_param("s", $username);
            if ($stmt->execute()) {
                echo "<script> alert('Update information successfully!')</script>";
                header("Refresh:0");
            } else {
                echo "<script> alert('Failed to update information!')</script>";
                header("Refresh:0");
            }
        } else {
            echo "<script> alert('Comfirm password is not match')</script>";
            header("Refresh:0");
        }
    } else {
        echo "<script> alert('Old password is not true!')</script>";
        header("Refresh:0");
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="/assets/css/changeinfo.css">
</head>

<body>
    <div class="infoform">
        <form method="post" class="form">
            <label for="oldp" id="label">Old password:</label>
            <input type="password" name="oldp" id="oldp" class="input" placeholder="Your old password" required>
            <label for="newp" id="label">New password:</label>
            <input type="password" name="newp" id="newp" class="input" placeholder="required !@#$%^&*." required>
            <label for="comp" id="label">Confirm password:</label>
            <input type="password" name="comp" id="comp" class="input" placeholder="required !@#$%^&*." required>
            <div id="btn">
                <button type="submit" id="button">Change Password</button></br>
            </div>
            <div id="btn">
                <a href="/php/changeinfo.php">
                    <button id="button" type="button">Edit profile</button>
                </a>
            </div>
            <div id="btn">
                <a href="/php/index.php">
                    <button id="button" type="button">Back</button>
                </a>
            </div>
        </form>
    </div>
</body>

</html>