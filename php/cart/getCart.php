<?php

session_start();

include_once "../connect.php";

$error = "";
if (!isset($_SESSION['loggedin']) || !isset($_SESSION['id']) || !isset($_SESSION['username']) || !isset($_SESSION['admin'])) {
    $error = "not logged in";
} 

$products = [];
if (empty($error)) {

    $id = $_SESSION['id'];

    $command = "SELECT `product`.`id`, `product_category`.`name` as 'category_name', 
                `product`.`name`, `cart`.`price`, `cart`.`discount`, `cart`.`quantity`, 
                `product`.`quantity` as 'stock', `product`.`status`, `product`.`image_url`
                FROM `cart` 
                JOIN `product`
                ON `product`.`id` = `cart`.`product_id`
                JOIN `product_category`
                ON `product`.`category_id` = `product_category`.`id`
                WHERE `cart`.`user_id`=?";
    $stmt = $dbh->prepare($command);
    $params = [$id];
    $success = $stmt->execute($params);

    if ($success) {
        if ($stmt->rowCount() >= 1) {
            while ($row = $stmt->fetch()) {

                $product = [
                    "id" => $row['id'],
                    "category" => $row['category_name'],
                    "name" => $row['name'],
                    "price" => $row['price'],
                    "discount" => $row['discount'],
                    "quantity" => $row['quantity'],
                    "stock" => $row['stock'],
                    "status" => $row['status'],
                    "image" => $row['image_url']
                ];

                array_push($products, $product);

                $json = [
                    "success" => "true",
                    "count" => $stmt->rowCount(),
                    "products" => $products
                ];
            }
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