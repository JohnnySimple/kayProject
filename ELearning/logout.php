<?php
session_start();
$_SESSION["loggedin"] = false;
unset($_SESSION["id"]);
unset($_SESSION["username"]);
unset($_SESSION["title"]);
unset($_SESSION["firstname"]);
unset($_SESSION["lastname"]);
header("Location:login.php");
?>