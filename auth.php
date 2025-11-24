<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once "config.php";

if (isset($_SESSION['id'])) {

    $now = time();
    $cache_valid = (isset($_SESSION['last-checked']) && $now -  $_SESSION['last-checked'] < 360);

    if(!$cache_valid || !isset($_SESSION['perm']) || !isset($_SESSION['img'])){

        $id = $_SESSION['id'];

        $stmt = mysqli_prepare($conn, "SELECT users.permission,
                                              users.id, 
                                              user_imgs.path FROM users LEFT JOIN user_imgs ON users.id = user_imgs.user_id WHERE users.id = ?");
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        mysqli_stmt_close($stmt);

        $row              = mysqli_fetch_assoc($result);

        if(!$row){
            session_unset();
            session_destroy();
            header("Location: login.php");
            exit;
        }else{
            $_SESSION['perm'] = (int) $row['permission'];

            if (!empty($row['path'])) {
                $_SESSION['img'] = "{$row['path']}";
            } else {
                $_SESSION['img'] = "imgs/icons/user.svg";
            }
            $_SESSION['last-checked'] = $now;
        }
    }
}
