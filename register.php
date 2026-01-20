<?php
require_once "app/config/config.php";
require_once "app/models/User.php";


if($_SERVER["REQUEST_METHOD"] == "POST"){
    $name = $_POST["name"];
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];


    $user = new User();
    $created = $user->create($name, $username, $email, $password);

    if($user->isLoggedIn()){
        header("Location: index.php");
        exit();
    }
    if($created){
        $_SESSION['message']['type'] = "success";
        $_SESSION['message']['text'] = "Register successful";
        header("Location: index.php");
        exit();
    }
    $_SESSION['message']['type'] = "danger";
    $_SESSION['message']['text'] = "Cant register";
    header("Location: register.php");
    exit();
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="public/css/style.css">
</head>
<body>
<nav>
    <div class="nav-container">
    <a href="#" class="logo">E-Shop</a>

    <ul class="nav-menu">
        <li><a href="index.php">Home</a></li>
        <li><a href="login.php">Login</a></li>
        <li><a href="register.php">Register</a></li>
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
<section class="register-section">
    <div class="register-container">

        <h1 class="register-title">Register</h1>

        <form method="POST" action="" class="register-form">

            <div class="input-box">
                <label for="name" class="label">Full Name</label>
                <input type="text" id="name" name="name" class="input" required>
            </div>

            <div class="input-box">
                <label for="username" class="label">Username</label>
                <input type="text" id="username" name="username" class="input" required>
            </div>

            <div class="input-box">
                <label for="email" class="label">Email</label>
                <input type="email" id="email" name="email" class="input" required>
            </div>
            <div class="input-box">
                <label for="password" class="label">Password</label>
                <input type="password" id="password" name="password" class="input" required>
            </div>
            <button type="submit" class="btn">Register</button>
        </form>

    </div>
</section>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>