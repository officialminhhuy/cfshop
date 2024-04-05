<?php
// Include database connection file
include_once "db.php";
include_once("auth_session.php");
$response = array();
$stmt = $con->prepare("SELECT C_ID FROM customer WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result1 = $stmt->get_result();
if ($result1->num_rows === 1) {
    $row = $result1->fetch_assoc();
    $cid = $row['C_ID'];
}
$stmt = $con->prepare("SELECT product.PName, product.image, cart.totalprice, cart.number FROM cart JOIN product ON cart.P_ID = product.P_ID WHERE cart.number > 0 AND cart.C_ID = ?");
$stmt->bind_param("s", $cid);
$stmt->execute();
$result = $stmt->get_result();
$cartItems = array();
$totalPrice = 0;
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $cartItems[] = array(
            'PName' => $row['PName'],
            'image' => $row['image'],
            'totalprice' => $row['totalprice'],
            'number' => $row['number']
        );
        $totalPrice += $row['totalprice'];
    }
}
$response['cartItems'] = $cartItems;
$response['totalPrice'] = $totalPrice;
header('Content-Type: application/json');
echo json_encode($response);
