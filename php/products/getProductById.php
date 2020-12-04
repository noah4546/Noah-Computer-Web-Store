<?php

session_start();

include_once "../connect.php";

$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING);
$error = "";

if ($id === null || empty($id)) {
    $error = "No id specified";
    
} 

if (empty($error)) {

    $command = "SELECT `product`.`id`, `product_category`.`name` as 'category',
        `product`.`name`, `price`, `discount`, `quantity`, `status`
        FROM `product`
        JOIN `product_category`
        ON `product_category`.`id` = `product`.`category_id`
        WHERE `product`.`id` = ?";
    $stmt = $dbh->prepare($command);
    $params = [$id];
    $success = $stmt->execute($params);

    $products = [];
    if ($success) { 
        if ($stmt->rowCount() >= 1) {
            $row = $stmt->fetch();

            $product = [
                "id" => $row['id'],
                "category" => $row['category'],
                "name" => $row['name'],
                "price" => $row['price'],
                "discount" => $row['discount'],
                "quantity" => $row['quantity'],
                "status" => $row['status']
            ];
    
            $json = [
                "success" => "true",
                "product" => $product
            ];

        } else {
            $error = "Not found";
        } 
    } else {
        $error = "Failed to connect to server";
    }

}

if (!empty($error)) {
    $json = [
        "success" => "false",
        "error" => $error
    ];
}

echo json_encode($json);