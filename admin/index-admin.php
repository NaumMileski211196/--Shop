<?php
require_once "../app/config/config.php";
require_once "../app/models/User.php";
require_once "../app/models/Product.php";

$user = new User();

if($user->isLoggedIn() && $user->isAdmin()) :
    $products = new Product();
    $products = $products->listAllProducts();
    ?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin</title>
    <link rel="stylesheet" href="../public/css/style2.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

</head>
<body>

<div class="admin-container mt-5">

    <div class="header mb-4 d-flex justify-content-between align-items-center">
        <a href="add_product.php" class="btn btn-primary px-4">+ Add Product</a>
    </div>

    <div class="table-responsive">
        <table class="table custom-table table-hover align-middle">
            <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Price ($)</th>
                <th>Size</th>
                <th>Image</th>
                <th>Created</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($products as $product): ?>
                <tr>
                    <td><?= $product['product_id']; ?></td>
                    <td class="fw-semibold"><?= htmlspecialchars($product['name']); ?></td>
                    <td><?= htmlspecialchars($product['price']); ?></td>
                    <td><?= htmlspecialchars($product['size']); ?></td>
                    <td>
                        <img src="../uploads/<?= htmlspecialchars($product['image']); ?>"
                             alt="<?= htmlspecialchars($product['name']); ?>"
                             class="product-thumb">
                    </td>
                    <td><?= $product['created_at']; ?></td>
                    <td>
                        <div class="d-flex gap-2 justify-content-center">
                            <a href="edit_product.php?product_id=<?= $product['product_id'] ?>"
                               class="btn btn-sm btn-warning">Edit</a>
                            <a href="delete_product.php?product_id=<?= $product['product_id']; ?>"
                               class="btn btn-sm btn-danger"
                               >Delete</a>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php endif; ?>








