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


<div class="product-section">
    <div class="product-image">
        <img src="uploads/<?= htmlspecialchars($product['image']) ?>" class="card-img-top"
             alt="<?= htmlspecialchars($product['name']) ?>">
    </div>
    <div class="product-info">
        <h2><?php echo $product['name']; ?></h2>
        <p><strong>Size:</strong> <?php echo $product['size']; ?></p>
        <p><strong>Price:</strong> $<?php echo $product['price']; ?></p>
        <form action="" method="post" class="product-form">
            <label for="quantity">Quantity:</label>
            <input type="number" name="quantity" value="1" min="1">
            <button type="submit">Add to Cart</button>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

</body>
</html>
