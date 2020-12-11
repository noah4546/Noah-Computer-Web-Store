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

if (!isset($_SESSION['loggedin'])) {
    $_SESSION['loggedin'] = false;
} 

$search = filter_input(INPUT_GET, "search", FILTER_SANITIZE_STRING);

if ($search === null || empty($search)) {
    $search = "";
}

$loggedin = $_SESSION['loggedin'];
?><!DOCTYPE html>
<html lang='en'>
    <head>
        <title>Noah Computers</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="stylesheet" href="css/global.css">
        <link rel="stylesheet" href="css/header.css">
        <link rel="stylesheet" href="css/search.css">
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="js/main.js"></script>
        <script src="js/search.js"></script>
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
                        <input type="search" name="search" id="search" placeholder="Search All Products" value="<?= $search ?>"/>
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
            <div class="not-found">
                <h2>No products found</h2>
                <h3>Please try a differnet search query</h3>
            </div>
            <div id="products">
                
            </div>
        </main>
        <footer>
        
        </footer>
    </body>
</html>