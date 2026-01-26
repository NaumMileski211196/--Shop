<?php
require_once "app/config/config.php";
require_once "app/models/Cart.php";
require_once "app/models/User.php";
require_once "app/models/Order.php";

$user = new User();
if(!$user->isLoggedIn()){
    header("location: login.php");
    exit;
}
if($_SERVER["REQUEST_METHOD"] == "POST"){

    $deliveryAddress = $_POST["fullName"] . ", " . $_POST["address"] . " ," . $_POST["phone"];


    $orderObj = new Order();
    $result = $orderObj->createOrder($deliveryAddress);

    if(!$result){
        $_SESSION['message']['type'] = "danger";
        $_SESSION['message']['text'] = "Нарачката беше неуспешна. Обиди се повторно.";
        header("Location: buy.php");
        exit;
    }
    $_SESSION['message']['type'] = "success";
    $_SESSION['message']['text'] = "Нарачката е успешно направена!";
    header("Location: orders.php");
    exit;
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Buy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="public/css/style2.css">
</head>
<body>
<div class="buy-page">
    <form method="post" action="" class="order-container order-form">
        <h2 class="order-title">Order Details</h2>

        <?php if(isset($_SESSION['message'])) : ?>
            <div class="alert alert-<?php echo $_SESSION['message']['type']; ?> alert-dismissible fade show">
                <?php
                echo $_SESSION['message']['text'];
                unset($_SESSION['message']);
                ?>
            </div>
        <?php endif; ?>

        <div class="input-box">
            <label class="label">Име и Презиме</label>
            <input type="text" name="fullName" class="input" required>
        </div>

        <div class="input-box">
            <label class="label">Адреса</label>
            <input type="text" name="address" class="input" required>
        </div>

        <div class="input-box">
            <label class="label">Телефонски Број</label>
            <input type="text" name="phone" class="input" required>
        </div>

        <button type="submit" class="btn">Order</button>
    </form>
</div>


</body>
</html>
