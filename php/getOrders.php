<?php

session_start();

include_once "connect.php";

$error = "";
if (!isset($_SESSION['loggedin']) || !isset($_SESSION['id']) || !isset($_SESSION['username']) || !isset($_SESSION['admin'])) {
    $error = "not logged in";
} 

$orders = [];
$products = [];
if (empty($error)) {

    $id = $_SESSION['id'];

    $command = "SELECT `order`.`id`, `order`.`total`, `order`.`date`, `order`.`status`, 
                `order_item`.`product_id`, `product`.`name`, `product`.`image_url`, 
                `order_item`.`price`, `order_item`.`discount`, `order_item`.`quantity`,
                `order_address`.`name` as 'full_name', `order_address`.`street_address`,
                `order_address`.`city`, `order_address`.`province`, `order_address`.`postal`
                FROM `order`
                JOIN `order_item`
                ON `order`.`id`=`order_item`.`order_id`
                JOIN `product`
                ON `order_item`.`product_id`=`product`.`id`
                JOIN `order_address`
                ON `order`.`id`=`order_address`.`order_id`
                WHERE `order`.`user_id`=?
                ORDER BY `order`.`id` DESC, `product`.`name`";
    $stmt = $dbh->prepare($command);
    $params = [$id];
    $success = $stmt->execute($params);

    $order_id = -1;
    $order = [];
    if ($success) {
        if ($stmt->rowCount() >= 1) {
            while ($row = $stmt->fetch()) {

                if ($order_id == -1) {
                    $order_id = $row['id'];
                }

                if ($order_id != $row['id']) {
                    $order_id = $row['id'];
                    array_push($orders, $order);
                    $products = [];
                }

                $product = [
                    "id" => $row['product_id'],
                    "name" => $row['name'],
                    "price" => $row['price'],
                    "discount" => $row['discount'],
                    "quantity" => $row['quantity'],
                    "image" => $row['image_url']
                ];

                $address = [
                    "name" => $row['full_name'],
                    "street_address" => $row['street_address'],
                    "city" => $row['city'],
                    "province" => $row['province'],
                    "postal" => $row['postal']
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
                    "address" => $address,
                    "products" => $products
                ];

            }
            array_push($orders, $order);

            $json = [
                "success" => "true",
                "count" => count($orders),
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