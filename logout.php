<?php
session_start();

if(isset($_SESSION['id'])){
    require_once "config.php";

    unset($_SESSION['perm']);
    unset($_SESSION['id']);
    unset($_SESSION['username']);

    $_SESSION['succeseful'] = true;
    $_SESSION['msg']        = "You're logged out";

    header("Location: index.php");

    exit;
}
