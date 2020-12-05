<?php

include '../../php/connect.php';

$name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_STRING);
$description = filter_input(INPUT_POST, "description", FILTER_SANITIZE_SPECIAL_CHARS);
$price = filter_input(INPUT_POST, "price", FILTER_VALIDATE_FLOAT);
$discount = filter_input(INPUT_POST, "discount", FILTER_VALIDATE_FLOAT);
$quantity = filter_input(INPUT_POST, "discount", FILTER_VALIDATE_INT);
$category = filter_input(INPUT_POST, "category", FILTER_SANITIZE_STRING);

$paramsok = true;
if ($name === null || empty($name)) {
    $paramsok = false;
}
if ($description === null || empty($description)) {
    $description = "";
}
if ($price === null || $price < 0) {
    $paramsok = false;
}
if ($discount === null || $discount < 0) {
    $discount = 0.00;
}
if ($quantity === null || $quantity < 0) {
    $quantity = 0;
}

$id = 0;
$success = false;
if ($paramsok) {

    $command = "SELECT * FROM `product` WHERE `name`=?";
    $stmt = $dbh->prepare($command);
    $params = [$name];
    $success = $stmt->execute($params);

    if ($success) {
        if ($stmt->rowCount() > 0) {
            
            $command = "UPDATE `product` 
                        SET `name`=?, `description`=?, `price`=?, `discount`=?, `quantity`=?
                        WHERE `name`=?";
            $stmt = $dbh->prepare($command);
            $params = [$name, $description, $price, $discount, $quantity, $name];
            $success = $stmt->execute($params);
            

            if (!$success) {
                $_SESSION['error'] = "Unable to connect to server, please try again";
            }
        } else {

            $command = "INSERT INTO `product` (`name`, `description`, `price`, `discount`, `quantity`)
                        VALUES (?,?,?,?,?)";
            $stmt = $dbh->prepare($command);
            $params = [$name, $description, $price, $discount, $quantity];
            $success = $stmt->execute($params);
            

            if (!$success) {
                $_SESSION['error'] = "Unable to connect to server, please try again";
            }
        }
    } else {
        $_SESSION['error'] = "Unable to connect to server, please try again";
    }
} else {
    $_SESSION['error'] = "Paramaters were not correct, please try again";
}

if (!empty($_SESSION['error'])) {
    header("Location: ../products.php");
}

if ($success) {

    $command = "SELECT `id` FROM `product` WHERE `name`=?";
    $stmt = $dbh->prepare($command);
    $params = [$name];
    $success = $stmt->execute($params);

    if ($success) {

        $row = $stmt->fetch();
        $id = $row['id'];

        $target_dir = "../../images/products/";
        $target_file = $target_dir . basename($_FILES['image']['name']);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $file_name = "product" . $id . "." . $imageFileType;
        $target_file = $target_dir . $file_name;

        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
            $_SESSION['error'] = "Incorect file type, must be: jpg, png, jpeg, gif";
            header("Location: ../products.php");
        }

        if(file_exists($target_file)) {
            unlink($target_file);
        }

        $success = move_uploaded_file($_FILES['image']['tmp_name'], $target_file);

        if ($success) {
            
            $command = "UPDATE `product` SET `image_url`=? WHERE `id`=?";
            $stmt = $dbh->prepare($command);
            $params = [$file_name, $id];
            $success = $stmt->execute($params);

            if (!$success) {
                $_SESSION['error'] = "Unable to update image";
            }
        } else {
            $_SESSION['error'] = "Unable to upload image";
        }
    }

    header("Location: ../products.php");
}