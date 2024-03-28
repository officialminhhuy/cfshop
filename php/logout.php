<?php
session_start();
// Destroy session
if (session_destroy()) {
    echo "<script>alert('Log out Successful');</script>";
    header("Location: /php/index.php");
}
