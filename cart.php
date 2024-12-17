<?php
session_start();

file_put_contents('debug.txt', print_r($_POST, true));

require 'database.php';

if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit;
}

// Initialize cart if not set or empty
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Logic to add or increment the item in the cart
// Logic to add or increment the item in the cart
if (isset($_POST['id']) && is_array($_SESSION['cart'])) {
    $product_id = $_POST['id'];
    $_SESSION['cart'][$product_id] = (isset($_SESSION['cart'][$product_id]) && is_numeric($_SESSION['cart'][$product_id])) ? $_SESSION['cart'][$product_id] + 1 : 1;
    echo 'success';  // Provide feedback that the item was added successfully
    exit;
}

$cart_items = [];
$total = 0;

foreach ($_SESSION['cart'] as $productId => $quantity) {
    $stmt = $conn->prepare("SELECT * FROM products WHERE product_id = ?");
    $stmt->bind_param("i", $productId);
    $stmt->execute();

    $result = $stmt->get_result();
    $product = $result->fetch_assoc();

    if ($product && is_array($product)) {
        $product['quantity'] = $quantity;
        $cart_items[] = $product;
        $total += floatval($product['price']) * $quantity;  // Ensure the price is treated as a float.
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi"
        crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body>
<header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="index.php">Home</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="product_list.php">Product Categories</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="cart.php">Cart</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="checkout.php">Checkout</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="order_history.php">Order History</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
                
                </ul>
            </div>
        </nav>
    </header>

    <div class="container mt-4">
        <h3>Your Cart</h3>

        <?php if (empty($cart_items)): ?>
            <p>Your cart is empty. <a href="index.php">Shop now</a>!</p>
        <?php else: ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cart_items as $item): ?>
                        <tr>
                            <td><?= htmlspecialchars($item['name']) ?></td> <!-- Updated this line -->
                            <td>$<?= number_format($item['price'], 2) ?></td>
                            <td><?= $item['quantity'] ?></td>
                            <td>$<?= number_format($item['price'] * $item['quantity'], 2) ?></td>
                            <td><button onclick="removeFromCart(<?= $item['product_id'] ?>)">Remove</button></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="text-right">
                <a href="checkout.php" class="btn btn-primary">Proceed to Checkout</a>
            </div>
        <?php endif; ?>
    </div>

    <script>
        function removeFromCart(productId) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "remove_from_cart.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            
            xhr.onreadystatechange = function() {
                if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
                    if (this.responseText.trim() === "success") {
                        location.reload();
                    } else {
                        alert("Error removing product from cart.");
                    }
                }
            }

            xhr.send("id=" + productId);

        }
    </script>
    <footer>
    <p>@This business is fictitious and part of a university course.</p>
</footer>
</body>
</html>

