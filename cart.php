<?php
require_once "app/config/config.php";
require_once "app/models/Cart.php";
require_once "app/models/User.php";
$user = new User();
if(!$user->isLoggedIn()){
    header("location: /login.php");
    exit;
}
$cart = new Cart();
$cart_items = $cart->list_cart_items();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Shopping Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="public/css/style.css">
</head>
<body>
<nav>
    <div class="nav-container">
        <a href="index.php" class="logo">E-Shop</a>

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


<h2 class="page-title">Your Cart</h2>

<div class="cart-wrapper">
    <table class="cart-table">
        <thead>
        <tr>
            <th>Name</th>
            <th>Price</th>
            <th>Size</th>
            <th>Quantity</th>
            <th>Image</th>
        </tr>
        </thead>
        <tbody>
        <?php if (!empty($cart_items)) : ?>
            <?php foreach ($cart_items as $item) : ?>
                <tr>
                    <td><?= htmlspecialchars($item['name']) ?></td>
                    <td>$<?= htmlspecialchars($item['price']) ?></td>
                    <td><?= htmlspecialchars($item['size']) ?></td>
                    <td><?= htmlspecialchars($item['quantity']) ?></td>
                    <td>
                        <img src="uploads/<?= htmlspecialchars($item['image']) ?>"
                             alt="<?= htmlspecialchars($item['name']) ?>">
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="5" class="empty-cart">Your cart is empty.</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>

    <a href="buy.php" class="btn-buy">Buy items</a>
</div>
