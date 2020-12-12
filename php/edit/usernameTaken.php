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

require_once '../connect.php';

$username = filter_input(INPUT_GET, "username", FILTER_SANITIZE_STRING);

if ($username === null || empty($username)) {
    echo "Username is empty";
} else {
    $command = "SELECT * FROM `user` WHERE `username`=?";
    $stmt = $dbh->prepare($command);
    $params = [$username];
    $success = $stmt->execute($params);

    if ($success) {
        if ($stmt->rowCount() > 0) {
            echo "Username already taken.";
        } else {
            echo "1";
        }
    } else {
        echo "Server error, please try again later.";
    }
}



