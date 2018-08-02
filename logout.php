<?php
//logout.php
session_start();
setcookie("type", "", time()-3600);

session_destroy();

unset($_SESSION['user_mobile']);
unset($_SESSION['user_coin']);
unset($_SESSION['user_email']);



header("location:login.php");
?>