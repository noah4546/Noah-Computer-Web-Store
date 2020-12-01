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
    header("Location: login.php");
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
        
        <script src="js/main.js"></script>
    </head>
    <body>
        <header>
            <div class="header-logo">
                <h1>Noah Computers<h1>
            </div>
            <div class="header-search">
                <form>
                    <input type="search" id="search" placeholder="Keywords or Item #"/>
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
            <h2><a href="php/logout.php">Log out</a></h2>
        </main>
        <footer>
        
        </footer>
    </body>
</html>