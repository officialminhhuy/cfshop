<?php
$servername = "localhost";
$username = "root";
$password = "1234";
$dbname = "store";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
session_start();
if (!empty($_SESSION)) {
    $username = $_SESSION["username"];
}
$stmt = $conn->prepare("SELECT username FROM employees WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows == 1) {
    echo "<script>
    function Menu() {
        var option = document.querySelector('.optionlogged');
        option.classList.toggle('visible');
        var button = document.querySelector('.menubtn');
        button.classList.toggle('roll');
    }
    </script>";
} else {
    header("Location: /asset/css/homepage.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/css/homepage.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home page</title>
</head>

<body>
    <!-- header -->
    <div class="header">
        <!-- <img class="cover" alt="" src="/images/group-1@2x.png" /> -->
        <img class="logo" alt="" src="/images/rectangle-17@2x.png" />
        <!-- <img class="shopicon" alt="" src="/images/vector.svg"> -->
        <div class="menu">
            <button class="menubtn" onclick="Menu()">|||</button>
        </div>
    </div>
    <div class="product">
        <a href="/php/Admin.php" id="link">
            <button id="optionbar">Home</button>
        </a>
        <a href="#" id="link">
            <button id="optionbar">Branch</button>
        </a>
        <a href="#" id="link">
            <button id="optionbar">Contact</button>
        </a>
        <a href="#" id="link">
            <button id="optionbar">About us</button>
        </a>
        <a id="searchbox" class="searchbox">
            <input type="text" class="font" id="optionbar" class="search" placeholder="Find something here...">
        </a>
        <a href="#" class="searchicon">
            <img src="/images/search.png" id="searchicon" style="color: blue;">
        </a>
    </div>
    <div class="optionlogged">
        <h1>Hi admin, <?php echo "$username"; ?>!</h1>
        <a href="#" class="link">
            <button id="optionbtn">Manage Account</button>
        </a>
        <a href="/php/post.php" class="link">
            <button id="optionbtn">Post</button>
        </a>
        <a href="/php/destroyss.php" class="link">
            <button id="optionbtn">Log out</button>
        </a>
    </div>
</body>

</html>