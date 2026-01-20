<?php
require_once "app/config/config.php";
require_once "app/models/user.php";

$user = new User();
$user->logout();
header("location: login.php");
exit();


?>
