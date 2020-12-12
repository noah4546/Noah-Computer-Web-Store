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

$filter = filter_input(INPUT_GET, 'filter', FILTER_SANITIZE_STRING);

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

if ($filter === null || empty($filter)) {
    $command = "SELECT * 
                FROM `order` 
                JOIN `order_address` 
                ON `order`.`id`=`order_address`.`order_id`
                ORDER BY `order`.`id`";
    $stmt = $dbh->prepare($command);
    $success = $stmt->execute();
} else {
    $command = "SELECT * 
                FROM `order` 
                JOIN `order_address` 
                ON `order`.`id`=`order_address`.`order_id`
                WHERE `order_address`.`name` LIKE ?
                ORDER BY `order`.`id`";
    $stmt = $dbh->prepare($command);
    $params = ["%" . $filter . "%"];
    $success = $stmt->execute($params);
}

$error = "";
$json = [];
$order = [];
$orders = [];
if ($success) {
    if ($stmt->rowCount() >= 1) {
        while ($row = $stmt->fetch()) {

            $address = [
                "name" => $row['name'],
                "street_address" => $row['street_address'],
                "city" => $row['city'],
                "province" => $row['province'],
                "postal" => $row['postal']
            ];

            $date = date_create($row['date']);

            $order = [
                "id" => $row['order_id'],
                "total" => $row['total'],
                "dateRaw" => $row['date'],
                "date" => date_format($date, "F d, Y"),
                "status" => $row['status'],
                "address" => $address
            ];

            array_push($orders, $order);

        } 

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


if(!empty($error)) {
    $json = [
        "success" => "false",
        "error" => $error
    ];
}

echo json_encode($json);