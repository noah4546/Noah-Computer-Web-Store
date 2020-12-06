<?php

session_start();

include_once "../connect.php";

$error = "";

$command = "SELECT `product`.`id`, `product_category`.`name` as 'category',
            `product`.`name`, `price`, `discount`, `quantity`, `status`, `image_url`,
            `short_description`, `long_description`
            FROM `product`
            JOIN `product_category`
            ON `product_category`.`id` = `product`.`category_id`
            ORDER BY
                `product_category`.`name` ASC,
                `product`.`name` ASC";
$stmt = $dbh->prepare($command);
$success = $stmt->execute();

$json = [];
$products = [];
if ($success) { 
    while($row = $stmt->fetch()) {

        $product = [
            "id" => $row['id'],
            "category" => $row['category'],
            "name" => $row['name'],
            "price" => $row['price'],
            "discount" => $row['discount'],
            "quantity" => $row['quantity'],
            "status" => $row['status'],
            "image" => $row['image_url'],
            "short_description" => $row['short_description'],
            "long_description" => $row['long_description']
        ];

        array_push($products, $product);

        $json = [
            "success" => "true",
            "count" => $stmt->rowCount(),
            "products" => $products
        ];

    }
} else {
    $json = [
        "success" => "false",
        "error" => $error
    ];
}

echo json_encode($json);