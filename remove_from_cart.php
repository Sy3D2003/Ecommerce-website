<?php
session_start();

if (!isset($_POST['id'])) {
    echo 'no_product_id';
    exit;
}

$product_id = $_POST['id'];

// If the product exists in the cart, remove it
if (isset($_SESSION['cart'][$product_id])) {
    unset($_SESSION['cart'][$product_id]);
    echo 'success';
} else {
    echo 'invalid_product';
}
exit;
?>
