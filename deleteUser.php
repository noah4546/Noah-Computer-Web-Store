<?php
/**
 * Noah Tomkins, 000790079
 * 
 * Noah Computers Webstore
 * 
 * Created: 27/10/2020
 * I, Noah Tomkins, 000790079 certify that this material is my original work.  
 * No other person's work has been used without due acknowledgement.
 */
session_start();

if (!isset($_SESSION['loggedin']) || !isset($_SESSION['id']) || !isset($_SESSION['username']) || !isset($_SESSION['admin'])) {
    session_destroy();
    header("Location: login.php");
}

require_once "php/connect.php";
require "php/verify.php";

$password_err = "";
$confirm_password_err = "";
$id = $_SESSION['id'];

// Checks to see if the form was completed
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING);
    $password_confirm = filter_input(INPUT_POST, "confirm_password", FILTER_SANITIZE_STRING);

    $paramsok = true;
    if ($password === null || empty($password)) {
        $password_err = "Please enter password.";
        $paramsok = false;
    }
    if ($password_confirm === null || empty($password_confirm)) {
        $confirm_password_err = "Please enter password.";
        $paramsok = false;
    }

    // Validate login
    if ($paramsok) {
       if ($password == $password_confirm) {

            $command = "SELECT * FROM `user` WHERE `id`=?";
            $stmt = $dbh->prepare($command);
            $params = [$id];
            $success = $stmt->execute($params);

            if ($success) {
                if ($stmt->rowCount() == 1) {
                    $row = $stmt->fetch();
                    $hashed_password = $row['password'];

                    if (password_verify($password, $hashed_password)) {

                        $command = "DELETE FROM `user` WHERE `id`=?";
                        $stmt = $dbh->prepare($command);
                        $params = [$id];
                        $success = $stmt->execute($params);

                        if ($success) {
                            session_destroy();
                            header("Location: index.php");
                            die();
                        } else {
                            $confirm_password_err = "Error deleting user, please try again";
                        }
                    } else {
                        $confirm_password_err = "Passwords are incorrect";
                    }
                } else {
                    $confirm_password_err = "Could not find user, please try again";
                }
            } else {
                $confirm_password_err = "Error connecting to server, please try again";
            }
       } else {
            $confirm_password_err = "Passwords don't match";
       }
    }
}


?><!DOCTYPE html>
<html lang='en'>
    <head>
        <title>Noah Computers</title>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>

        <link rel='stylesheet' href='css/global.css'>
        <link rel='stylesheet' href='css/login.css'>
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    </head>
    <body>
        <div class="notice">
            This is not a real shop, none of the products on this site will be shipped or actually sold.
            No payment info will be taken by the user. (<a href="https://tnoah.ca/shop/info.html">More Info</a>)
        </div>
        <main>
            <form id="register_form" action="deleteUser.php" method="POST">

                <a href="index.php"><img src="images/logo.png" /></a>
                <h2>Delete User</h2>
                <h3>Enter your password twice to confirm</h3>

                <input type="password" name="password" id="password" placeholder="Password" maxlength="20" minlength="8" required/>
                <span class="error"><?php echo $password_err ?></span>
                <input type="password" name="confirm_password" id="confirm_password" placeholder="Comfirm Password" maxlength="30" minlength="8"  required/>
                <span class="error"><?php echo $confirm_password_err ?></span>
                <span class="error" id="error"></span>

                <input type="submit" value="DELTE USER" />

                <h2>Mistake? <a href="user.php">Go Back</a></h2>
            </form>
        </main>
        <footer>
        
        </footer>
    </body>
</html>