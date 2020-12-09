<?php

session_start();

include_once '../connect.php';

$product_id = filter_input(INPUT_POST, "product", FILTER_VALIDATE_INT);

if(!isset($_SESSION['id'])) {
    header("Location: ../../login.php");
    die();
}
$id = $_SESSION['id'];

$paramsok = true;
if ($product_id === null || $product_id <= 0) {
    $paramsok = false;
}

if ($paramsok) {

    $command = "DELETE FROM `cart`
                WHERE `product_id`=? AND `user_id`=?";
    $stmt = $dbh->prepare($command);
    $params = [$product_id, $id];
    $success = $stmt->execute($params);

    if ($success) {
        $_SESSION['cart_success'] = "Deleted cart item"; 
    } else {
        $_SESSION['cart_error'] = "Unable delete product in cart";
    }
} else {
    header("Location: ../../index.php");
    die();
}

header("Location: ../../cart.php");