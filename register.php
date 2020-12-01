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

    if ($email === null || empty($email)) {
        $email_err = "Please enter username.";
    }
    if ($username === null || empty($username)) {
        $username_err = "Please enter username.";
    }
    if ($password === null || empty($password)) {
        $password_err = "Please enter password.";
    }
    if ($confirm_password === null || empty($confirm_password)) {
        $confirm_password_err = "Please confirm password.";
    }

    if (strlen($username) < 6 || strlen($username) > 50) {
        $username_err = "Username must be 6~30 Chars";
    }

    if ($password != $confirm_password) {
        $confirm_password_err = "Passwords do not match.";
    }

    $containsUppercase = preg_match('/[A-Z]/', $password);
    $containsLowercase = preg_match('/[a-z]/', $password);
    $containsDigit = preg_match('/\d/', $password);
    $containsSpecial = preg_match('/[^a-zA-z\d]/',$password);
    $containsAll = $containsUppercase && $containsLowercase && $containsDigit && $containsSpecial;

    if (!$containsAll) {
        $confirm_password_err = "Password does not contain all of the rules";
    }

    if (strlen($password) < 8 || strlen($password) > 30) {
        $confirm_password_err = "Password must be 6~30 Chars";
    }

    // Validate login
    if (empty($email_err) && empty($username_err) && empty($password_err) && empty($confirm_password_err)) {

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

                            $_SESSION['loggedin'] = true;
                            $_SESSION['id'] = $id;
                            $_SESSION['username'] = $username;

                            header("Location: index.php");
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
        
        <script src='js/main.js'></script>
    </head>
    <body>
        <main>
            <form action="register.php" method="POST">

                <h1>Noah Computers</h1>
                <h2>Sign Up</h2>

                <input type="email" name="email" placeholder="Email Adrress" required/>
                <span class="error"><?php echo $email_err ?></span>
                <input type="text" name="username" placeholder="Username" maxlength="30" minlength="6" required/>
                <span class="error"><?php echo $username_err ?></span>
                <input type="password" name="password" placeholder="Password" maxlength="30" minlength="8" required/>
                <span class="error"><?php echo $password_err ?></span>
                <input type="password" name="confirm_password" placeholder="Comfirm Password" maxlength="30" minlength="8"  required/>
                <span class="error"><?php echo $confirm_password_err ?></span>

                <div class="password-policy">
                    <div class="password-policy-rule"><p>Include the following:</p></div>
                    <div class="password-policy-rule"><p>Must contain:</p></div>
                    <div class="password-policy-rule">
                        <ul>
                            <li>ABC</li>
                            <li>abc</li>
                            <li>123</li>
                            <li>@#$</li>
                        </ul>
                    </div>
                    <div class="password-policy-rule"><p>8~30 Chars</p></div>
                </div>

                <input type="submit" value="SIGN UP" />

                <h2>Already have an account? <a href="login.php">Sign In</a></h2>
            </form>
        </main>
        <footer>
        
        </footer>
    </body>
</html>