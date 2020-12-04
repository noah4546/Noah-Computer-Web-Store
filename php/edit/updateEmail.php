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

$email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_STRING);

if ($email === null || empty($email)) {
    $_SESSION['edit_error'] = "email is empty";
    header("Location: ../../user.php");
}

$command = "SELECT * FROM `user` WHERE `email`=?";
$stmt = $dbh->prepare($command);
$params = [$email];
$success = $stmt->execute($params);

if ($success) {
    if ($stmt->rowCount() < 1) {

        $command = "UPDATE `user`
                    SET `email`=?
                    WHERE `username`=?";
        $stmt = $dbh->prepare($command);
        $params = [$email, $_SESSION['username']];
        $success = $stmt->execute($params);

        if (!$success) {
            $_SESSION['edit_error'] = "error updating email";
        }
    } else {
        $_SESSION['edit_error'] = "email already in use";
    }
} else {
    $_SESSION['edit_error'] = "error connecting to server";
}

header("Location: ../../user.php");