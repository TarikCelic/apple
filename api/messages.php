<?php
header('Content-Type: application/json');
require_once "../config.php";

$stmt = mysqli_prepare($conn, "SELECT * FROM contact_messages WHERE answered IS NULL");
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$res = [];

while ($row = mysqli_fetch_assoc($result)) {
    $res[] = $row;
}

echo json_encode($res);
