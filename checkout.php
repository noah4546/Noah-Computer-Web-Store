<?php
/**
 * Noah Tomkins, 000790079
 * 
 * Noah Computers Webstore
 * 
 * Created: 27/10/2020
 * I, Noah Tomkins, 000790079 certify that this material is my original work.  
 * No other person"s work has been used without due acknowledgement.
 */
session_start();

require_once 'php/connect.php';

if (!isset($_SESSION['loggedin']) || !isset($_SESSION['id']) || !isset($_SESSION['username'])) {
    session_destroy();
    header("Location: login.php");
} 

$cart_error = "";
if (isset($_SESSION['cart_error'])) {
    $cart_error = $_SESSION['cart_error'];
    unset($_SESSION['cart_error']);
}

$cart_success = "";
if (isset($_SESSION['cart_success'])) {
    $cart_success = $_SESSION['cart_success'];
    unset($_SESSION['cart_success']);
}

$loggedin = $_SESSION['loggedin'];
$id = $_SESSION['id'];
?><!DOCTYPE html>
<html lang='en'>
    <head>
        <title>Noah Computers</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="stylesheet" href="css/global.css">
        <link rel="stylesheet" href="css/header.css">
        <link rel="stylesheet" href="css/checkout.css">
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="js/main.js"></script>
        <script src="js/checkout.js"></script>
    </head>
    <body>
        <header>
            <div class="notice">
                This is not a real shop, none of the products on this site will be shipped or actually sold.
                No payment info will be taken by the user. (<a href="https://tnoah.ca/shop/info.html">More Info</a>)
            </div>
            <div class="header">
                <div class="header-logo">
                    <a href="index.php"><img class="logo" src="images/logo.png" /></a>
                </div>
                <div class="header-search">
                    <form action="search.php" method="GET">
                        <input type="search" name="search" id="search" placeholder="Search All Products"/>
                        <input type="image" src="images/search.png" />
                    </form>
                </div>
                <div>
                    <a href="user.php" class="header-user">
                        <div class="header-user-image"><img src="images/default_user.png" /></div>
                        <div>Welcome</div>
                        <div class="header-user-name"><?php
                            if ($loggedin && isset($_SESSION['username'])) {
                                echo $_SESSION['username'];
                            } else {
                                echo "Sign in / Register";
                                session_destroy();
                            }
                        ?></div>
                    </a> 
                </div>
                <div class="header-cart">
                    <a href="cart.php"><img src="images/cart.png" /></a>
                </div>
            </div>
        </header>
        <main>
            <div class="lhs">
                <h2>Review your order</h2>
                <div class="shipping-and-payment">
                    <div>
                        <h3>Shipping address <a href="user.php" class="change">Change</a></h3>
                        <div id="address">
                            <p>No address set</p>
                        </div>
                    </div>
                    <div>
                        <h3>Payment method</h3>
                        <p>VISA ending in 1234</p>
                    </div>
                </div>
                <div id="products">
                    No Products in cart
                </div>
            </div>
            <div class="rhs">
                <div class="place-order">
                    <form action="placeorder.php" method="POST">
                        <input type="submit" id="place_order_button" value="Place your order" disabled>
                    </form>
                    <h4>Order Summary</h4>
                    <div id="order_summary">

                    </div>
                    <div id="total">
                        
                    </div>
                </div>
            </div>
        </main>
        <footer>
        
        </footer>
    </body>
</html>