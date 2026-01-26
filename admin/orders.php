<?php
require_once "../app/config/config.php";
require_once "../app/models/User.php";
require_once "../app/models/Order.php";

$user = new User();
//admin proverka
if(!$user->isLoggedIn() || !$user->isAdmin()){
    header("Location: ../login.php");
    exit;
}
$order = new Order();
$orders = $order->get_admin_orders();


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Orders</title>
    <link rel="stylesheet" href="../public/css/style2.css">
</head>
<body>

<div class="orders-wrapper">
    <h1 class="h1-admin-orders">All orders</h1>
    <table class="orders-table">
        <thead>
        <tr>
            <th>Order ID</th>
            <th>User</th>
            <th>Email</th>
            <th>Delivery Address</th>
            <th>Quantity</th>
            <th>Image</th>
            <th>Total Price</th>
            <th>Date</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($orders as $order) : ?>
            <tr>
                <td>#<?php echo $order['order_id']; ?></td>
                <td><?php echo htmlspecialchars($order['user_name']); ?></td>
                <td><?php echo htmlspecialchars($order['email']); ?></td>
                <td><?php echo htmlspecialchars($order['deliveryAddress']); ?></td>
                <td><?php echo htmlspecialchars($order['quantity']); ?></td>
                <td>
                    <img src="../uploads/<?php echo htmlspecialchars($order['image']); ?> "

                </td>
                <td><?= number_format($order['total_price'], 2) ?> ден.</td>
                <td><?php echo date("d M Y", strtotime($order['created_at'])); ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
