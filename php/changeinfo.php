<?php
include("db.php");
include("auth_session.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $dob = $_POST['date'];
    $addre = $_POST['addre'];
    $username = $_SESSION['username'];

    $stmt = $con->prepare("UPDATE customer SET CName=?, CDOB=?, Address=? WHERE username = ?");
    $stmt->bind_param("ssss", $name, $dob, $addre, $username);

    if ($stmt->execute()) {
        echo "<script> alert('Update information successfully!')</script>";
        header("Refresh:0");
    } else {
        echo "<script> alert('Failed to update information!')</script>";
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
    <?php
    $stmt = $con->prepare("SELECT CName,CDOB,Address FROM customer WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $name =  $row['CName'];
        $dob = $row['CDOB'];
        $addre = $row['Address'];
    }
    ?>

    <div class="infoform">
        <form method="post" class="form">
            <label for="email" id="label">Email:</label>
            <input type="email" name="email" id="email" class="input" value="<?php echo $username ?>"
                placeholder=" example@gmail.com" required>
            <label for="name" id="label">Full name:</label>
            <input type="text" name="name" id="name" class="input" value="<?php echo $name ?>"
                placeholder="Roberto Carlos" required>
            <label for="date" id="label">Day of birth:</label>
            <input type="date" name="date" id="date" class="input" value="<?php echo date('Y-m-d', strtotime($dob)); ?>"
                required>
            <label for=" addre" id="label">Address:</label>
            <input type="text" name="addre" id="addre" class="input" value="<?php echo $addre ?>"
                placeholder="Thao Dien, Dist.2" required>


            <div id="btn">
                <button type="submit" id="button">Update</button></br>
            </div>
            <div id="btn">
                <a href="/php/changepass.php">
                    <button id="button" type="button">Change Password</button>
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