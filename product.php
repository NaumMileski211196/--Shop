<?php
require_once "app/config/config.php";
require_once "app/models/Product.php";
require_once "app/models/Cart.php";
require_once "app/models/User.php";
$user = new User();
$product = new Product();
$product = $product->read($_GET['product_id']);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = $product['product_id'];

    $user_id = $_SESSION['user_id'];
    $quantity = isset($_POST['quantity']) && $_POST['quantity'] !== '' ? $_POST['quantity'] : '1';
    $cart = new Cart();
    $cart->add_to_cart($product_id, $user_id,$quantity);


    $_SESSION['message'] = 'Product added to cart ✔';
    header('Location: cart.php');
    exit();
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="public/css/style2.css">
</head>
<body>
<div class="container py-5">
    <div class="row align-items-center product-card">
        <div class="col-md-6 text-center">
            <img src="uploads/<?= htmlspecialchars($product['image']) ?>"
                 class="product-image"
                 alt="<?= htmlspecialchars($product['name']) ?>">
        </div>

        <div class="col-md-6">
            <h2 class="product-title"><?= htmlspecialchars($product['name']) ?></h2>

            <p class="product-meta">
                <strong>Size:</strong> <?= htmlspecialchars($product['size']) ?>
            </p>

            <p class="product-price">
                $<?= htmlspecialchars($product['price']) ?>
            </p>

            <form method="post" class="product-form">
                <label class="form-label">Quantity</label>

                <input type="number"
                       name="quantity"
                       value="1"
                       min="1"
                       autofocus
                       class="form-control quantity-field mb-3">

                <div class="d-flex gap-3">
                    <button type="submit" class="btn btn-success btn-lg flex-fill">
                        🛒 Add to Cart
                    </button>

                    <a href="index2.php#products"
                       class="btn btn-outline-secondary btn-lg flex-fill">
                        ← Back to Menu
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

</body>
</html>
