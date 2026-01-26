<?php
require_once "app/config/config.php";
require_once "app/models/Order.php";
require_once "app/models/User.php";
require_once "app/models/Cart.php";
$user = new User();

if(!$user->isLoggedIn()){
    header("Location: login.php");
    exit;
}
$order = new Order();
$orders = $order->get_orders();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Orders</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="public/css/style2.css">
</head>
<body>

<h2 class="page-title">Your Orders</h2>

<div class="orders-wrapper">
    <div class="table-responsive">
        <table class="orders-table">
            <thead>
            <tr>
                <th>Order ID</th>
                <th>Product</th>
                <th>Qty</th>
                <th>Size</th>
                <th>Price</th>
                <th>Image</th>
                <th>Delivery Address</th>
                <th>Date</th>
            </tr>
            </thead>
            <tbody>
            <?php if(!empty($orders)) : ?>
                <?php foreach ($orders as $order) : ?>
                    <tr>
                        <td>#<?= $order['order_id']; ?></td>
                        <td><?= htmlspecialchars($order['name']); ?></td>
                        <td><?= htmlspecialchars($order['quantity']); ?></td>
                        <td><?= htmlspecialchars($order['size']); ?></td>
                        <td>$<?= htmlspecialchars($order['price']); ?></td>
                        <td>
                            <img src="uploads/<?= htmlspecialchars($order['image']); ?>" alt="<?= htmlspecialchars($order['name']); ?>">
                        </td>
                        <td><?= htmlspecialchars($order['deliveryAddress']); ?></td>
                        <td><?= date("d M Y", strtotime($order['created_at'])); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8" class="text-center text-muted">You have no orders yet.</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="text-center">
        <a href="index2.php#products" class="back-btn">← Back to Menu</a>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
