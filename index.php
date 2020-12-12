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

/**
 * NOTES
 * 
 * Product pages may have console errors this is due to manufacure html being out of date, this
 *      is not an error on my end of code, but an external issue that I have no control over.
 *      When you do decide to add a new product with the custom html description it should not
 *      have any errors if it is up to the new standard of HTML5.
 * 
 * I have added a banner to the top of each and every page saying that this is not a real shop.
 *      I have done this beacuse I am posting it to my personal website as a protfolio item,
 *      and I do not want anyone to think they are getting scamed on this website, even
 *      though it will never ask you for your credit/debit card infromation.
 * 
 * On the checkout page there is 3 steps, the second step being Payment info, I have a message
 *      there saying that I am not taking any payment info and the user can just skip to the
 *      next page, in the next page it says "visa ending in 1234" this is a fake credit card
 *      number and the user will not be charged it is just simulating as if they already put
 *      their credit/debit card infromation into the system, in actuality I would most likey
 *      use a checkout system like "visa checkout" or paypal as they have much more security
 *      and the user can trust the payment method
 * 
 * All the sample products are taken from newegg.ca, in no way am I trying to steal their customers
 *      or their designs, I am just using it as an example. If this site was to actualy go live
 *      or be used as a starting point for another developer those examples should be changed
 *      to their own example. Due to time crunch of this assignment I was unable to make my
 *      own product descriptions, but in the "real world" the manufacture would give you the
 *      full product page.
 * 
 * To access the administrator page you must already be an admin. I have setup some sample accounts
 *      1 regular user and 1 admin. The usernames and passwords are:
 * 
 *          username: admin     password: adm1nP&ss
 *          username: user      password: userP&ss
 *      
 *      you will only need the adminstrator account once to make a new admin, once you are done
 *      that the original admin should be deleted for security reasons (you do not have to 
 *      nessasarily do that, but it will make the website more secure)
 * 
 * I have also posted the code to my github account: https://github.com/noah4546/Noah-Computer-Web-Store
 *      and to my personal website: https://tnoah.ca/shop/
 * 
 * 
 * CHANGELOG
 * 
 * SQL DATABASE:
 *      REMOVED: cart_item table, beacuse it was redundant. The cart table is now a collection of
 *              cart itmes indexed to the user_id
 * 
 *      ADDED: order_address table to allow for addresses to be directly connected to the order
 *              instead of being deleted when a user is deleted. When a user is deleted the order
 *              still connects to a location to ship or to refund
 *      
 *      ADDED: name feild to addresses, beacuse I forgot you need a name on the package to deliver
 *              to a customer
 * 
 * Functions:
 * 
 *      REMOVED: delete product, beacuse if you delete a product it will no longer be able to be
 *                  seen in a users order history, replaced it with a status of discontinued
 * 
 *      ADDED: UPDATE for email, allowing for users to change their email address
 * 
 *      REMOVED: cancel/delete order, ran out of time to add in that function, very complex beacuse
 *                  the administrator would most likely want to keep a copy of every order even if
 *                  the user deletes it, in this case they would have to reach out directly to
 *                  one of the service repersentives to have them cancel the order.
 * 
 *      REMOVED: product categories, ran out of time. Right now whenever you add a new product it
 *                  will set it to uncatigorized, in the future after this assignment and I want
 *                  to build on this project I will add categories to the website allowing the 
 *                  user to navigate through the website easier. At the current moment you still
 *                  can search all of the products and see the featured products.
 * 
 * Other:
 * 
 *      REMOVED: administrators can not force a user to reset their password, ran out of time.
 *      
 *      REMOVED: unactive accounts, the system is in place to disable users, but I did not have
 *                  time to implement it.
 *  
 */
session_start();

if (!isset($_SESSION['loggedin'])) {
    $_SESSION['loggedin'] = false;
} 

$loggedin = $_SESSION['loggedin'];
?><!DOCTYPE html>
<html lang='en'>
    <head>
        <title>Noah Computers</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="favicon.ico" type="image/x-icon"/>

        <link rel="stylesheet" href="css/global.css">
        <link rel="stylesheet" href="css/header.css">
        <link rel="stylesheet" href="css/index.css">
        <link rel="stylesheet" href="css/search.css">
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        
        <script src="js/index.js"></script>
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
            <h1>Featured</h1>
            <div id="error">
                
            </div>
            <div id="products">
                
            </div>
        </main>
        <footer>
        
        </footer>
    </body>
</html>