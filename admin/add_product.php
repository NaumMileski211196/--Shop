<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once "../app/config/config.php";
require_once "../app/models/User.php";
require_once "../app/models/Product.php";

$user = new User();

if($user->isLoggedIn() && $user->isAdmin()):

    $productObj = new Product();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = $_POST['name'];
        $price = $_POST['price'];
        $size = $_POST['size'];

        if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
            $image = $_FILES['image']['name'];
            $target = '../uploads/' . basename($image);
            move_uploaded_file($_FILES['image']['tmp_name'], $target);
        } else {
            $image = '';
        }

        $productObj->create($name, $price, $size, $image);

        header('Location: index.php');
        exit();
    }
endif;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Product</title>
    <link rel="stylesheet" href="../public/css/style.css">


</head>
<body>
<div class="product-form-wrapper">
    <h2 class="form-title">Add Product</h2>

    <form method="POST" enctype="multipart/form-data" class="admin-product-form">

        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" required>
        </div>

        <div class="form-group">
            <label for="price">Price</label>
            <input type="text" name="price" id="price" required>
        </div>

        <div class="form-group">
            <label for="size">Size</label>
            <input type="text" name="size" id="size" required>
        </div>

        <div class="form-group">
            <label for="image">Image</label>
            <input type="file" name="image" id="image" required>
        </div>

        <button type="submit" class="btn-primary">Add Product</button>
    </form>
</div>

</body>
</html>
