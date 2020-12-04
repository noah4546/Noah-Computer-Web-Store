<?php

session_start();

include_once "../connect.php";

$error = "";

$command = "SELECT * FROM `product_category` ORDER BY `name` ASC";
$stmt = $dbh->prepare($command);
$success = $stmt->execute();

$categories = [];
if ($success) { 
    while($row = $stmt->fetch()) {

        $category = [
            "id" => $row['id'],
            "name" => $row['name'],
            "description" => $row['description']
        ];

        array_push($categories, $category);

        $json = [
            "success" => "true",
            "count" => $stmt->rowCount(),
            "category" => $categories
        ];
    }
} else {
    $json = [
        "success" => "false",
        "error" => $error
    ];
}

echo json_encode($json);