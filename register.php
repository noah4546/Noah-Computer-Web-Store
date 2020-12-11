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

if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true){
    header("location: user.php");
    exit;
}

require_once "php/connect.php";
require "php/verify.php";

$email_err = "";
$username_err = "";
$password_err = "";
$confirm_password_err = "";

// Checks to see if the form was completed
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
    $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING);
    $confirm_password = filter_input(INPUT_POST, "confirm_password", FILTER_SANITIZE_STRING);

    $verify = verifyEmail($email) && verifyUsername($username) && verifyPasswords($password, $confirm_password);

    // Validate login
    if ($verify) {

        $command = "SELECT * FROM `user` WHERE `username`=?";
        $stmt = $dbh->prepare($command);
        $params = [$username];
        $success = $stmt->execute($params);

        if ($success) {
            if($stmt->rowCount() == 1) {

                $username_err = "Username already in use.";

            } else {
                
                $command = "SELECT * FROM `user` WHERE `email`=?";
                $stmt = $dbh->prepare($command);
                $params = [$email];
                $success = $stmt->execute($params);

                if ($success) {

                    if ($stmt->rowCount() == 1) {
                        $email_err = "Email already in use.";
                    } else {

                        $password_hash = password_hash($password, PASSWORD_DEFAULT);

                        $command = "INSERT INTO `user` (`username`, `password`, `email`) 
                                    VALUES (?, ?, ?);";
                        $stmt = $dbh->prepare($command);
                        $params = [$username, $password_hash, $email];
                        $success = $stmt->execute($params);

                        if ($success) {

                            $command = "SELECT * FROM `user` WHERE `username`=?";
                            $stmt = $dbh->prepare($command);
                            $params = [$username];
                            $success = $stmt->execute($params);

                            $row = $stmt->fetch();
                            $id = $row['id'];
                            $admin = $row['admin'];

                            $_SESSION['loggedin'] = true;
                            $_SESSION['id'] = $id;
                            $_SESSION['username'] = $username;
                            $_SESSION["admin"] = $admin;   

                            if(isset($_SESSION['lookingAt'])) {
                                header("Location: product.php?product=" . $_SESSION['lookingAt']);
                            } else {
                                header("Location: index.php");
                            }
                        } else {
                            $confirm_password_err = "Something went wrong. Please try again later.";
                        }
                    }
                } else {
                    $confirm_password_err = "Something went wrong. Please try again later.";
                }
            }
        } else {
            $confirm_password_err = "Something went wrong. Please try again later.";
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
        <script src='js/register.js'></script>
    </head>
    <body>
        <div class="notice">
            This is not a real shop, none of the products on this site will be shipped or actually sold.
            No payment info will be taken by the user. (<a href="https://tnoah.ca/shop/info.html">More Info</a>)
        </div>
        <main>
            <form id="register_form" action="register.php" method="POST">

                <a href="index.php"><img src="images/logo.png" /></a>
                <h2>Sign Up</h2>

                <input type="email" name="email" id="email" placeholder="Email Adrress" required/>
                <span class="error"><?php echo $email_err ?></span>
                <input type="text" name="username" id="username" placeholder="Username" maxlength="30" minlength="6" required/>
                <span class="error"><?php echo $username_err ?></span>
                <input type="password" name="password" id="password" placeholder="Password" maxlength="30" minlength="8" required/>
                <span class="error"><?php echo $password_err ?></span>
                <input type="password" name="confirm_password" id="confirm_password" placeholder="Comfirm Password" maxlength="30" minlength="8"  required/>
                <span class="error"><?php echo $confirm_password_err ?></span>
                <span class="error" id="error"></span>

                <div class="password-policy">
                    <div class="password-policy-rule"><p>Include the following:</p></div>
                    <div class="password-policy-rule"><p>Must contain:</p></div>
                    <div class="password-policy-rule">
                        <ul>
                            <li id="password_uppercase">ABC</li>
                            <li id="password_lowercase">abc</li>
                            <li id="password_numbers">123</li>
                        </ul>
                    </div>
                    <div class="password-policy-rule"><p id="password_length">8~30 Chars</p></div>
                </div>

                <input type="submit" value="SIGN UP" />

                <h2>Already have an account? <a href="login.php">Sign In</a></h2>
            </form>
        </main>
        <footer>
        
        </footer>
    </body>
</html>