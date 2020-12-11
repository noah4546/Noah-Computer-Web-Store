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
    die();
} 
if ($_SERVER["REQUEST_METHOD"] != "POST"){
    header("Location: login.php");
    die();
}

$loggedin = $_SESSION['loggedin'];
$id = $_SESSION['id'];
$orderplaced = false;
$error = "";

$command = "SELECT * FROM `cart` WHERE `user_id`=?";
$stmt = $dbh->prepare($command);
$params = [$id];
$success = $stmt->execute($params);

$total = 0;

if ($success) {
    if ($stmt->rowCount() >= 1) {
        while ($row = $stmt->fetch()) {
            $total += ($row['price'] * $row['quantity']);
        }
        $total = $total * 1.13;

        $command = "INSERT INTO `order` (`user_id`, `total`) VALUES (?,?)";
        $stmt = $dbh->prepare($command);
        $params = [$id, $total];
        $success = $stmt->execute($params);

        if ($success) {

            $command = "SELECT * FROM `order` 
                        WHERE `user_id`=? 
                        ORDER BY `id` DESC";
            $stmt = $dbh->prepare($command);
            $params = [$id];
            $success = $stmt->execute($params);

            if ($success) {
                $row = $stmt->fetch();
                $orderid = $row['id'];

                $command = "INSERT INTO `order_item` 
                            (`product_id`, `order_id`, `price`, `discount`, `quantity`)
                            SELECT `product_id`, ?, `price`, `discount`, `quantity`
                            FROM `cart`
                            WHERE `cart`.`user_id`=?";
                $stmt = $dbh->prepare($command);
                $params = [$orderid, $id];
                $success = $stmt->execute($params);

                if ($success) {

                    $orderplaced = true;

                    $command = "DELETE FROM `cart` WHERE `user_id`=?";
                    $stmt = $dbh->prepare($command);
                    $params = [$id];
                    $success = $stmt->execute($params);

                    if (!$success) {
                        $error = "Order placed but cart not cleared, please clear your cart manualy";
                    }
                } else {
                    $error = "Error creating order please try again";

                    $command = "DELETE FROM `order` WHERE `id`=?";
                    $stmt = $dbh->prepare($command);
                    $params = [$orderid];
                    $success = $stmt->execute($params);
                }
            } else {
                $error = "Error creating order please try again";
            }
        } else {
            $error = "Error creating order please try again";
        }
    } else {
        $error = "No items in cart";
    }
}

/*
$command = "INSERT INTO `order` (`user_id`, `total`) VALUES (?,?)";
$stmt = $dbh->prepare($command);
$params = [$id];
$success = $stmt->execute($params);

if ($success) {
    
    $command = "SELECT * FROM `cart` WHERE `user_id`=?";
    $stmt = $dbh->prepare($command);
    $params = [$id];
    $success = $stmt->execute($params);

}
*/
?><!DOCTYPE html>
<html lang='en'>
    <head>
        <title>Noah Computers</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="stylesheet" href="css/global.css">
        <link rel="stylesheet" href="css/header.css">
        <link rel="stylesheet" href="css/placeorder.css">
        
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
            <?php if ($orderplaced) { ?>
                <div>
                    <h2>Your order has been successfuly placed!</h2>
                    <h4><a href="index.php">Continue shopping</a><a href="php/logout.php">Logout</a></h4>
                </div>
            <?php } else { ?>
                <div>
                    <h2>Failed placing order, please try again</h2>
                    <h3><?= $error ?></h3>
                    <h4><a href="index.php">Continue shopping</a><a href="php/logout.php">Logout</a></h4>
                </div>
            <?php } ?>
        </main>
        <footer>
        
        </footer>
    </body>
</html>