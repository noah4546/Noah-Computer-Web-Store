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
        <link rel="shortcut icon" href="../favicon.ico" type="image/x-icon"/>

        <link rel="stylesheet" href="../css/global.css">
        <link rel="stylesheet" href="../css/header.css">
        <link rel="stylesheet" href="css/admin.css">
        <link rel="stylesheet" href="css/index.css">
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="../js/main.js"></script>
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
                <h1>Welcome to the admin page</h2>
                <h3>You can choose one of the links (home, orders, products, customers)</h3>
                <div class="welcome-info">
                    <div class="welcome-info-group">
                        <b>Orders:</b> This shows you all the orders from the customers, this will allow you to
                        change the status of the order.
                    </div>
                    <div class="welcome-info-group">
                        <b>Products:</b> This shows you all the products that are being sold on this site
                        you can preform many actions on already existing products or create a new product.
                        Creating or editing a product is easy and very flexable bellow is a description
                        of each of the options and what you can do.
                        <div class="products-info">
                            <div><b>Name:</b> This is the name of the product</div>
                            <div>
                                <b>Status:</b> This is how you decide to show off your item
                                <ul>
                                    <li>
                                        <b>Avalible</b> will make it a regular product
                                    </li>
                                    <li>
                                        <b>Featured</b> will put the product on the main page 
                                        to get the most exposure
                                    </li>
                                    <li>
                                        <b>Unavailable</b> will make the product unavailable to be purchaced, 
                                        you can do this if you have ran out of stock and no more is comming soon
                                    </li>
                                    <li>
                                        <b>Discountinued</b> will make the product invisable to the user but if 
                                        they have already purchaced it will still be in their order history.
                                    </li>
                                </ul>
                            </div>
                            <div>
                                <b>Short Decription:</b> This is a short and sweet description of the 
                                product, it can be formated in html or just plain text, this will show
                                on the product page as the first notes about the product so make sure
                                the infromation is there to grab the attention of the user.
                            </div>
                            <div>
                                <b>Long Decription:</b> This is a much longer description of the product
                                this must be uploaded as an .html or .htm file, this file may be given
                                to you buy the manufacture or you can create your own. This gives you
                                more freedom of what to show in a description. You can add your own
                                custom animations, more product images, and specs about the product.
                                To see an example of what your long description could look like enable
                                example products and take a peek.
                            </div>
                            <div>
                                <b>Price:</b> This is the price of your product
                            </div>
                            <div>
                                <b>Discount:</b> This is the discount of the product, how many dollars off
                                is the product (NOT PERCENT)
                            </div>
                            <div>
                                <b>Quantity:</b> This is quantity of products you have avalable, when this
                                number drops bellow 50 items it will tell the customer that it is low in stock
                                and when the number is 0 the customer will not be able to purchace it.
                            </div>
                        </div>
                    </div>
                    <div class="welcome-info-group">
                        <b>Customers:</b> This shows you all the customers, and allows you to deactivate
                        the user, add them as an administrator to be able to edit products, or 
                        delete the user completely (note: their orders will not be deleted, so they
                        may still recive the products)
                    </div>
                </div>
                <div class="examples">
                    <h3>Enable / Disable examples below</h3>
                    <p>This will allow you to see what you can do on this site</p>
                    <p>NOTE PEOPLE CAN PURCHACE THE PRODUCTS</p>
                    <h4><a href="php/addExample.php">ENABLE</a></h4>
                    <h4><a href="php/removeExample.php">DISABLE</a></h4>
                    <div class="cite">
                        The example products are from <a href="https://www.newegg.ca/" target="_blank">newegg.ca</a>
                    </div>
                </div>
            </div>
        </main>
        <footer>
        
        </footer>
    </body>
</html>