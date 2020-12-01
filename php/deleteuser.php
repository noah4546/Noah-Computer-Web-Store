<?php

require_once 'connect.php';

session_start();

if (isset($_SESSION['id'])) {

    $command = "DELETE FROM `user` WHERE `id`=?";
    $stmt = $dbh->prepare($command);
    $params = [$_SESSION['id']];
    $success = $stmt->execute($params);

    if ($success) {
        session_destroy();
    }
    header("Location: ../index.php");
}