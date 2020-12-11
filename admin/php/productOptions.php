<?php

session_start();

include '../../php/connect.php';

$product = filter_input(INPUT_POST, 'product', FILTER_VALIDATE_INT);
$option = filter_input(INPUT_POST, 'option', FILTER_SANITIZE_STRING);

if (!isset($_SESSION['loggedin']) || !isset($_SESSION['id']) || !isset($_SESSION['username']) || !isset($_SESSION['admin'])) {
    session_destroy();
    header("Location: ../../login.php");
    die();
} 
if ($product === null || $product < 1) {
    header("Location: ../products.php");
    die();
}
if ($option === null || empty($option)) {
    header("Location: ../products.php");
    die();
}

$command = "";
if ($option == "edit") {
    header("Location: ../editProduct.php?product=" . $product);
    die();
} else if ($option == "feature") {
    $command = "UPDATE `product` SET `status`='featured' WHERE `id`=?";
} else if ($option == "avail") {
    $command = "UPDATE `product` SET `status`='available' WHERE `id`=?";
} else if ($option == "unavail") {
    $command = "UPDATE `product` SET `status`='unavailable' WHERE `id`=?";
} else if ($option == "discontinue") {
    $command = "UPDATE `product` SET `status`='discontinued' WHERE `id`=?";
}

if (!empty($command)) {
    
    $stmt = $dbh->prepare($command);
    $params = [$product];
    $success = $stmt->execute($params);

}

header("Location: ../products.php");