<?php
include 'database.php';

session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
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
                
                    </li>
                </ul>
            </div>
        </nav>
    </header>





<!-- Cart Review Section -->
<section>
    
    <table class="table">
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $total = 0;
        if(isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
            foreach($_SESSION['cart'] as $product_id => $quantity) {
                // Fetch product details from database using $product_id
                $query = "SELECT name, price FROM products WHERE product_id = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param('i', $product_id);
                $stmt->execute();
                $result = $stmt->get_result();
                $product = $result->fetch_assoc();

                $product_name = $product['name'];
                $product_price = $product['price'];
                $subtotal = $product_price * $quantity;
                $total += $subtotal;

                echo "<tr>
                        <td>{$product_name}</td>
                        <td>\${$product_price}</td>
                        <td>{$quantity}</td>
                        <td>\${$subtotal}</td>
                      </tr>";
            }
        }
        ?>
        </tbody>
    </table>
    <p>Total: $<?php echo number_format($total, 2); ?></p>
</section>

<!-- User Information and Payment Section -->
<div class="container mt-5">
    <form action="process_checkout.php" method="post">
        <fieldset class="mb-4">
            <legend>Order Type</legend>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="order_type" id="delivery" value="delivery" checked>
                <label class="form-check-label" for="delivery">Delivery</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="order_type" id="collection" value="collection">
                <label class="form-check-label" for="collection">Collection</label>
            </div>
        </fieldset>
        
        <div id="collectionDetails" class="mb-4" style="display: none;">
            <div class="form-group">
                <label for="pickup_time">Pickup Time:</label>
                <input type="time" class="form-control" id="pickup_time" name="pickup_time">
            </div>
            <div class="form-group">
                <label for="pickup_date">Pickup Date:</label>
                <input type="date" class="form-control" id="pickup_date" name="pickup_date">
            </div>
        </div>
        
        <fieldset class="mb-4">
            <legend>Delivery Details</legend>
            <div class="form-group">
                <label for="full_name">Full Name:</label>
                <input type="text" class="form-control" id="full_name" name="full_name" required>
            </div>
            <div class="form-group">
                <label for="address">Address:</label>
                <input type="text" class="form-control" id="address" name="address" required>
            </div>
            <div class="form-group">
                <label for="city">City:</label>
                <input type="text" class="form-control" id="city" name="city" required>
            </div>
            <div class="form-group">
                <label for="postal_code">Postal Code:</label>
                <input type="text" class="form-control" id="postal_code" name="postal_code" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone:</label>
                <input type="text" class="form-control" id="phone" name="phone" required>
            </div>
        </fieldset>

        <fieldset class="mb-4">
            <legend>Payment Details</legend>
            <div class="form-group">
                <label for="card_number">Credit Card Number:</label>
                <input type="text" class="form-control" id="card_number" name="card_number" required>
            </div>
            <div class="form-group">
                <label for="expiry_date">Expiry Date:</label>
                <input type="month" class="form-control" id="expiry_date" name="expiry_date" required>
            </div>
            <div class="form-group">
                <label for="cvv">CVV:</label>
                <input type="text" class="form-control" id="cvv" name="cvv" required>
            </div>
        </fieldset>
        
        <div class="text-center">
            <input type="submit" value="Complete Purchase" class="btn btn-primary btn-lg">
        </div>
    </form>
    
    <script>
        const collectionRadio = document.getElementById('collection');
        const deliveryRadio = document.getElementById('delivery');
        const collectionDetails = document.getElementById('collectionDetails');

        collectionRadio.addEventListener('change', function() {
            if (this.checked) {
                collectionDetails.style.display = 'block';
            }
        });

        deliveryRadio.addEventListener('change', function() {
            if (this.checked) {
                collectionDetails.style.display = 'none';
            }
        });
    </script>

</div>

<footer>
    <p>@This business is fictitious and part of a university course.</p>
</footer>

</body>
</html>

