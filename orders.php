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
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Orders</title>
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

</body>

<div class="orders-wrapper">
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
        <?php foreach ($orders as $order) : ?>
            <tr>
                <td>#<?php echo $order['order_id']; ?></td>
                <td><?php echo $order['name']; ?></td>
                <td><?php echo $order['quantity']; ?></td>
                <td><?php echo $order['size']; ?></td>
                <td><?php echo $order['price']; ?></td>
                <td>
                    <img src="uploads/<?php echo htmlspecialchars($order['image']); ?>"
                         alt="<?php echo htmlspecialchars($order['name']); ?>">
                </td>
                <td><?php echo $order['deliveryAddress']; ?></td>
                <td><?php echo date("d M Y", strtotime($order['created_at'])); ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
</html>
