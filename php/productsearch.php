<link rel="stylesheet" href="/assets/css/style.css">
<div class="Psearch">
    <?php
    // echo "<script> alert('nothings')</script>";
    include("db.php");
    if (isset($_POST['input'])) {
        $searchTerm = $_POST['input'];
        $stmt = $con->prepare("SELECT P_ID, PName,image FROM product WHERE PName LIKE ?");
        $searchTerm = '%' . $searchTerm . '%';
        $stmt->bind_param("s", $searchTerm);
        $stmt->execute();
        $result = $stmt->get_result();
        $count = 0;
        if ($result->num_rows > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                if ($count >= 5) {
                    break;
                }

                echo "<a href='#" . $row["P_ID"] . "' class='Psearch1'>";
                echo "<img src='/assets/images/" . $row["image"] . "' alt='' class='scfimg'>";
                echo "<p1 id='textse' >" . $row['PName'] . "</p1><br>";
                $count++;
                echo "</a>";
    ?>

    <?php
            }
        }
    }
    ?>
</div>