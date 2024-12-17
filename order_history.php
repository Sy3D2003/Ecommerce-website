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
    <title>User Dashboard</title>
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

    <h2>Your Order History</h2>
    
    <table class="table">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Order Date</th>
                <th>Total Price</th>
                <th>Reorder</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>Sterling Silver Pendant Necklace</td>
                <td>2</td>
                <td>2023-10-30</td>
                <td>$100.00</td>
                <td><button class="btn btn-primary">Reorder</button></td>
            </tr>
            <tr>
                <td>2</td>
                <td>Wallet</td>
                <td>1</td>
                <td>2023-10-30</td>
                <td>$45.00</td>
                <td><button class="btn btn-primary">Reorder</button></td>
            </tr>
            <tr>
                <td>3</td>
                <td>Chic Shoulder Bag</td>
                <td>3</td>
                <td>2023-10-30</td>
                <td>$195.00</td>
                <td><button class="btn btn-primary">Reorder</button></td>
            </tr>
        </tbody>
    </table>
    <footer>
    <p>@This business is fictitious and part of a university course.</p>
</footer>
</body>
</html>

