<?php

session_start();
require_once "config.php";

if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];

    $stmt = mysqli_prepare($conn, "SELECT permission FROM users WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $row              = mysqli_fetch_assoc($result);
    $_SESSION['perm'] = (int) $row['permission'];
    mysqli_stmt_close($stmt);

    $stmt2 = mysqli_prepare($conn, "SELECT path FROM user_imgs WHERE user_id = ?");
    mysqli_stmt_bind_param($stmt2, "i", $id);
    mysqli_stmt_execute($stmt2);
    $result2 = mysqli_stmt_get_result($stmt2);

    if (mysqli_num_rows($result2) > 0) {
        $img             = mysqli_fetch_assoc($result2);
        $_SESSION['img'] = "{$img['path']}";
    } else {
        $_SESSION['img'] = "imgs/icons/user.svg";
    }
}
