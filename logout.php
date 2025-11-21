<?php
session_start();
require_once "config.php";

unset($_SESSION['id']);
unset($_SESSION['username']);

$_SESSION['succeseful'] = true;
$_SESSION['msg']        = "You're logged out";

header("Location: index.php");
exit;
