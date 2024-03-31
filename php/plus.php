<?php
include 'db.php';
include("auth_session.php");
// $data = json_decode(file_get_contents("php://input"), true);
// $currentDate = date('Y-m-d');
if (isset($_POST['productadd'])) {
    $id = $_POST['productadd'];
    $stmt = $con->prepare("SELECT prices FROM product WHERE P_ID = ?");
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $price = $row['prices'];
        $stmt = $con->prepare("SELECT C_ID FROM customer WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            $cid = $row['C_ID'];
            $stmt = $con->prepare("SELECT P_ID,number FROM cart WHERE C_ID = ? AND P_ID = ?");
            $stmt->bind_param("ss", $cid, $id);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows === 0) {
                $number = 1;
                $stmt = $con->prepare("INSERT INTO cart (C_ID, P_ID, number, totalprice) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("ssss", $cid, $id, $number, $price);
                if ($stmt->execute()) {
                    echo "Add drink successfully";
                } else {
                    echo "Add Failed. Please try again!";
                }
            } else {
                $row = $result->fetch_assoc();
                $num = $row['number'] + 1;
                $totalpr = $num * $price;

                $stmt = $con->prepare("UPDATE cart SET  number = ?, totalprice = ? WHERE C_ID = ? AND P_ID = ?");
                $stmt->bind_param("ssss", $num, $totalpr, $cid, $id);
                if ($stmt->execute()) {
                    echo "Updated drink successfully!";
                } else {
                    echo "Please try again!";
                }
            }
        }
    }
}
