<?php

require_once "app/config/config.php";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once "app/models/user.php";
require_once "app/models/product.php";
$user = new User();

$products = new Product();
$products = $products->listAllProducts();

global $conn;
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

if ($search !== '') {
    $stmt = $conn->prepare("SELECT * FROM product WHERE name LIKE ?");
    $likeSearch = "%$search%";
    $stmt->bind_param("s", $likeSearch);
    $stmt->execute();
    $result = $stmt->get_result();
    $products = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
} else {
    $result = $conn->query("SELECT * FROM product");
    $products = $result->fetch_all(MYSQLI_ASSOC);
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>E-Shop</title>
    <link rel="stylesheet" href="public/css/style2.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav>
    <div class="nav-container">
        <a href="index2.php" class="logo">
            <img src="public/images/logo.png" alt="FoodOrder Logo">
        </a>
        <ul class="nav-menu">
            <?php if(!$user->isLoggedIn()): ?>
                <li>
                    <a href="index2.php">Home</a>
                </li>
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
<div class="welcome-section">
    <h2>Welcome to FoodOrder – Your Online Food Ordering System</h2>
    <p>
        FoodOrder is a fast and easy online food ordering system that allows customers to  explore menus, and order their favorite meals with just a few clicks.
    </p>
    <div class="order-btn-container">
        <a href="#products" class="order-btn">Click Here to Order</a>
    </div>
</div>
<section class="product-section">
    <div class="text-center mb-4">
        <h2>Food Menu</h2>
        <p>Check out our delicious products below!</p>
        <form method="GET" action="" class="d-flex justify-content-center mb-3">
            <input type="text" name="search" class="form-control w-25" placeholder="Search products by name..." value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
            <button type="submit" class="btn btn-primary btn-sm ms-2">Search</button>
        </form>

    </div>
    <div class="container product-list" id="products">
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
                            <div class="product-actions mt-3">
                                <a href="product.php?product_id=<?= $product['product_id'] ?>"
                                   class="btn btn-outline-secondary btn-sm view-btn">
                                    Order here
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<footer class="footer">
    <div class="footer-container">
        <div class="footer-brand">
            <h3>FoodOrder</h3>
            <p>Fast & easy online food ordering.</p>
        </div>

        <div class="footer-links">
            <h4>Quick Links</h4>
            <a href="index2.php">Home</a>
            <a href="#products">Menu</a>
            <a href="orders.php">Orders</a>
            <a href="#">Contact</a>
        </div>

        <div class="footer-social">
            <h4>Follow Us</h4>
            <a href="#">Facebook</a>
            <a href="#">Instagram</a>
            <a href="#">Twitter</a>
        </div>
    </div>

    <div class="footer-bottom">
        © 2026 FoodOrder. All rights reserved.
    </div>
</footer>







<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
