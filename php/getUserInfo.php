<?php

session_start();

include_once "connect.php";

$error = "";

$paramsok = true;
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
} else {
    $paramsok = false;
}

if ($paramsok) {

    $command = "SELECT `user`.`id`, `user`.`username`, `user`.`email`, `user`.`active`, 
                `user`.`admin`, `user`.`create`, `address`.`street_address`, 
                `address`.`city`, `address`.`province`, `address`.`postal`, `address`.`name`
                FROM `user`
                LEFT JOIN `address`
                ON `user`.`id` = `address`.`user_id`
                WHERE `user`.`username`=?";
    $stmt = $dbh->prepare($command);
    $params = [$username];
    $success = $stmt->execute($params);
    
    if ($success) {
        if ($stmt->rowCount() == 1) {

            $row = $stmt->fetch();

            $address = [
                "name" => $row['name'],
                "street_address" => $row['street_address'],
                "city" => $row['city'],
                "province" => $row['province'],
                "postal" => $row['postal']
            ];

            $user = [
                "id" => $row['id'],
                "username" => $username,
                "email" => $row['email'],
                "active" => $row['active'],
                "admin" => $row['admin'],
                "created" => $row['create'],
                "address" => $address
            ];

            $json = [
                "success" => "true",
                "user" => $user
            ];

        } else {
            $error = "no user found on database";
        }
    } else {
        $error = "unable to connect to server";
    }
} else {
    $error = "unable to connect to server";
}

if (!empty($error)) {
    $json = [
        "success" => "false",
        "error" => $error
    ];
}

echo json_encode($json);