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
include '../verify.php';

$current_password = filter_input(INPUT_POST, "current_password", FILTER_SANITIZE_STRING);
$new_password = filter_input(INPUT_POST, "new_password", FILTER_SANITIZE_STRING);
$confirm_password = filter_input(INPUT_POST, "confirm_password", FILTER_SANITIZE_STRING);

if ($current_password === null || empty($current_password)) {
    $_SESSION['edit_error'] = "current password is empty";
    header("Location: ../../user.php");
}
if ($new_password === null || empty($new_password)) {
    $_SESSION['edit_error'] = "new password is empty";
    header("Location: ../../user.php");
}
if ($confirm_password === null || empty($confirm_password)) {
    $_SESSION['edit_error'] = "confirm password is empty";
    header("Location: ../../user.php");
}

$command = "SELECT * FROM `user` WHERE `username`=?";
$stmt = $dbh->prepare($command);
$params = [$_SESSION['username']];
$success = $stmt->execute($params);

if ($success) {
    
    $row = $stmt->fetch();
    $hashed_password = $row['password'];

    if (password_verify($current_password, $hashed_password)) {
        
        $new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);

        $command = "UPDATE `user`
                    SET `password`=?
                    WHERE `username`=?";
        $stmt = $dbh->prepare($command);
        $params = [$new_password_hash, $_SESSION['username']];
        $success = $stmt->execute($params);

        if ($success) {
            session_destroy();
        } else {
            $_SESSION['edit_error'] = "error updating password";
        }
    } else {
        $_SESSION['edit_error'] = "invalid current password";
    }
} else {
    $_SESSION['edit_error'] = "error connecting to server";
}

/*
if ($success) {
    if ($stmt->rowCount() < 1) {

        $command = "UPDATE `user`
                    SET `email`=?
                    WHERE `username`=?";
        $stmt = $dbh->prepare($command);
        $params = [$email, $_SESSION['username']];
        $success = $stmt->execute($params);

        if (!$success) {
            $_SESSION['edit_error'] = "error updating username";
        }
    } else {
        $_SESSION['edit_error'] = "username already in use";
    }
} else {
    $_SESSION['edit_error'] = "error connecting to server";
}
*/

header("Location: ../../user.php");