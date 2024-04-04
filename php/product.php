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
            <div class='box-container'>
                <div class='container'>
                    <div class='row'>";
        foreach ($rows as $row) {
            echo "<div class='col-md-4' id='" . $row["P_ID"] . "'>
                        <div class='box'>";
            echo "<img src='/assets/images/" . $row["image"] . "' alt='' class='product-img'>";
            echo "<h3 class='product-title'>" . $row["PName"] . "</h3>";
            echo "<p>Available: " . $row["validproduct"] . "</p>";
            echo "<button class='btn views' onclick='openPopup()'  data-product-id='" . $row["P_ID"] . "'   >View</button>";
            $pid = $row["P_ID"];
?>

            <div id="detailz"></div>
            <div>
                <?php
                $stmt = $con->prepare("SELECT C_ID FROM customer WHERE username = ?");
                $stmt->bind_param("s", $username);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $cid = $row['C_ID'];
                }
                $num = 0;
                $stmtCart = $con->prepare("SELECT number FROM cart WHERE P_ID =? AND C_ID = ?");
                $stmtCart->bind_param("ss", $pid, $cid);
                $stmtCart->execute();
                $resultCart = $stmtCart->get_result();
                if ($resultCart->num_rows > 0) {
                    $rowCart = $resultCart->fetch_assoc();
                    $num = $rowCart["number"];
                }
                echo "<p class='choosenum'><button class='minus' data-product-add='" . $pid . "'>-</button><input type='text' class='numberss' value='" . $num . "' readonly><button class='plus' data-product-add='" . $pid . "' >+</button></p>";
                ?>
            </div>
<?php
            echo "
                        </div>
                    </div>
                ";
        }
        echo "</div>
            </div>
        </div>
            </section>";
    }
}


?>