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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Shopping Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="public/css/style2.css">
</head>
<body>

<div class="container py-5">
    <h2 class="mb-4 text-center">🛒 Your Cart</h2>

    <?php
    if (isset($_SESSION['message'])) {
        echo '<div class="alert alert-success text-center">'.$_SESSION['message'].'</div>';
        unset($_SESSION['message']);
    }
    ?>

    <div class="cart-wrapper p-4 rounded-4 shadow-sm bg-glass">
        <div class="table-responsive">
            <table class="table table-hover align-middle cart-table text-center">
                <thead class="table-warning text-dark rounded-3">
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
                                     alt="<?= htmlspecialchars($item['name']) ?>"
                                     class="cart-img">
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center text-muted">Your cart is empty.</td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if (!empty($cart_items)) : ?>
            <div class="text-center mt-4">
                <a href="buy.php" class="btn btn-warning btn-lg text-dark fw-bold">✅ Buy Items</a>
                <a href="index2.php#products" class="btn btn-outline-warning btn-lg ms-2">← Back to Menu</a>
            </div>
        <?php endif; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>