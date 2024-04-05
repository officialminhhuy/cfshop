<?php
include "db.php";
include "auth_session.php";

$stmt = $con->prepare("SELECT C_ID FROM customer WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result1 = $stmt->get_result();

if ($result1->num_rows === 1) {
    $row = $result1->fetch_assoc();
    $cid = $row['C_ID'];
    $total = 0;

    $stmt = $con->prepare("SELECT P_ID, totalprice, number FROM cart WHERE number > 0 AND C_ID = ?");
    $stmt->bind_param("s", $cid);
    $stmt->execute();
    $result2 = $stmt->get_result();

    if ($result2->num_rows > 0) {
        $history_data = array();
        while ($row = $result2->fetch_assoc()) {
            $pid = $row['P_ID'];
            $quantity = $row['number'];
            $total += $row['totalprice'];
            $history_data[] = array(
                'pid' => $pid,
                'quantity' => $quantity
            );
        }

        $stmt = $con->prepare("INSERT INTO orders (totalprice, paymentmethod, C_ID) VALUES (?, ?, ?)");
        $paymentmethod = "cash";
        $stmt->bind_param("sss", $total, $paymentmethod, $cid);

        if ($stmt->execute()) {
            $order_id = $stmt->insert_id;

            foreach ($history_data as $data) {
                date_default_timezone_set('Asia/Ho_Chi_Minh');
                $idate = date("Y-m-d H:i:s");
                $edate = date("Y-m-d H:i:s");

                $stmt = $con->prepare("INSERT INTO history (ImportDate, ExportDate, P_ID, ProNumber, O_ID) VALUES (?, ?, ?, ?, ?)");
                $stmt->bind_param("sssss", $idate, $edate, $data['pid'], $data['quantity'], $order_id);

                if (!$stmt->execute()) {
                    die("Error occurred while inserting data into history table");
                }
            }

            $stmt = $con->prepare("DELETE FROM cart WHERE C_ID = ?");
            $stmt->bind_param("s", $cid);
            if ($stmt->execute()) {
                echo "success";
            } else {
                die("Error occurred while deleting cart items");
            }
        } else {
            die("Error occurred while inserting data into orders table");
        }
    } else {
        echo "Empty cart!";
    }
} else {
    die("User not found");
}
