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
    $_SESSION['lookingAt'] = $product_id;
    header("Location: ../../login.php");
    die();
}
$id = $_SESSION['id'];

$paramsok = true;
if ($product_id === null || $product_id <= 0) {
    $paramsok = false;
}
if ($quantity === null || $quantity <= 0) {
    $paramsok = false;
}

if ($paramsok) {

    $command = "SELECT * FROM `product` WHERE `id`=?";
    $stmt = $dbh->prepare($command);
    $params = [$product_id];
    $success = $stmt->execute($params);

    if ($success) {
        $row = $stmt->fetch();
        $price = $row['price'];
        $discount = $row['discount'];

        $command = "SELECT * FROM `cart` WHERE `user_id`=? AND `product_id`=?";
        $stmt = $dbh->prepare($command);
        $params = [$id, $product_id];
        $success = $stmt->execute($params);

        if ($success) {
            $row = $stmt->fetch();
            $current_quantity = $row['quantity'];

            if ($stmt->rowCount() == 0) {
                $command = "INSERT INTO `cart` (`product_id`, `user_id`, `price`, `discount`, `quantity`)
                            VALUES (?,?,?,?,?)";
                $stmt = $dbh->prepare($command);
                $params = [$product_id, $id, $price, $discount, $quantity];
                $success = $stmt->execute($params);
            } else {
                $command = "UPDATE `cart` 
                            SET `price`=?, `discount`=?, `quantity`=?
                            WHERE `user_id`=? AND `product_id`=?";
                $stmt = $dbh->prepare($command);
                $params = [$price, $discount, $quantity + $current_quantity, $id, $product_id];
                $success = $stmt->execute($params);
            }
        }
        if (!$success) {
            $_SESSION['cart_error'] = "Unable add product to cart";
        }
    } else {
        $_SESSION['cart_error'] = "Unable to find product in database";
    }
} else {
    header("Location: ../../index.php");
    die();
}

header("Location: ../../cart.php");