<?php
include("db.php");
include("auth_session.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $targetDir = "C:\\Users\\quili\\OneDrive\\Máy tính\\cfclone\\coffee-shop-website\\assets\\images\\";
    $targetFile = $targetDir . basename($_FILES["imgs"]["name"]);
    $insertimg =  basename($_FILES["imgs"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($_FILES["imgs"]["tmp_name"], $targetFile)) {
            $imagePath = $insertimg;
            $stmt = $con->prepare("SELECT E_ID FROM employees WHERE username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows == 1) {
                $row = $result->fetch_assoc();
                $eid = $row['E_ID'];
                $id = $_POST["id"];
                $material = $_POST["material"];
                $name = $_POST["proname"];
                $valid = $_POST["validpro"];
                $price = $_POST["prices"];
                $file = basename($_FILES["imgs"]["name"]);
                $stmt = $con->prepare("UPDATE product SET PName=?, prices=?, Material=?, image=?, validproduct=?, E_ID=? WHERE P_ID=?");
                $stmt->bind_param("sssssss", $name, $price, $material, $imagePath, $valid, $eid, $id);
                $successMessage = "Updated Successfully!";
                if ($stmt->execute()) {
                    echo  '<script>alert("Updated Successfully!");</script>';
                    header("Refresh:0; url=/php/Admin.php#menu");
                } else {
                    echo '<script>alert("Error!");</script>';
                    sleep(2);
                }
                $stmt->close();
            } else {
                echo '<script>alert("You are not admin!");</script>';
            }
        } else {
            $imagePath = $insertimg;
            $stmt = $con->prepare("SELECT E_ID FROM employees WHERE username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows == 1) {
                $row = $result->fetch_assoc();
                $eid = $row['E_ID'];
                $id = $_POST["id"];
                $material = $_POST["material"];
                $name = $_POST["proname"];
                $valid = $_POST["validpro"];
                $price = $_POST["prices"];
                $file = basename($_FILES["imgs"]["name"]);
                $stmt = $con->prepare("UPDATE product SET PName=?, prices=?, Material=?, validproduct=?, E_ID=? WHERE P_ID=?");
                $stmt->bind_param("ssssss", $name, $price, $material, $valid, $eid, $id);
                if ($stmt->execute()) {
                    echo  '<script>alert("Updated Successfully!");</script>';

                    header("Refresh:0; url=/php/Admin.php#menu");
                } else {
                    echo '<script>alert("Error!");</script>';
                    sleep(2);
                }
                $stmt->close();
            } else {
                echo '<script>alert("You are not admin!");</script>';
            }
        }
    }
}
