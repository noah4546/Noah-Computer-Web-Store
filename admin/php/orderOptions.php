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

include '../../php/connect.php';

$order = filter_input(INPUT_POST, 'order', FILTER_VALIDATE_INT);
$option = filter_input(INPUT_POST, 'option', FILTER_SANITIZE_STRING);

if (!isset($_SESSION['loggedin']) || !isset($_SESSION['id']) || !isset($_SESSION['username']) || !isset($_SESSION['admin'])) {
    session_destroy();
    header("Location: ../../login.php");
    die();
} 
if ($order === null || $order < 1) {
    header("Location: ../orders.php");
    die();
}
if ($option === null || empty($option)) {
    header("Location: ../orders.php");
    die();
}

$command = "";
if ($option == "processing") {
    $command = "UPDATE `order` SET `status`='Processing' WHERE `id`=?";
} else if ($option == "shipped") {
    $command = "UPDATE `order` SET `status`='Shipped' WHERE `id`=?";
} else if ($option == "delivered") {
    $command = "UPDATE `order` SET `status`='Delivered' WHERE `id`=?";
} else if ($option == "backorder") {
    $command = "UPDATE `order` SET `status`='Backorder' WHERE `id`=?";
} else if ($option == "canceled") {
    $command = "UPDATE `order` SET `status`='Canceled' WHERE `id`=?";
}

if (!empty($command)) {
    
    $stmt = $dbh->prepare($command);
    $params = [$order];
    $success = $stmt->execute($params);

}

header("Location: ../orders.php");