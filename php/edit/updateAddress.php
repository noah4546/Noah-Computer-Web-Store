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

include_once '../connect.php';

$street_address = filter_input(INPUT_POST, "street_address", FILTER_SANITIZE_STRING);
$city = filter_input(INPUT_POST, "city", FILTER_SANITIZE_STRING);
$province = filter_input(INPUT_POST, "province", FILTER_SANITIZE_STRING);
$postal = filter_input(INPUT_POST, "postal", FILTER_SANITIZE_STRING);

$error = "";

if ($street_address === null || empty($street_address)) {
    $error = "street address is empty";
}
if ($city === null || empty($city)) {
    $error = "city is empty";
}
if ($province === null || empty($province)) {
    $error = "province is empty";
}
if ($postal === null || empty($postal)) {
    $error = "email is empty";
}

if (empty($error)) {

    $command = "SELECT * FROM `address` WHERE `user_id`=?";
    $stmt = $dbh->prepare($command);
    $params = [$_SESSION['id']];
    $success = $stmt->execute($params);
    
    if ($success) {
        if ($stmt->rowCount() == 0) {
    
            $command = "INSERT INTO `address` 
                        (`user_id`, `street_address`, `city`, `province`, `postal`) 
                        VALUES (?,?,?,?,?)";
            $stmt = $dbh->prepare($command);
            $params = [$_SESSION['id'], $street_address, $city, $province, $postal];
            $success = $stmt->execute($params);
    
            if (!$success) {
                $_SESSION['edit_error'] = "error updating address";
            }
        } else {
            
            $command = "UPDATE `address` 
                        SET `street_address`=?,`city`=?,`province`=?,`postal`=? 
                        WHERE `user_id`=?";
            $stmt = $dbh->prepare($command);
            $params = [$street_address, $city, $province, $postal, $_SESSION['id']];
            $success = $stmt->execute($params);
    
            if (!$success) {
                $_SESSION['edit_error'] = "error updating address";
            }
        }
    } else {
        $_SESSION['edit_error'] = "error connecting to server";
    }
} else {
    $_SESSION['edit_error'] = $error;
}


header("Location: ../../user.php");