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

$order = filter_input(INPUT_GET, 'order', FILTER_VALIDATE_INT);

if (!isset($_SESSION['loggedin']) || !isset($_SESSION['id']) || !isset($_SESSION['username']) || !isset($_SESSION['admin'])) {
    session_destroy();
    $json = [
        "success" => "false",
        "error" => "Not an admin"
    ];
    echo json_encode($json);
    die();
} 
if ($_SESSION['admin'] == 0) {
    session_destroy();
    $json = [
        "success" => "false",
        "error" => "Not an admin"
    ];
    echo json_encode($json);
    die();
}

$error = "";

$json = [];
if ($order !== null && $order > 0) {

    $command = "SELECT `order_item`.*, `product`.`name` 
                FROM `order_item` JOIN `product` 
                ON `order_item`.`product_id`=`product`.`id`
                WHERE `order_item`.`order_id`=?";
    $stmt = $dbh->prepare($command);
    $params = [$order];
    $success = $stmt->execute($params);

    $products = [];
    if ($success) {
        while ($row = $stmt->fetch()) {

            $product = [
                "id" => $row['product_id'],
                "name" => $row['name'],
                "price" => $row['price'],
                "discount" => $row['discount'],
                "quantity" => $row['quantity']
            ];

            array_push($products, $product);

            $json = [
                "success" => "true",
                "count" => $stmt->rowCount(),
                "id" => $order,
                "products" => $products
            ];
        }
    } else {
        $error = "unable to connect to server";
    }
}

if(!empty($error)) {
    $json = [
        "success" => "false",
        "error" => $error
    ];
}

echo json_encode($json);