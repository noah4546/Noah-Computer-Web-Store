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

require_once '../php/connect.php';

if (!isset($_SESSION['loggedin']) || !isset($_SESSION['id']) || !isset($_SESSION['username']) || !isset($_SESSION['admin'])) {
    session_destroy();
    header("Location: login.php");
} 

$edit_error = "";
if (isset($_SESSION['edit_error'])) {
    $edit_error = $_SESSION['edit_error'] . ", please try again";
    unset($_SESSION['edit_error']);
}

$loggedin = $_SESSION['loggedin'];
$id = $_SESSION['id'];
$admin = $_SESSION['admin'];

if ($admin != "1") {
    session_destroy();
    header("Location: ../login.php");
}

?><!DOCTYPE html>
<html lang='en'>
    <head>
        <title>Noah Computers</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="stylesheet" href="../css/global.css">
        <link rel="stylesheet" href="../css/header.css">
        <link rel="stylesheet" href="css/admin.css">
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="../js/main.js"></script>
        <script src="js/admin.js"></script>
    </head>
    <body>
        <header>
            <div class="header-logo">
                <a href="../index.php"><img class="logo" src="../images/logo.png" /></a>
            </div>
            <div class="header-search">
                <form action="../search.php" method="GET">
                    <input type="search" name="search" id="search" placeholder="Search All Products"/>
                    <input type="image" src="images/search.png" />
                </form>
            </div>
            <div>
                <a href="../user.php" class="header-user">
                    <div class="header-user-image"><img src="../images/default_user.png" /></div>
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
                <a href="../cart.php"><img src="../images/cart.png" /></a>
            </div>
        </header>
        <main>
            <div class="menu">
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="orders.php">Orders</a></li>
                    <li><a href="products.php">Products</a></li>
                    <li><a href="customers.php">Customers</a></li>
                </ul>
            </div>
            <div class="content">
                <div>
                    <h2>Jump to</h2>
                    <h3><a href="#product_catagories">Product Catagories</a></h3>
                    <h3><a href="#products">Products</a></h3>
                </div>
                <div id="product_catagories">
                    <h2>Product Catagories</h2>
                    <table id="product_category_table">
                        <tr>
                            <th>Category id</th>
                            <th>Category name</th>
                            <th>Category description</th>
                        </tr>
                    </table>
                </div>
                <div id="products">
                    <h2>Products</h2>
                    <table id="products_table">
                        <tr>
                            <th>Product id</th>
                            <th>Catagory</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Discount</th>
                            <th>Quantity</th>
                            <th>Status</th>
                        </tr>
                    </table>
                    <ul>
                        <li>Product id</li>
                        <li>Catagory</li>
                        <li>Name</li>
                        <li>Price</li>
                        <li>Discount</li>
                        <li>Quantity</li>
                        <li>Status</li>
                    </ul>
                </div>
            </div>
        </main>
        <footer>
        
        </footer>
    </body>
</html>