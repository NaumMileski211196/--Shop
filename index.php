<?php

require_once "app/config/config.php";
require_once "app/models/user.php";
require_once "app/models/product.php";
$user = new User();

$products = new Product();
$products = $products->listAllProducts();

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="public/css/style.css">
</head>
<body>
<nav>
    <div class="nav-container">
        <a href="#" class="logo">E-Shop</a>
        <ul class="nav-menu">
            <?php if(!$user->isLoggedIn()): ?>
                <li>
                    <a href="login.php">Login</a>
                </li>
                <li>
                    <a href="register.php">Register</a>
                </li>
            <?php else: ?>
                <li>
                    <a href="cart.php">Cart</a>
                </li>
                <li>
                    <a href="orders.php">Orders</a>
                </li>
                <li>
                    <a href="logout.php">Logout</a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>
<div class="container">
    <?php if(isset($_SESSION['message'])) : ?>
        <div class="alert alert-<?php echo $_SESSION['message']['type']; ?> alert-dismissible fade show">
            <?php
            echo $_SESSION['message']['text'];
            unset($_SESSION['message']);
            ?>
        </div>
    <?php endif; ?>
</div>
<div class="container product-list">
    <div class="row">
        <?php foreach ($products as $product) : ?>
            <div class="col-md-3">
                <div class="card h-100">
                    <img src="uploads/<?= htmlspecialchars($product['image']) ?>" class="card-img-top"
                         alt="<?= htmlspecialchars($product['name']) ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($product['name']) ?></h5>
                        <p class="card-text">Size: <?= htmlspecialchars($product['size']) ?></p>
                        <p class="card-text">Price: $<?= htmlspecialchars($product['price']) ?></p>
                        <a href="product.php?product_id=<?= $product['product_id'] ?>" class="btn btn-primary">View Product</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>




