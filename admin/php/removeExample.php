<?php

session_start();

include '../../php/connect.php';

$filter = filter_input(INPUT_GET, 'filter', FILTER_SANITIZE_STRING);

if (!isset($_SESSION['loggedin']) || !isset($_SESSION['id']) || !isset($_SESSION['username']) || !isset($_SESSION['admin'])) {
    session_destroy();
    header("Location: ../../index.php");
    die();
} 

$command = file_get_contents("sql/removeExample.sql");
$stmt = $dbh->prepare($command);
$success = $stmt->execute();