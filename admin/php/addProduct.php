<?php

include '../../php/connect.php';

$name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_STRING);
$price = filter_input(INPUT_POST, "price", FILTER_VALIDATE_FLOAT);
$discount = filter_input(INPUT_POST, "discount", FILTER_VALIDATE_FLOAT);
$quantity = filter_input(INPUT_POST, "quantity", FILTER_VALIDATE_INT);
$status = filter_input(INPUT_POST, "status", FILTER_SANITIZE_STRING);

// There is no direct filter for these inputs but you still
// can not sql inject or run php on product page
$short_description = filter_input(INPUT_POST, "short_description");
$long_description = filter_input(INPUT_POST, "long_description");

$paramsok = true;
if ($name === null || empty($name)) {
    $paramsok = false;
}
if ($short_description === null || empty($short_description)) {
    $short_description = "";
}
if ($long_description === null || empty($long_description)) {
    $long_description = "";
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
if ($status === null || empty($status)) {
    $status = "available";
}

$success = false;
if ($paramsok) {

    $command = "SELECT * FROM `product` WHERE `name`=?";
    $stmt = $dbh->prepare($command);
    $params = [$name];
    $success = $stmt->execute($params);

    if ($success) {
        if ($stmt->rowCount() > 0) {
            
            $command = "UPDATE `product` 
                        SET `name`=?, `short_description`=?, `long_description`=?, `price`=?, `discount`=?, `quantity`=?, `status`=?
                        WHERE `name`=?";
            $stmt = $dbh->prepare($command);
            $params = [$name, $short_description, $long_description, $price, $discount, $quantity, $status, $name];
            $success = $stmt->execute($params);
            
            if (!$success) {
                $_SESSION['error'] = "Unable to connect to server, please try again";
            }
        } else {

            $command = "INSERT INTO `product` (`name`, `short_description`, `long_description`, `price`, `discount`, `quantity`, `status`)
                        VALUES (?,?,?,?,?,?,?)";
            $stmt = $dbh->prepare($command);
            $params = [$name, $short_description, $long_description, $price, $discount, $quantity, $status];
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

if ($success && isset($_FILES['image'])) {

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
    } else {
        $_SESSION['error'] = "Error connecting to server";
    }
}

if ($success && isset($_FILES['long_description'])) {

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
    } else {
        $_SESSION['error'] = "Error connecting to server";
    }
}

header("Location: ../products.php");