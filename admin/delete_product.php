<?php
require_once "../app/config/config.php";
require_once "../app/models/User.php";
require_once "../app/models/Product.php";

$user = new User();

if (!$user->isLoggedIn() || !$user->isAdmin()) {
    header("Location: ../index.php");
    exit;
}

if (!isset($_GET['product_id'])) {
    header("Location: index.php");
    exit;
}

$product_id = (int)$_GET['product_id'];

$product = new Product();
$product->delete($product_id);

header("Location: index.php");
exit;
