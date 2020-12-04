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

$username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_STRING);

if ($username === null || empty($username)) {
    $_SESSION['edit_error'] = "username is empty";
    header("Location: ../../user.php");
}

$command = "SELECT * FROM `user` WHERE `username`=?";
$stmt = $dbh->prepare($command);
$params = [$username];
$success = $stmt->execute($params);

if ($success) {
    if ($stmt->rowCount() < 1) {

        $command = "UPDATE `user`
                    SET `username`=?
                    WHERE `username`=?";
        $stmt = $dbh->prepare($command);
        $params = [$username, $_SESSION['username']];
        $success = $stmt->execute($params);

        if ($success) {

            $_SESSION['username'] = $username;

        } else {
            $_SESSION['edit_error'] = "error updating username";
        }
    } else {
        $_SESSION['edit_error'] = "username already in use";
    }
} else {
    $_SESSION['edit_error'] = "error connecting to server";
}

header("Location: ../../user.php");