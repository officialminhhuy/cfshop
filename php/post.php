<?php
include("db.php");
include("auth_session.php");
$username = $_SESSION["username"];

$query = "SELECT username FROM `employees` WHERE username='$username'";
$result = mysqli_query($con, $query);
$rows = mysqli_num_rows($result);
if ($rows != 1) {
    header("Location: index.php");
    exit; // Add exit to stop execution after redirection
}

$stmt = $con->prepare("SELECT username FROM accounts WHERE username = ?");
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
        searchForm.classList.remove('active');
        cartItem.classList.remove('active');
    }
    </script>";
} else {
    echo "<script>
    function Menu() {
        var option = document.querySelector('.option');
        option.classList.toggle('visible');
        var button = document.querySelector('.menubtn');
        button.classList.toggle('roll');
        searchForm.classList.remove('active');
        cartItem.classList.remove('active');
    }
    </script>";
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["imgs"])) {
    $targetDir = "C:\\Users\\quili\\OneDrive\\Máy tính\\cfclone\\coffee-shop-website\\assets\\images\\";
    $targetFile = $targetDir . basename($_FILES["imgs"]["name"]);
    $insertimg =  basename($_FILES["imgs"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo '<script>alert("Only image");</script>';
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($_FILES["imgs"]["tmp_name"], $targetFile)) {
            $imagePath = $insertimg;
            $stmt = $con->prepare("SELECT E_ID FROM employees WHERE username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows == 1) {
                $row = $result->fetch_assoc();
                $eid = $row['E_ID'];
                $material = $_POST["material"];
                $name = $_POST["proname"];
                $valid = $_POST["validpro"];
                $price = $_POST["prices"];
                $file = basename($_FILES["imgs"]["name"]);
                $stmt = $con->prepare("INSERT INTO product (PName, prices, Material, image,validproduct, E_ID) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("ssssss", $name, $price, $material, $imagePath, $valid, $eid);
                if ($stmt->execute()) {
                    echo  '<script>alert("Add to menu successful!");</script>';
                    header("Refresh:0");
                } else {
                    echo '<script>alert("Error!");</script>';
                    sleep(2);
                }
                $stmt->close();
            } else {
                echo '<script>alert("You are not admin!");</script>';
            }
        } else {
            echo "<script> alert('Error uploading file.')</script>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title>KapeTann Brewed Coffee Shop</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js" integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js" integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ" crossorigin="anonymous">
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD2Hhh_14Uam62GXGaTMcXWhhVkYg0EbDY&callback=initMap" async defer></script>

    <!-- Custom CSS File Link -->
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/convo.css">
    <link rel="stylesheet" href="/assets/css/homepage.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- font awesome cdn link -->
    <link rel="icon" type="image/x-icon" href="/assets/images/favicon.ico"><!-- Favicon / Icon -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"><!-- Google font cdn link -->
</head>

<body>
    <!-- HEADER SECTION -->
    <header class="header">
        <a href="#" class="logo">
            <img src="/assets/images/logo.png" class="img-logo" alt="KapeTann Logo">
        </a>

        <!-- MAIN MENU FOR SMALLER DEVICES -->
        <nav class="navbar navbar-expand-lg">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a href="#home" class="text-decoration-none">Home</a>
                </li>
                <li class="nav-item">
                    <a href="#about" class="text-decoration-none">About</a>
                </li>
                <li class="nav-item">
                    <a href="#menu" class="text-decoration-none">Menu</a>
                </li>
                <li class="nav-item">
                    <a href="#gallery" class="text-decoration-none">Gallery</a>
                </li>
                <li class="nav-item">
                    <a href="#blogs" class="text-decoration-none">Blogs</a>
                </li>
                <li class="nav-item">
                    <a href="#contact" class="text-decoration-none">Contact</a>
                </li>
            </ul>


        </nav>
        <div class="icons">
            <div class="fas fa-search" id="search-btn"></div>
            <div id="cart-btn" onclick="redirectCart()"></div>
            <div class="fas fa-bars" id="menu-btn"></div>
        </div>
        <div class="menu1">
            <button class="menubtn" onclick="Menu()">|||</button>
        </div>
        <div class="option">
            <a href="/php/Login.php" class="link">
                <button id="optionbtn">Sign in</button>
            </a>
            <a href="/phpconnect/registration.php" class="link">
                <button id="optionbtn">Sign up</button>
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
            <a href="/php/logout.php" class="link">
                <button id="optionbtn">Log out</button>
            </a>
        </div>

        <!-- SEARCH TEXT BOX -->
        <div class="search-form">
            <input type="search" id="search-box" class="form-control" placeholder="search here..." autocomplete="off">
            <label for="search-box" class="fas fa-search"></label>
        </div>
        <div id="found"></div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

        <div class="popup-screen">
            <div class="popup-box">
                <div class="detailsz">
                    <a1 id="produz">
                        <a href="/php/Admin.php" id="back" class="btn back">back</a>
                        <form method="post" enctype="multipart/form-data">
                            <h1 id="h1tt">
                                Post product</h1>
                            <label for="proname">Product name:</label>
                            <input type="text" name="proname" id="postfield" placeholder="Name of product" required>
                            <label for="material">Material:</label>
                            <input type="text" name="material" id="postfield" placeholder="Detail of product" required>
                            <label for="validpro">Numbers get:</label>
                            <input type="text" name="validpro" id="postfield" placeholder="Number get for sale" required>
                            <label for="prices">Price:</label>
                            <input type="text" name="prices" id="postfield" placeholder="Sale price" required>
                            <label for="imgs">Image:</label>
                            <div id="file">
                                <input type="file" id="imgfile" name="imgs" accept="image/*" required>
                            </div>
                            <button class="btn" id="sumbit">Upload</button>


                        </form>

                    </a1>
                </div>

            </div>
        </div>

</body>

</html>