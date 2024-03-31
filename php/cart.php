    <?php
    // Establish connection to the database
    include 'db.php';
    include("auth_session.php");
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
                // $id = $_POST["id"];
                $number = "1";
                $stmt = $con->prepare("SELECT C_ID,totalprice FROM cart WHERE C_ID = ?");
                $stmt->bind_param("s", $cid);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result->num_rows === 0) {

                    $stmt = $con->prepare("INSERT INTO cart (C_ID, P_ID, number, totalprice) VALUES (?, ?, ?, ?)");
                    $stmt->bind_param("ssss", $cid, $id, $number, $price);
                    if ($stmt->execute()) {
                        echo "Add drink successfully";
                    } else {
                        echo "Add Failed. Please try again!";
                    }
                } else {
                    $row = $result->fetch_assoc();
                    $totalpr = $row['totalprice'];
                    $totalpr = $totalpr + $price;
                    $stmt = $con->prepare("SELECT P_ID FROM cart WHERE C_ID = ?");
                    $stmt->bind_param("s", $cid);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if ($result->num_rows === 1) {
                        $row = $result->fetch_assoc();
                        $P_ID = explode(',', $row['P_ID']);
                        if (!in_array($id, $P_ID)) {
                            $P_ID[] = $id;
                            $p_ID = implode(',', $P_ID);
                            $stmt = $con->prepare("UPDATE cart SET P_ID = ?, number = ?, totalprice = ? WHERE C_ID = ?");
                            $stmt->bind_param("ssss", $p_ID, $number, $totalpr, $cid);
                            if ($stmt->execute()) {
                                echo "Updated drink successfully!";
                            } else {
                                echo "Please try again!";
                            }
                        } else {
                            $stmt = $con->prepare("UPDATE cart SET  number = ?, totalprice = ? WHERE C_ID = ?");
                            $stmt->bind_param("sss", $number, $totalpr, $cid);
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
    }
