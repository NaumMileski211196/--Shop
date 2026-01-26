<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once "../app/config/config.php";
require_once "../app/models/User.php";
require_once "../app/models/Product.php";



$user = new User();

if (!$user->isLoggedIn() || !$user->isAdmin()) {
    header("Location: ../index2.php");
    exit;
}

if (!isset($_GET['product_id'])) {
    header("Location: products.php");
    exit;
}

$product_id = (int)$_GET['product_id'];

$productObj = new Product();
$product = $productObj->read($product_id);

if (!$product) {
    die("Product not found.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!isset($_POST['product_id'])) {
        die("Invalid request.");
    }

    $product_id = (int)$_POST['product_id'];
    $name  = trim($_POST['name']);
    $price = trim($_POST['price']);
    $size  = trim($_POST['size']);

    if (!empty($_FILES['image']['name'])) {
        $filename = time() . "_" . basename($_FILES['image']['name']);
        $targetPath = "../uploads/" . $filename;
        move_uploaded_file($_FILES['image']['tmp_name'], $targetPath);
    } else {
        $filename = $product['image'];
    }

    $productObj->edit($product_id, $name, $price, $size, $filename);

    header("Location: index-admin.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Product</title>
    <link rel="stylesheet" href="../public/css/style2.css">
</head>
<body>

<div class="admin-wrapper">
    <div class="product-form-wrapper">
        <h2 class="form-title">Edit Product</h2>

        <form method="POST" enctype="multipart/form-data" class="admin-product-form">

            <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">

            <div class="form-group">
                <label for="name">Product Name</label>
                <input type="text" name="name" id="name" value="<?= htmlspecialchars($product['name']) ?>" required>
            </div>

            <div class="form-group">
                <label for="price">Price ($)</label>
                <input type="number" name="price" id="price" value="<?= htmlspecialchars($product['price']) ?>" required>
            </div>

            <div class="form-group">
                <label for="size">Size</label>
                <input type="text" name="size" id="size" value="<?= htmlspecialchars($product['size']) ?>" required>
            </div>

            <div class="form-group">
                <label for="image">Change Image</label>
                <input type="file" name="image" id="image">
            </div>

            <?php if (!empty($product['image'])): ?>
                <div class="current-image">
                    <p>Current Image:</p>
                    <img src="../uploads/<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
                </div>
            <?php endif; ?>

            <button type="submit" class="btn-primary">Update Product</button>
        </form>
    </div>
</div>

</body>
</html>
