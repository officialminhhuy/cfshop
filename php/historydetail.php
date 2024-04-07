        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        <link rel="stylesheet" href="/assets/css/style.css">
        <script src="/assets/js/addcart.js"></script>
        <div class="popup-screen">
            <div class="popup-box">
                <?php
                include("db.php");
                include("auth_session.php");
                if (isset($_POST['hisId'])) {
                    $oid = $_POST['hisId'];
                    $stmt = $con->prepare("SELECT ImportDate, P_ID, ProNumber FROM history WHERE O_ID = ?");
                    $stmt->bind_param("s", $oid);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $ImportDate = $row["ImportDate"];
                        $stmt = $con->prepare("SELECT totalprice FROM orders WHERE O_ID = ?");
                        $stmt->bind_param("s", $oid);
                        $stmt->execute();
                        $result_order = $stmt->get_result();
                        if ($result_order->num_rows == 1) {
                            $order_row = $result_order->fetch_assoc();
                            $total = $order_row["totalprice"];
                        }
                        mysqli_data_seek($result, 0);

                        $products = array();
                        while ($row = $result->fetch_assoc()) {
                            $pid = $row["P_ID"];
                            $pronum = $row["ProNumber"];
                            $stmt_product = $con->prepare("SELECT PName, prices, image FROM product WHERE P_ID = ?");
                            $stmt_product->bind_param("s", $pid);
                            $stmt_product->execute();
                            $result_product = $stmt_product->get_result();
                            if ($result_product->num_rows === 1) {
                                $product_row = $result_product->fetch_assoc();
                                $products[] = array(
                                    'PName' => $product_row['PName'],
                                    'prices' => $product_row['prices'],
                                    'image' => $product_row['image'],
                                    'ProNumber' => $pronum
                                );
                            }
                        }
                ?>
                        <div class="hisz">
                            <a id="hisz">
                                <h1>Order Code: <?php echo $oid ?></h1>
                                <h2>Time order: <?php echo $ImportDate; ?> </h2>
                                <?php foreach ($products as $product) : ?>
                                    <img src="/assets/images/<?php echo $product['image']; ?>" class="hisimg">
                                    <p id="hname"><?php echo $product['PName']; ?> x <?php echo $product['ProNumber']; ?> </p>
                                    <p id="hnum">Price: <?php echo $product['prices'] * $product['ProNumber']; ?>VND</p>
                                <?php endforeach; ?>
                                <p id="htotal">Total: <?php echo $total; ?></p>
                                <button class="btn back" onclick="hidePopup();closePopupHandler();">OK</button>
                                <div id="back">
                                    <button class="btn back" onclick="hidePopup();closePopupHandler();">Back</button>
                                </div>
                            </a>
                        </div>
                <?php
                    } else {
                        echo "<script> alert('Not found');</script>";
                    }
                } else {
                    echo "<script> alert('Error!');</script>";
                }
                ?>
            </div>
        </div>