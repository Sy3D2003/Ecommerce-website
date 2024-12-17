<?php
session_start();
require 'database.php';

if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit;
}

// List of product names to be displayed on the homepage
$display_products = [
    'goldepearlnecklace',
    'leather bracelet',
    'diamond earring',
    'winter hat',
    'sunglasses',
    'comfortable scarf',
    'classic belt',
    'elegant watch'
];

// Get products that match the list above
$query = "SELECT * FROM products WHERE name IN ('" . implode("', '", $display_products) . "')";
$result = mysqli_query($conn, $query);

// Get cart count
$cart_count = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi"
        crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Homepage</title>
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
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="cart.php">View Cart (<?php echo $cart_count; ?>)</a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    <h2>Featured Products</h2>

    <div class="container mt-4">
        <div class="row">
            <?php while ($product = mysqli_fetch_assoc($result)): ?>
            <div class="col-md-4">
                <div class="card mb-4">
                    <img src="images/<?php echo $product['image_url']; ?>" class="card-img-top" alt="<?php echo $product['name']; ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $product['name']; ?></h5>
                        <p class="card-text"><?php echo $product['description']; ?></p>
                        <p class="card-text"><strong>Price: </strong>$<?php echo $product['price']; ?></p>
                        <button onclick="addToCart(<?php echo $product['product_id']; ?>)" class="btn btn-primary">Add to Cart</button>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>

    <script>
        function addToCart(productId) {
    fetch('cart.php', {  
        method: 'POST',
        body: new URLSearchParams(`id=${productId}`),
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        }
    })
    .then(response => {
        // Check if response is successful, otherwise throw an error
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.text();
    })
    .then(data => {
        switch(data.trim()) {
            case 'success':
                alert('Added to cart!');
                location.reload();  // Refresh the page to update the cart count
                break;
            case 'no_product_id':
                alert('No product ID provided.');
                break;
            case 'invalid_product':
                alert('Invalid product.');
                break;
            default:
                alert('Error adding to cart.');
                break;
        }
    })
    .catch(error => {
        console.error('There was a problem with the fetch operation:', error.message);
        alert('There was a problem processing your request. Please try again later.');
    });
}

    </script>

<!-- Place this code at the bottom of your pages -->
<footer>
    <p>@This business is fictitious and part of a university course.</p>
</footer>

</body>
</html>
