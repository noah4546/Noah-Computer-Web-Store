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

$product_id = filter_input(INPUT_GET, "product", FILTER_SANITIZE_STRING);

if ($product_id === null || empty($product_id)) {
    header("Location: products.php");
}

?><!DOCTYPE html>
<html lang='en'>
    <head>
        <title>Noah Computers</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="../favicon.ico" type="image/x-icon"/>

        <link rel="stylesheet" href="../css/global.css">
        <link rel="stylesheet" href="../css/header.css">
        <link rel="stylesheet" href="css/admin.css">
        <link rel="stylesheet" href="css/editProduct.css">
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="../js/main.js"></script>
        <?php if ($product_id != "-1") { ?>
        <script src="js/loadProduct.js"></script>
        <?php } ?>
    </head>
    <body>
        <header>
            <div class="notice">
                This is not a real shop, none of the products on this site will be shipped or actually sold.
                No payment info will be taken by the user. (<a href="https://tnoah.ca/shop/info.html">More Info</a>)
            </div>
            <div class="header">
                <div class="header-logo">
                    <a href="../index.php"><img class="logo" src="../images/logo.png" /></a>
                </div>
                <div class="header-search">
                    <form action="../search.php" method="GET">
                        <input type="search" name="search" id="search" placeholder="Search All Products"/>
                        <input type="image" src="../images/search.png" />
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
                <?php if ($product_id != "-1") { ?>
                    <h2>Id: <span id="product_id"><?php echo $product_id ?></span></h2>
                    <h2>Name: <span id="product_name"></span></h2>
                <?php } else { ?>
                    <h2>Creating new product</h2>
                <?php } ?>
                <form action="php/addProduct.php" method="POST" id="product_form" enctype="multipart/form-data">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" required/>

                    <label for="status">Status</label>
                    <select name="status" id="status" required>
                        <option value="available">available</option>
                        <option value="featured">featured</option>
                        <option value="unavalible">unavalible</option>
                        <option value="discontinued">discontinued</option>
                    </select>

                    <label for="short_description">Short Description</label>
                    <textarea name="short_description" id="short_description" rows="10" cols="30"></textarea>

                    <label for="long_description">Long Description (*.html)</label>
                    <input type="file" name="long_description" id="long_description" accept=".html">

                    <label for="image">Image</label>
                    <input type="file" name="image" id="image" accept="image/*"/>

                    <!--<img src="" id="image_preview">-->

                    <label for="price">Price</label>
                    <input type="number" name="price" id="price" min="0" step=".01" required />

                    <label for="discount">Discount</label>
                    <input type="number" name="discount" id="discount" step=".01" min="0" />

                    <label for="quantity">Quantity</label>
                    <input type="number" name="quantity" id="quantity" />

                    <input type="submit" />
                </form>
            </div>
        </main>
        <footer>
        
        </footer>
    </body>
</html>