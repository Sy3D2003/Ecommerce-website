<?php
session_start();

// Your database connection script
$hostName = "localhost";
$dbUser = "root";
$dbPassword = "Messi@123";
$dbName = "login_register";

$conn = mysqli_connect($hostName, $dbUser, $dbPassword, $dbName);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if cart is set and not empty
if(!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    die("Your cart is empty.");
}

$totalPrice = 0.0;

// Fetch product details for each item in the cart
foreach ($_SESSION['cart'] as $productId => $quantity) {
    $query = "SELECT name, price FROM products WHERE product_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $productId);
    
    if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);
        $product = mysqli_fetch_assoc($result);
        
        $totalPrice += ($product['price'] * $quantity);
    } else {
        die("Error fetching product details.");
    }

    $orderType = $_POST['order_type'];
    if ($orderType == "delivery") {
        // Process as delivery
    } else {
        // Process as collection
    }
}

// Storing order details in an orders table
$orderQuery = "INSERT INTO orders (total_price, order_date) VALUES (?, NOW())";
$stmtOrder = mysqli_prepare($conn, $orderQuery);
mysqli_stmt_bind_param($stmtOrder, 'd', $totalPrice);

if (mysqli_stmt_execute($stmtOrder)) {
    echo "Order placed successfully! Your total is: $" . $totalPrice;
    // Empty the cart after successful checkout
    $_SESSION['cart'] = [];
    echo '<br><a href="index.php"><button>Return to Home</button></a>';  // Added this line
} else {
    die("Error placing the order.");
}

mysqli_close($conn);
?>
