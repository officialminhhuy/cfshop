<?php
include 'db.php';
include("auth_session.php");

if (isset($_POST['productadd'])) {
    $id = $_POST['productadd'];

    // Lấy giá của sản phẩm
    $stmt = $con->prepare("SELECT prices FROM product WHERE P_ID = ?");
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $price = $row['prices'];

        // Lấy C_ID của người dùng
        $stmt = $con->prepare("SELECT C_ID FROM customer WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            $cid = $row['C_ID'];

            // Kiểm tra xem sản phẩm đã tồn tại trong giỏ hàng chưa
            $stmt = $con->prepare("SELECT number FROM cart WHERE C_ID = ? AND P_ID = ?");
            $stmt->bind_param("ss", $cid, $id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows === 0) {
                // Nếu sản phẩm chưa có trong giỏ hàng, thêm mới vào giỏ hàng với số lượng là 1
                $number = 1;
                $stmt = $con->prepare("INSERT INTO cart (C_ID, P_ID, number, totalprice) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("ssss", $cid, $id, $number, $price);
                if ($stmt->execute()) {
                    echo "Add drink successfully";
                } else {
                    echo "Add Failed. Please try again!";
                }
            } else {
                // Nếu sản phẩm đã có trong giỏ hàng, cập nhật số lượng và tổng giá
                $row = $result->fetch_assoc();
                $num = $row['number'] - 1;
                $num = max(0, $num); // Đảm bảo số lượng không nhỏ hơn 0

                if ($num === 0) {
                    // Nếu số lượng giảm xuống 0, xóa sản phẩm khỏi giỏ hàng
                    $stmt = $con->prepare("DELETE FROM cart WHERE C_ID = ? AND P_ID = ?");
                    $stmt->bind_param("ss", $cid, $id);
                    if ($stmt->execute()) {
                        echo "Deleted drink successfully from cart";
                    } else {
                        echo "Failed to delete drink from cart";
                    }
                } else {
                    // Nếu số lượng lớn hơn 0, cập nhật thông tin sản phẩm trong giỏ hàng
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
}
