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

$username_err = "";
$password_err = "";

// Checks to see if the form was completed
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING);

    $paramsok = true;
    if ($username === null || empty($username)) {
        $username_err = "Please enter username.";
        $paramsok = false;
    }
    if ($password === null || empty($password)) {
        $password_err = "Please enter password.";
        $paramsok = false;
    }

    // Validate login
    if (empty($username_err) && empty($password_err)) {

        $command = "SELECT * FROM `user` WHERE `username`=?";
        $stmt = $dbh->prepare($command);
        $params = [$username];
        $success = $stmt->execute($params);

        if ($success) {
            if($stmt->rowCount() == 1) {

                $row = $stmt->fetch();

                $id = $row["id"];
                $username = $row["username"];
                $admin = $row["admin"];
                $hashed_password = $row["password"];

                if (password_verify($password, $hashed_password)) {

                    session_start();

                    

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
                    $password_err = "Password is invalid";
                }
            } else {
                $username_err = "No user found with that username.";
            }
        } else {
            $password_err = "Something went wrong. Please try again later.";
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
        <script src='js/main.js'></script>
    </head>
    <body>
        <div class="notice">
            This is not a real shop, none of the products on this site will be shipped or actually sold.
            No payment info will be taken by the user. (<a href="https://tnoah.ca/shop/info.html">More Info</a>)
        </div>
        <main>
            <form action="login.php" method="POST">

                <a href="index.php"><img src="images/logo.png" /></a>
                <h2>Sign In</h2>

                <input type="text" name="username" placeholder="Username" required/>
                <span class="error"><?php echo $username_err ?></span>
                <input type="password" name="password" placeholder="Password" required/>
                <span class="error"><?php echo $password_err ?></span>
                <input type="submit" value="SIGN IN" />

                <h2>New to Noah Computers? <a href="register.php">Sign Up</a></h2>
            </form>
        </main>
        <footer>
        
        </footer>
    </body>
</html>