<?php
//include auth_session.php file on all user panel pages
include("db.php");
include("auth_session.php");
if (!empty($_SESSION)) {
    $username = $_SESSION["username"];
    $query    = "SELECT username FROM `employees` WHERE username='$username'";
    $result = mysqli_query($con, $query);
    $rows = mysqli_num_rows($result);
    if ($rows == 1) {
        // header("Location: Admin.php");
    } else {

        header("Location: index.php");
    }
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
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title>KapeTann Brewed Coffee Shop</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"
        integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js"
        integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ" crossorigin="anonymous">
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD2Hhh_14Uam62GXGaTMcXWhhVkYg0EbDY&callback=initMap"
        async defer></script>

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
                <!-- <li class="nav-item 1" onclick="hide()">
                    <a href="/php/login.php" class="text-decoration-none">Login</a>
                </li>
                <li class="nav-item 2" onclick="hide()">
                    <a href="/php/login.php" class="text-decoration-none">Logout</a>
                </li> -->

            </ul>

            </div>
        </nav>
        <div class="icons">
            <div class="fas fa-search" id="search-btn"></div>
            <div id="cart-btn" onclick="redirectCart()"></div>
            <div id="menu-btn"></div>
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
            <h1>Hi admin, <?php echo "$name"; ?>!</h1>
            <a href="/php/accmanage.php" class="link">
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

        <script type="text/javascript">
        $(document).ready(function() {
            $("#search-box").keyup(function() {
                var input = $(this).val();
                if (input != "") {
                    $.ajax({
                        url: "/php/productsearch.php",
                        method: "POST",
                        data: {
                            input: input
                        },
                        success: function(data) {
                            $("#found").html(data).css("display", "block");
                        }
                    })
                } else {
                    $("#found").css("display", "none")
                }
            });
        });
        </script>

        <!-- CART SECTION -->
        <div class="cart">
            <h2 class="cart-title">Your Cart:</h2>
            <div class="cart-content">

            </div>
            <div class="total">
                <div class="total-title">Total: </div>
                <div class="total-price">0VND</div>
            </div>
            <!-- BUY BUTTON -->
            <button type="button" class="btn-buy">Checkout Now</button>
        </div>
    </header>

    <!-- HERO SECTION -->
    <section class="home" id="home">
        <div class="content">
            <h3>Welcome my admin
                <?php if (!empty($_SESSION)) {
                    echo ", ";
                    $name = $_SESSION["name"];
                    echo $name;
                } ?>!</h3>
            <p>
                <strong>We are open 8:00 AM to 8:00 PM.</strong>
            </p>
            <a href="#menu" class="btn btn-dark text-decoration-none">Order Now!</a>
        </div>
    </section>

    <!-- ABOUT US SECTION -->
    <section class="about" id="about">
        <h1 class="heading"> <span>About</span> Us</h1>
        <div class="row g-0">
            <div class="image">
                <img src="/assets/images/about-img.png" alt="" class="img-fluid">
            </div>
            <div class="content">
                <h3>Welcome to KapeTann!</h3>
                <p>
                    At KapeTann Coffee Shop, we are passionate about coffee and believe
                    that every cup tells a story. We are a cozy coffee shop located
                    in the heart of the city, dedicated to providing an exceptional
                    coffee experience to our customers. Our love for coffee has led
                    us on a voyage of exploration and discovery, as we travel the
                    world in search of the finest coffee beans, carefully roasted
                    and brewed to perfection.
                </p>
                <p>
                    But coffee is not just a drink, it's an experience. Our warm and
                    inviting atmosphere at KapeTann is designed to be a haven
                    for coffee lovers, where they can relax, connect, and embark
                    on their own coffee voyages.
                </p>
                <a href="#" class="btn btn-dark text-decoration-none">Learn More</a>
            </div>
        </div>
    </section>
    <h1 class="heading">Our <span>Menu</span>
        <div class="bordersort">
            <span class="glyphicon glyphicon-sort"></span> Sort
            <select id="sort" class="sort btn-default btn-sm">
                <option value="1">Newest</option>
                <option value="2">Price: High to Low</option>
                <option value="3">Price: Low to High</option>
                <option value="4">Name: A to Z</option>
                <option value="5">Name: Z to A</option>
            </select>
        </div>
    </h1>
    <!-- MENU -->
    <?php
    $vd = 0;
    $stmt = $con->prepare("SELECT P_ID,PName,prices,image,validproduct FROM product WHERE validproduct > ?");
    $stmt->bind_param("s", $vd);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        if ($result->num_rows > 0) {
            $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
            $rows = array_reverse($rows);
            echo "<section class='menu' id='menu'>
        <h1 class='heading'>Our <span>Menu</span></h1>
        <div class='box-container'>
            <div class='container'>
                <div class='row'>";
            foreach ($rows as $row) {
                echo "<div class='col-md-4'id= '" . $row["P_ID"] . "'>
                        <div class='box'>";
                echo "<img src='/assets/images/" . $row["image"] . "' alt='' class='product-img'>";
                echo "<h3 class='product-title'>" . $row["PName"] . "</h3>";
                // echo "<div class='price'>" . $row["prices"] . "VND</div>";
                echo "<button class='btn views' onclick='openPopup()'  data-product-id='" . $row["P_ID"] . "'   >Edit</button>";

    ?>
    <!-- product details -->
    <div id="detailz"></div>
    <div>

        <?php
                    echo "<p>Available: " . $row["validproduct"] . "</p>";
                    ?>
    </div>
    <?php
                echo "
                        </div>
                    </div><br />
                ";
            }
            echo "</div><br />
            </div>
        </div>
            </section>";
        }
    }


    ?>
    <center>
        <button id="showHideBtn" class="btn btn-dark">SHOW MORE</button>
    </center>
    </div>
    </div>
    </section>

    <!-- GALLERY SECTION -->
    <section class="gallery" id="gallery">
        <h1 class="heading">The <span>Gallery</span></h1>
        <div class="box-container">
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <div class="box">
                            <div class="image">
                                <img src="/assets/images/gallery1.jpg" alt="">
                            </div>
                            <div class="content">
                                <div class="stars">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                </div>
                                <h3 class="gallery-title">Picture 1</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="box">
                            <div class="image">
                                <img src="/assets/images/gallery2.jpg" alt="">
                            </div>
                            <div class="content">
                                <div class="stars">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                </div>
                                <h3 class="gallery-title">Picture 2</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="box">
                            <div class="image">
                                <img src="/assets/images/gallery3.jpg" alt="">
                            </div>
                            <div class="content">
                                <div class="stars">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                </div>
                                <h3 class="gallery-title">Picture 3</h3>
                            </div>
                        </div>
                    </div>
                </div><br />
                <div class="row pic-to-hide">
                    <div class="col-md-4">
                        <div class="box">
                            <div class="image">
                                <img src="/assets/images/gallery4.jpg" alt="">
                            </div>
                            <div class="content">
                                <div class="stars">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                </div>
                                <h3 class="gallery-title">Picture 4</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="box">
                            <div class="image">
                                <img src="/assets/images/gallery4.jpg" alt="">
                            </div>
                            <div class="content">
                                <div class="stars">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                </div>
                                <h3 class="gallery-title">Picture 4</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="box">
                            <div class="image">
                                <img src="/assets/images/gallery5.jpg" alt="">
                            </div>
                            <div class="content">
                                <div class="stars">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                </div>
                                <h3 class="gallery-title">Picture 5</h3>
                            </div>
                        </div>
                    </div>
                </div><br />
                <center>
                    <button id="showBtn" class="btn btn-dark">SHOW MORE</button>
                </center>
            </div>
        </div>
    </section>

    <!-- BLOGS SECTION -->
    <section class="blogs" id="blogs">
        <h1 class="heading">Our <span>Blogs</span></h1>
        <div class="box-container">
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <div class="box">
                            <div class="image">
                                <img src="/assets/images/pour.jpg" alt="">
                            </div>
                            <div class="content">
                                <a href="https://www.thewaytocoffee.com/batch-brew-vs-pour-over/" target="_blank"
                                    class="title text-decoration-none">Batch Brew vs. Pour Over | The Pros and Cons
                                    Experienced by Coffee Professionals</a>
                                <span>by The Way to Coffee</span>
                                <p>Thinking back 15-20 years, I remember my parents going about their morning ritual of
                                    brewing coffee on weekends before burying...</p>
                                <center>
                                    <a href="https://www.thewaytocoffee.com/batch-brew-vs-pour-over/" target="_blank"
                                        class="btn">Read More</a>
                                </center>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="box">
                            <div class="image">
                                <img src="/assets/images/carbon.webp" alt="">
                            </div>
                            <div class="content">
                                <a href="https://www.taylorsofharrogate.co.uk/news/carbon-neutral-tea-and-coffee"
                                    target="_blank" class="title text-decoration-none">Carbon Neutral Tea and Coffee</a>
                                <span>by Taylors editorial team</span>
                                <p>All our tea and coffee is carbon neutral – but what does that actually mean? Here’s
                                    an explanation of how we’ve lowered our carbon footprint, and the three projects in
                                    Kenya, Malawi and Uganda which have reduced the emissions of our products to...</p>
                                <center>
                                    <a href="https://www.taylorsofharrogate.co.uk/news/carbon-neutral-tea-and-coffee"
                                        target="_blank" class="btn">Read More</a>
                                </center>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="box">
                            <div class="image">
                                <img src="/assets/images/coffeemaker.jpg" alt="">
                            </div>
                            <div class="content">
                                <a href="https://coffeestylish.com/best-drip-coffee-makers/" target="_blank"
                                    class="title text-decoration-none">BEST DRIP COFFEE MAKERS 2020</a>
                                <span>by CoffeeStylish.com</span>
                                <p>What is a good coffee maker? A good home coffee maker should have removable parts so
                                    it can be cleaned completely because you don’t want mold or buildups in your
                                    machine. It should be fast. It...</p>
                                <center>
                                    <a href="https://coffeestylish.com/best-drip-coffee-makers/" target="_blank"
                                        class="btn">Read More</a>
                                </center>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- TESTIMONIALS SECTION -->
    <section class="review" id="review">
        <h1 class="heading"><span>Testimo</span>nials</h1>
        <div class="box-container">
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <div class="box">
                            <img src="/assets/images/quote-img.png" alt="" class="quote">
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit,
                                sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                            </p>
                            <img src="/assets/images/pic-1.png" alt="" class="user">
                            <h3>Jane Doe</h3>
                            <div class="stars">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="box">
                            <img src="/assets/images/quote-img.png" alt="" class="quote">
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit,
                                sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                            </p>
                            <img src="/assets/images/pic-2.png" alt="" class="user">
                            <h3>John Doe</h3>
                            <div class="stars">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="box">
                            <img src="/assets/images/quote-img.png" alt="" class="quote">
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit,
                                sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                            </p>
                            <img src="/assets/images/pic-3.png" alt="" class="user">
                            <h3>Jane Doe</h3>
                            <div class="stars">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CONTACT US SECTION -->
    <section class="contact" id="contact">
        <h1 class="heading"><span>Contact</span> Us</h1>
        <div class="row">
            <div id="map" class="map pull-left"></div>
            <form name="contact" method="POST" action="https://formspree.io/f/xayzavgb">
                <h3> Get in touch with us!</h3>
                <div class="inputBox">
                    <span class="fas fa-envelope"></span>
                    <input type="email" name="email" placeholder="Email Address">
                </div>
                <div class="inputBox">
                    <textarea name="message" placeholder="Enter your message..."></textarea>
                </div>
                <button type="submit" class="btn">Contact Now</button>
            </form>
        </div>
    </section>

    <!-- FOOTER SECTION -->
    <section class="footer">
        <div class="footer-container">
            <div class="logo">
                <img src="/assets/images/logo.png" class="img"><br />
                <i class="fas fa-envelope"></i>
                <p>abfiguerrez18@gmail.com</p><br />
                <i class="fas fa-phone"></i>
                <p>+63 917-134-1422</p><br />
                <i class="fab fa-facebook-messenger"></i>
                <p>@kapetanncoffee</p><br />
            </div>
            <div class="support">
                <h2>Support</h2>
                <br />
                <a href="#">Contact Us</a>
                <a href="#">Customer Service</a>
                <a href="#">Chatbot Inquiry</a>
                <a href="#">Submit a Ticket</a>
            </div>
            <div class="company">
                <h2>Company</h2>
                <br />
                <a href="#">About Us</a>
                <a href="#">Affiliates</a>
                <a href="#">Resources</a>
                <a href="#">Partnership</a>
                <a href="#">Suppliers</a>
            </div>
            <div class="newsletters">
                <h2>Newsletters</h2>
                <br />
                <p>Subscribe to our newsletter for news and updates!</p>
                <div class="input-wrapper">
                    <input type="email" class="newsletter" placeholder="Your email address">
                    <i id="paper-plane-icon" class="fas fa-paper-plane"></i>
                </div>
            </div>
            <div class="credit">
                <hr /><br />
                <h2>KapeTann Brewed Coffee © 2023 | All Rights Reserved.</h2>
                <h2>Designed by <span>Algo Filipino</span> | Teravision</h2>
            </div>
        </div>
    </section>


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
    // CODE FOR THE FORMSPREE
    window.onbeforeunload = () => {
        for (const form of document.getElementsByTagName('form')) {
            form.reset();
        }
    }

    // CODE FOR THE GOOGLE MAPS API
    function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
            center: {
                lat: 14.99367271992383,
                lng: 120.17629231186626
            },
            zoom: 9
        });

        var marker = new google.maps.Marker({
            position: {
                lat: 14.99367271992383,
                lng: 120.17629231186626
            },
            map: map,
            title: 'Your Location'
        });
    }

    // CODE FOR THE SHOW MORE & SHOW LESS BUTTON IN MENU
    // $(document).ready(function() {
    //     $(".row-to-hide").hide();
    //     $("#showHideBtn").text("SHOW MORE");
    //     $("#showHideBtn").click(function() {
    //         $(".row-to-hide").toggle();
    //         if ($(".row-to-hide").is(":visible")) {
    //             $(this).text("SHOW LESS");
    //         } else {
    //             $(this).text("SHOW MORE");
    //         }
    //     });
    // });

    // CODE FOR THE SHOW MORE & SHOW LESS BUTTON IN GALLERY
    $(document).ready(function() {
        $(".pic-to-hide").hide();
        $("#showBtn").text("SHOW MORE");
        $("#showBtn").click(function() {
            $(".pic-to-hide").toggle();
            if ($(".pic-to-hide").is(":visible")) {
                $(this).text("SHOW LESS");
            } else {
                $(this).text("SHOW MORE");
            }
        });
    });

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