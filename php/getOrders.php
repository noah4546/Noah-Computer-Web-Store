<?php

session_start();

include_once "connect.php";

$error = "";
if (!isset($_SESSION['loggedin']) || !isset($_SESSION['id']) || !isset($_SESSION['username']) || !isset($_SESSION['admin'])) {
    $error = "not logged in";
} 

$orders = [];
$products = [];
$orderQty = 0;
if (empty($error)) {

    $id = $_SESSION['id'];

    $command = "SELECT `order`.`id`, `order`.`total`, `order`.`date`, `order`.`status`, 
                `order_item`.`product_id`, `product`.`name`, `product`.`image_url`, 
                `order_item`.`price`, `order_item`.`discount`, `order_item`.`quantity`
                FROM `order`
                JOIN `order_item`
                ON `order`.`id`=`order_item`.`order_id`
                JOIN `product`
                ON `order_item`.`product_id`=`product`.`id`
                WHERE `order`.`user_id`=?
                ORDER BY `order`.`id` DESC, `product`.`name`";
    $stmt = $dbh->prepare($command);
    $params = [$id];
    $success = $stmt->execute($params);

    $order_id = 0;
    if ($success) {
        if ($stmt->rowCount() >= 1) {
            while ($row = $stmt->fetch()) {

                $product = [
                    "id" => $row['product_id'],
                    "name" => $row['name'],
                    "price" => $row['price'],
                    "discount" => $row['discount'],
                    "quantity" => $row['quantity'],
                    "image" => $row['image_url']
                ];

                array_push($products, $product);

                $date = date_create($row['date']);

                $order = [
                    "count" => count($products),
                    "id" => $row['id'],
                    "total" => $row['total'],
                    "dateRaw" => $row['date'],
                    "date" => date_format($date, "F d, Y"),
                    "status" => $row['status'],
                    "products" => $products
                ];

                if ($order_id != $row['id']) {
                    $order_id = $row['id'];
                    array_push($orders, $order);
                    $products = [];
                    $orderQty++;
                }
            }

            $json = [
                "success" => "true",
                "count" => $orderQty,
                "orders" => $orders
            ];
        } else {
            $error = "cart empty";
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