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
    $command = "SELECT `user`.`id`, `user`.`username`, `user`.`email`, `user`.`active`, 
                `user`.`admin`, `user`.`create`, `address`.`name`, `address`.`street_address`, 
                `address`.`city`, `address`.`province`, `address`.`province`, `address`.`postal`
                FROM `user`
                LEFT JOIN `address`
                ON `user`.`id`=`address`.`user_id`
                ORDER BY `user`.`id`";
    $stmt = $dbh->prepare($command);
    $success = $stmt->execute();
} else {
    $command = "SELECT `user`.`id`, `user`.`username`, `user`.`email`, `user`.`active`, 
                `user`.`admin`, `user`.`create`, `address`.`name`, `address`.`street_address`, 
                `address`.`city`, `address`.`province`, `address`.`province`, `address`.`postal`
                FROM `user`
                LEFT JOIN `address`
                ON `user`.`id`=`address`.`user_id`
                WHERE `user`.`username` LIKE ?
                ORDER BY `user`.`id`";
    $stmt = $dbh->prepare($command);
    $params = ["%" . $filter . "%"];
    $success = $stmt->execute($params);
}

$json = [];
$users = [];
if ($success) {
    while($row = $stmt->fetch()) {

        $address = [
            "name" => $row['name'],
            "street_address" => $row['street_address'],
            "city" => $row['city'],
            "province" => $row['province'],
            "postal" => $row['postal']
        ];

        $user = [
            "id" => $row['id'],
            "username" => $row['username'],
            "email" => $row['email'],
            "active" => $row['active'],
            "admin" => $row['admin'],
            "create" => $row['create'],
            "address" => $address
        ];

        array_push($users, $user);
    }

    $json = [
        "success" => "true",
        "count" => $stmt->rowCount(),
        "users" => $users
    ];
} else {
    $json = [
        "success" => "false",
        "error" => $error
    ];
}

echo json_encode($json);