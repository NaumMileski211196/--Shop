<?php

require_once "app/config/config.php";
require_once "app/models/User.php";

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $username = $_POST['username'];
    $password = $_POST['password'];

    $user = new User();
    $result = $user->login($username, $password);

    if($user->isLoggedIn()){
        header("Location: index2.php");
        exit();
    }

    if(!$result){
        $_SESSION['message']['type'] = "danger";
        $_SESSION['message']['text'] = "Invalid username or password";
        header("Location: login.php");
        exit();
    }
    header("Location: index2.php");
    exit();
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Page</title>
    <link href="https://cdn.misdeliver.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="public/css/style2.css">
</head>
<body>


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
<div class="login-page">

    <div class="login-container">
        <h1 class="login-title">Login</h1>

        <form method="POST" action="" class="login-form">

            <div class="input-box">
                <label for="username" class="label">Username</label>
                <input type="text" id="username" name="username" class="input" required>
            </div>

            <div class="input-box">
                <label for="password" class="label">Password</label>
                <input type="password" id="password" name="password" class="input" required>
            </div>

            <button type="submit" class="btn">Login</button>

        </form>
        <a href="register.php" class="esh-register-link">Register here</a>
    </div>

</div>
</body>
</html>
