<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link rel="stylesheet" href="/assets/css/style.css">
<script src="/assets/js/addcart.js"></script>
<div class="popup-screen">
    <div class="popup-box">
        <?php
        include("db.php");
        include("auth_session.php");
        if (isset($_POST['productId'])) {
            $productId = $_POST['productId']; // Lấy giá trị productId từ $_POST
            $stmt = $con->prepare("SELECT PName, Material, image, prices,validproduct FROM product WHERE P_ID = ?");
            $stmt->bind_param("s", $productId);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows === 1) {
                $row = $result->fetch_assoc();
                $stmt = $con->prepare("SELECT username FROM employees WHERE username = ?");
                $stmt->bind_param("s", $username);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result->num_rows === 1) {


        ?>
                    <div class="detailsz">
                        <a id="detailsz">

                            <form method="post" action="update.php" enctype="multipart/form-data">
                                <img src="/assets/images/<?php echo $row["image"]; ?>" alt="" class="edimg"><br>
                                <p id="fontedit" style="display: none;">
                                    ID
                                    <input class="sizeedit" name="id" type="text" value="<?php echo $productId ?>">
                                </p>
                                <p id="fontedit">
                                    Name:
                                    <input class="sizeedit" name="proname" type="text" value="<?php echo $row['PName']; ?>"><br>
                                </p>

                                <p id="fontedit">
                                    Material:
                                    <input class="sizeedit" name="material" type="text" value="<?php echo $row['Material']; ?>">
                                </p>
                                <p id="fontedit">
                                    Price:
                                    <input class="sizeedit" name="prices" value="<?php echo $row['prices']; ?>">
                                </p>
                                <p id="fontedit">
                                    Available:
                                    <input class="sizeedit" name="validpro" type="text" value="<?php echo $row["validproduct"] ?>">
                                </p>
                                <p id="fontedit" style="text-transform: none;">
                                    New Image:
                                    <input type="file" name="imgs" accept="image/*">
                                    (Skip if not update)
                                </p>
                                <button class="btn updateproduct" onclick="addCartClicked()" type="submit">Update</button>
                            </form>
                            <div id="back">
                                <a1 class="btn back" onclick="hidePopup();closePopupHandler();">Back</a1>
                            </div>

                            <a3 class="idpro" style="display: none;"> <?php echo $productId; ?></a3>
                        </a>
                    </div>
                <?php

                } else {

                ?>
                    <div class="detailsz">
                        <a id="detailsz">

                            <p id="fontedit" style="display: none;">
                                ID
                                <input class="sizeedit" name="id" type="text" value="<?php echo $productId ?>">
                            </p>
                            <img src="/assets/images/<?php echo $row["image"]; ?>" alt="" class="dtimg"><br>
                            <h1 id="dttext"><?php echo $row['PName']; ?></h1><br>
                            <!-- <p>Available:<?php echo $row["validproduct"] ?> </p>; -->
                            <p id="material"><?php echo $row['Material']; ?></p>
                            <p id="price">Price: <?php echo $row['prices']; ?>VND</p>
                            <p id="fontedit" style="display: none;">
                                Price:
                                <input class="sizeedit" name="price" type="text" value="<?php echo $row['prices']; ?>">
                            </p>

                            <form>
                                <button class="btn add-cart" data-product-add=" <?php echo $productId ?> " onclick="hidePopup();closePopupHandler();redirectCart();">Add
                                    to Cart</button>
                            </form>
                            <div id="back">
                                <button class="btn back" onclick="hidePopup();closePopupHandler();">Back</button>

                            </div>
                            <a3 class="idpro" style="display: none;"> <?php echo $productId; ?></a3>

                        </a>
                    </div>
        <?php
                }
            } else {
                echo "<script> alert('Not found');</script>";
            }
        } else {
            echo "<script> alert('Error!');</script>";
        }
        ?>
    </div>
</div>
<script>
    function redirectCart() {
        if (!"<?php echo isset($_SESSION["username"]) ? $_SESSION["username"] : '' ?>") {
            alert("You are not logged in. Please log into your account and try again.");
            window.location.href = "login.php";
        }
    }
</script>