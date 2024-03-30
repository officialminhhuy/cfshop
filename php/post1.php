<?php
include("db.php");
include("auth_session.php");
$stmt = $con->prepare("SELECT password FROM accounts WHERE username = ?");
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

    sleep(1);
    header("Location: /php/homepage.php");
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_FILES["file"]["name"]) && is_array($_FILES["file"]["name"])) {
        $targetDir = "C:\\Users\\quili\\OneDrive\\Máy tính\\furniture\\images\\";
        foreach ($_FILES['file']['name'] as $key => $value) {
            $targetFile = $targetDir . basename($_FILES["file"]["name"][$key]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
            $files = basename($_FILES["file"]["name"][$key]);
            $uploaded_files[] = $files;
            $file = implode(",", $uploaded_files);
        }
        if (
            $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif"
        ) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        } else {
            if (move_uploaded_file($_FILES["file"]["tmp_name"][$key], $targetFile)) {
                $stmt = $con->prepare("SELECT E_ID FROM employees WHERE username = ?");
                $stmt->bind_param("s", $username);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result->num_rows == 1) {
                    $row = $result->fetch_assoc();
                    $eid = $row['E_ID'];
                    $material = $_POST["material"];
                    $name = $_POST["name"];
                    $price = $_POST["price"];
                    $stmt = $con->prepare("INSERT INTO product (PName, prices, Material, image, E_ID) VALUES (?, ?, ?, ?, ?)");
                    $stmt->bind_param("sssss", $name, $price, $material, $file, $eid);
                    if ($stmt->execute()) {
                        echo '<script>alert("Successful");</script>';
                    } else {
                        echo '<script>alert("Error!");</script>';
                    }
                    $stmt->close();
                } else {
                    echo '<script>alert("You are not admin!");</script>';
                }
            } else {
                echo "Please choose another pic!";
            }
        }
    } else {
        echo "No files uploaded.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/css/homepage.css">
    <link rel="stylesheet" href="/css/post.css">
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
            <input type="search" class="font" id="optionbar" class="search" placeholder="Find something here...">
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
        <a href="#" class="link">
            <button id="optionbtn">Post</button>
        </a>
        <a href="/php/destroyss.php" class="link">
            <button id="optionbtn">Log out</button>
        </a>
    </div>
    <div class="layout">
        <form class="flayout" method="post" enctype="multipart/form-data">
            <div class="postlist">
                <label for="combobox">Product Catalog</label>
                <select class="combobox" name="material">
                    <option>Accessory</option>
                    <option>Taiwan Scroll Door</option>
                    <option>Aluminum Door</option>
                    <option>Star Door</option>
                    <option>AU Door</option>
                    <option>Tech Door</option>
                </select>
                <div class="postlist">
                    <div class="postlist">
                        <label for="name">Product Name</label>
                        <input type="text" name="name" required>
                    </div>
                    <div class="postlist">
                        <label for="price">Price</label>
                        <input type="text" name="price" required>
                    </div>
                    <div class="imglist" id="imglist">
                        <input id="file" type="file" name="file[]" multiple required>
                        <label for="file">Upload </label>
                        <span id="upstt" style="margin-left: 20px;">None</span>
                        <input id="postbtn" type="submit" value="Post">
                    </div>
                </div>
        </form>
    </div>
    <script>
        let upload = document.getElementById('file');
        let upstt = document.getElementById('upstt')
        upload.addEventListener('change', function(event) {
            let uploadedfile = event.target.files.length;
            upstt.textContent = uploadedfile + ' image uploaded';
        })
    </script>
</body>

</html>