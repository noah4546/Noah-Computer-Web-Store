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

?><!DOCTYPE html>
<html lang='en'>
    <head>
        <title>Noah Computers</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="../js/main.js"></script>
    </head>
    <body>
        <h1>
        <?php 
        if ($success) {
            echo "Successfully disabled the example prodcuts!";
        } else {
            echo "Failed disabling the example prodcuts, please try again";
        } 
        ?>
        </h1>
        <h3><a href="../index.php">GO BACK</a></h3>
    </body>
</html>