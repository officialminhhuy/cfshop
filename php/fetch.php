<?php
header("Cache-Control: no-store");
header("Content-Type: text/event-stream");
include("db.php");
$p = '';
while (true) {
    $result = $con->query("SELECT * FROM product");
    $r = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $r[] = $row;
        }
    }
    $n = json_encode($r);
    if (strcmp($p, $n) !== 0) {
        echo "data:" . $n . "\n\n";
        $p = $n;
    }
    ob_end_flush();
    flush();
    sleep(1);
}
