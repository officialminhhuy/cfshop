<?php
session_start();
if (!empty($_SESSION)) {
    $username = $_SESSION["username"];
    $password = $_SESSION["password"];
    $name = $_SESSION["name"];
}