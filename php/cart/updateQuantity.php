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

include_once '../connect.php';

$product_id = filter_input(INPUT_POST, "product", FILTER_VALIDATE_INT);
$quantity = filter_input(INPUT_POST, "quantity", FILTER_VALIDATE_INT);

if(!isset($_SESSION['id'])) {
    header("Location: ../../login.php");
    die();
}
$id = $_SESSION['id'];

$paramsok = true;
if ($product_id === null || $product_id <= 0) {
    $paramsok = false;
}
if ($quantity === null) {
    $paramsok = false;
}

if ($quantity <= 0) {
    $_SESSION['cart_error'] = "Can't set quantity to 0, if you would like to delete please use delete button";
    header("Location: ../../cart.php");
    die();
}

if ($paramsok) {

    $command = "SELECT * FROM `product` WHERE `id`=?";
    $stmt = $dbh->prepare($command);
    $params = [$product_id];
    $success = $stmt->execute($params);

    if ($success) {
        $row = $stmt->fetch();
        $stock = $row['quantity'];

        if ($quantity <= $stock) {
            $command = "UPDATE `cart`
                        SET `quantity`=?
                        WHERE `user_id`=? AND `product_id`=?";
            $stmt = $dbh->prepare($command);
            $params = [$quantity, $id, $product_id];
            $success = $stmt->execute($params);

            if ($success) {
                $_SESSION['cart_success'] = "Updated cart quantity"; 
            } else {
                $_SESSION['cart_error'] = "Unable update product in cart";
            }
        } else {
            $_SESSION['cart_error'] = "Can't add more products than stock";
        }    
    } else {
        $_SESSION['cart_error'] = "Product not found";
    } 
} else {
    header("Location: ../../index.php");
    die();
}

header("Location: ../../cart.php");