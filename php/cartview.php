<?php
include("db.php");
include("auth_session.php");

$stmt = $con->prepare("SELECT C_ID FROM customer WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result1 = $stmt->get_result();

if ($result1->num_rows === 1) {
    $row = $result1->fetch_assoc();
    $cid = $row['C_ID'];
    $total = 0;

    $stmt = $con->prepare("SELECT P_ID, totalprice,number FROM cart WHERE number > 0 AND C_ID = ?");
    $stmt->bind_param("s", $cid);
    $stmt->execute();
    $result2 = $stmt->get_result();

    if ($result2->num_rows > 0) {
?>
<div class="cartc">
    <h2 class="cart-title">Your Cart:</h2>
    <div class="cart-content">
        <?php
                while ($row = $result2->fetch_assoc()) {
                    $pid = $row['P_ID'];
                    $price = $row['totalprice'];
                    $num = $row['number'];
                    $total = $total + $row['totalprice'];

                    $stmt = $con->prepare("SELECT PName,image FROM product WHERE P_ID = ?");
                    $stmt->bind_param("s", $pid);
                    $stmt->execute();
                    $result3 = $stmt->get_result();

                    if ($result3->num_rows > 0) {
                        $row = $result3->fetch_assoc();
                        $image = $row['image'];
                        $pname = $row['PName'];
                    }
                ?>
        <div class="cart-item">
            <div class="item-id"><?php echo $pname; ?></div>
            <img src="/assets/images/<?php echo $image; ?>" style="width: 50px; height: 50px;">
            <div class="item-id">Quantity: <?php echo $num; ?></div>
            <div class="item-price">Price: <?php echo $price; ?>VND</div>
            </br>
        </div>
        <?php
                }
                ?>
    </div>
    <div class="total">

        <div class="total-price">Total: <?php echo $total; ?>VND</div>
    </div>
</div>
<?php
    } else {
        echo "Empty cart!";
    }
} else {
    echo "null user";
}
?>