<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
 
?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>PureSpring Water Solutions</title>

    <link rel="stylesheet" href="/purespring/css/style.css">

</head>

<body>

<header class="site-header">

    <div class="container header-container">

        <div class="logo">

            <h1>PURE<span>SPRING</span></h1>

            <p>Water Solutions</p>

        </div>

        <nav class="main-nav">

            <a href="/purespring/index.php">Home</a>

            <a href="/purespring/Pages/store.php">Store</a>

            <a href="/purespring/Pages/about.php">About Us</a>

            <a href="/purespring/Pages/support.php">Support</a>

            <a href="/purespring/Pages/cart.php">
Cart
<?php

if (isset($_SESSION["cart"])) {

    $cartCount = array_sum($_SESSION["cart"]);

    echo " (" . $cartCount . ")";

}

?>
</a>


            <a href="/purespring/Pages/checkout.php">Checkout</a>





        </nav>

    </div>

</header>
