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

$user = filter_input(INPUT_POST, 'user', FILTER_VALIDATE_INT);
$option = filter_input(INPUT_POST, 'option', FILTER_SANITIZE_STRING);

if (!isset($_SESSION['loggedin']) || !isset($_SESSION['id']) || !isset($_SESSION['username']) || !isset($_SESSION['admin'])) {
    session_destroy();
    header("Location: ../../login.php");
    die();
} 
if ($user === null || $user < 1) {
    header("Location: ../customers.php");
    die();
}
if ($option === null || empty($option)) {
    header("Location: ../customers.php");
    die();
}

$command = "";
if ($option == "activate") {
    $command = "UPDATE `user` SET `active`=1 WHERE `id`=?";
} else if ($option == "deactivate") {
    $command = "UPDATE `user` SET `active`=0 WHERE `id`=?";
} else if ($option == "op") {
    $command = "UPDATE `user` SET `admin`=1 WHERE `id`=?";
} else if ($option == "deop") {
    $command = "UPDATE `user` SET `admin`=0 WHERE `id`=?";
} else if ($option == "delete") {
    $command = "DELETE FROM `user` WHERE `id`=?";
}

if (!empty($command)) {
    $stmt = $dbh->prepare($command);
    $params = [$user];
    $success = $stmt->execute($params);
}

header("Location: ../customers.php");