<?php
$servername = "localhost";
$username = "root";
$password = "1234";
$dbname = "store";
$con = new mysqli($servername, $username, $password, $dbname);
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}
