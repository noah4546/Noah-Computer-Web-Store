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
        <link rel="stylesheet" href="css/cart.css">
        
        <script src="js/main.js"></script>
        <script src="js/cart.js"></script>
    </head>
    <body>
        <header>
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
        </header>
        <main>
            <div class="cart">
                <h2>Shopping Cart</h2>
                <div id="cart_header">Price</div>
                <div id="cart">
                </div>
                <div id="cart_total">

                </div>
            </div>
            <div class="checkout">
                <form action="checkout.php">
                    <input type="submit" value="Proceed to Checkout">
                </form>
            </div>
        </main>
        <footer>
        
        </footer>
    </body>
</html>