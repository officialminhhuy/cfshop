<link rel="stylesheet" href="/assets/css/style.css">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<div class="popup-screen">
    <div class="popup-box">
        <?php
        include("db.php");
        session_start();
        $username = $_SESSION["username"];
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
                            <img src="/assets/images/<?php echo $row["image"]; ?>" alt="" class="dtimg"><br>
                            <h1 id="dttext"><?php echo $row['PName']; ?></h1><br>
                            <!-- <p>Available:<?php echo $row["validproduct"] ?> </p>; -->
                            <p id="material"><?php echo $row['Material']; ?></p>
                            <p id="price">Price: <?php echo $row['prices']; ?>VND</p>
                            <a1 class="btn add-cart" onclick="addCartClicked()">Edit info</a1>
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
                            <img src="/assets/images/<?php echo $row["image"]; ?>" alt="" class="dtimg"><br>
                            <h1 id="dttext"><?php echo $row['PName']; ?></h1><br>
                            <!-- <p>Available:<?php echo $row["validproduct"] ?> </p>; -->
                            <p id="material"><?php echo $row['Material']; ?></p>
                            <p id="price">Price: <?php echo $row['prices']; ?>VND</p>
                            <a1 class="btn add-cart" onclick="redirectCart()">Add to Cart</a1>
                            <div id="back">
                                <a1 class="btn back" onclick="hidePopup();closePopupHandler();">Back</a1>
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
    // var addCart = document.getElementsByClassName('idpro');
    // for (var i = 0; i < addCart.length; i++) {
    //     var button = addCart[i];
    //     button.addEventListener("click", addCartClicked);
    // }

    // function addCartClicked() {
    //     var productNameElement = document.querySelector('#dttext');
    //     if (productNameElement !== null) {
    //         var productName = productNameElement.innerText;
    //         console.log(productName);
    //     } else {
    //         console.log(productName);
    //     }
    // }
</script>