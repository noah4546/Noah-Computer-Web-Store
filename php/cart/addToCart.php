<?php

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

        $command = "INSERT INTO `cart` (`product_id`, `user_id`, `price`, `discount`, `quantity`)
                    VALUES (?,?,?,?,?)";
        $stmt = $dbh->prepare($command);
        $params = [$product_id, $id, $price, $discount, $quantity];
        $success = $stmt->execute($params);

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