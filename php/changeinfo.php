<?php
//include auth_session.php file on all user panel pages
include("db.php");
include("auth_session.php");
$query    = "SELECT username FROM `customer` WHERE username='$username'";
$result = mysqli_query($con, $query);
$rows = mysqli_num_rows($result);
if ($rows == 1) {
    // header("Location: Admin.php");
} else {

    header("Location: index.php");
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

?>


<?php
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
    <link rel="stylesheet" href="/assets/css/changeinfo.css">
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
                    <a href="/php/Admin.php#home" class="text-decoration-none">Home</a>
                </li>
                <li class="nav-item">
                    <a href="/php/Admin.php#about" class="text-decoration-none">About</a>
                </li>
                <li class="nav-item">
                    <a href="/php/Admin.php#menu" class="text-decoration-none">Menu</a>
                </li>
                <li class="nav-item">
                    <a href="/php/Admin.php#gallery" class="text-decoration-none">Gallery</a>
                </li>
                <li class="nav-item">
                    <a href="/php/Admin.php#blogs" class="text-decoration-none">Blogs</a>
                </li>
                <li class="nav-item">
                    <a href="/php/Admin.php#contact" class="text-decoration-none">Contact</a>
                </li>
                <!-- <li class="nav-item 1" onclick="hide()">
                    <a href="/php/login.php" class="text-decoration-none">Login</a>
                </li>
                <li class="nav-item 2" onclick="hide()">
                    <a href="/php/login.php" class="text-decoration-none">Logout</a>
                </li> -->

            </ul>
        </nav>

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
            <h1>Hi user, <?php echo "$name"; ?>!</h1>
            <a href="/php/changeinfo.php  " class="link">
                <button id="optionbtn">Account</button>
            </a>
            <a href="/php/history.php  " class="link">
                <button id="optionbtn">History order</button>
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

    </header>

    <!-- ACCOUNT MANAGEMENT -->
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
            <input type="email" name="email" id="email" class="input" value="<?php echo $username ?>" placeholder=" example@gmail.com" required>
            <label for="name" id="label">Full name:</label>
            <input type="text" name="name" id="name" class="input" value="<?php echo $name ?>" placeholder="Roberto Carlos" required>
            <label for="date" id="label">Day of birth:</label>
            <input type="date" name="date" id="date" class="input" value="<?php echo date('Y-m-d', strtotime($dob)); ?>" required>
            <label for=" addre" id="label">Address:</label>
            <input type="text" name="addre" id="addre" class="input" value="<?php echo $addre ?>" placeholder="Thao Dien, Dist.2" required>


            <div id="btn">
                <button class="btn" type="submit" id="button">Update</button></br>
            </div>
            <div id="btn">
                <a href="/php/changepass.php">
                    <button class="btn" id="button" type="button">Change Password</button>
                </a>
            </div>
        </form>
    </div>

    <!-- JS File Link -->
    <?php
    echo "<script src='/assets/js/script.js'></script>";
    // if (!empty($_SESSION)) {

    // }
    ?>
    <script src="/assets/js/responses.js"></script>
    <script src="/assets/js/convo.js"></script>
    <script src="/assets/js/googleSignIn.js"></script>


    <script>
        // CODE FOR THE REDIRECT CART
        function redirectCart() {
            // Check if the user is logged in
            if (!"<?php echo isset($_SESSION["username"]) ? $_SESSION["username"] : '' ?>") {
                // Redirect the user to the login page
                alert("You are not logged in. Please log into your account and try again.");
                window.location.href = "login.php";
            }
        }
    </script>
</body>


</html>