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

require_once 'php/connect.php';

if (!isset($_SESSION['loggedin']) || !isset($_SESSION['id']) || !isset($_SESSION['username']) || !isset($_SESSION['admin'])) {
    session_destroy();
    header("Location: login.php");
} 

$edit_error = "";
if (isset($_SESSION['edit_error'])) {
    $edit_error = $_SESSION['edit_error'] . ", please try again";
    unset($_SESSION['edit_error']);
}

$loggedin = $_SESSION['loggedin'];
$id = $_SESSION['id'];
$admin = $_SESSION['admin'];
?><!DOCTYPE html>
<html lang='en'>
    <head>
        <title>Noah Computers</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="stylesheet" href="css/global.css">
        <link rel="stylesheet" href="css/header.css">
        <link rel="stylesheet" href="css/user.css">
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="js/main.js"></script>
        <script src="js/user.js"></script>
        <script src="js/editUser.js"></script>
    </head>
    <body>
        <header>
            <div class="notice">
                This is not a real shop, none of the products on this site will be shipped or actually sold.
                No payment info will be taken by the user. (<a href="https://tnoah.ca/shop/info.html">More Info</a>)
            </div>
            <div class="header">
                <div class="header-logo">
                    <a href="index.php"><img class="logo" src="images/logo.png" /></a>
                </div>
                <div class="header-search">
                    <form action="search.php" method="GET">
                        <input type="search" name="search" id="search" placeholder="Search All Products"/>
                        <input type="image" src="images/search.png" />
                    </form>
                </div>
                <div>
                    <a href="user.php" class="header-user">
                        <div class="header-user-image"><img src="images/default_user.png" /></div>
                        <div>Welcome</div>
                        <div class="header-user-name"><?php
                            if ($loggedin && isset($_SESSION['username'])) {
                                echo $_SESSION['username'];
                            } else {
                                echo "Sign in / Register";
                                session_destroy();
                            }
                        ?></div>
                    </a> 
                </div>
                <div class="header-cart">
                    <a href="cart.php"><img src="images/cart.png" /></a>
                </div>
            </div>
        </header>
        <main>
            <div class="user-options">
                <div>
                    <h2><a href="php/logout.php">Logout</a></h2>
                </div>
                <div>
                    <h2><a href="deleteuser.php">Delete user</a></h2>
                </div>
                <div>
                    <h2><a href="orderhistory.php">Order History</a></h2>
                </div>
                <?php if($admin == 1) { ?>
                    <div>
                        <h2><a href="admin">Admin</a></h2>
                    </div>
                <?php } ?>
            </div>
            <div class="user-info">
                <p class="error-text"><?php echo $edit_error ?></p>
                <div id="user_info">
                    <table>
                        <col style="width: 10%">
                        <col style="width: auto">
                        <col style="width: 100px">
                        <tr>
                            <td>Username</td>
                            <td>
                                <div id="current_username"></div>
                                <form action="php/edit/updateUsername.php" method="POST" class="edit-form" id="form_username" style="display: none">
                                    <label for="username">New username: </label>
                                    <input type="text" name="username" id="username" maxlength="20" minlength="6" required/>
                                    <input type="submit" value="Update" />
                                </form>
                            </td>
                            <td>
                                <button type="button" id="edit_username">Edit</button>
                            </td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td>
                                <div id="current_email"></div>
                                <form action="php/edit/updateEmail.php" method="POST" id="form_email" style="display: none">
                                <label for="email">New email: </label>
                                    <input type="email" name="email" id="email" required/>
                                    <input type="submit" value="Update" />
                                </form>
                            </td>
                            <td>
                                <button type="button" id="edit_email" class="edit-button">Edit</button>
                            </td>
                        </tr>
                        <tr>
                            <td>Password</td>
                            <td>
                                <div id="current_password">********</div>
                                <form action="php/edit/updatePassword.php" method="POST" id="form_password" style="display: none">
                                    <label for="current_pass">Current password: </label>
                                    <input type="password" name="current_password" id="current_pass" required/>
                                    <label for="new_password">New password: </label>
                                    <input type="password" name="new_password" id="new_password" required/>
                                    <label for="confirm_password">Confirm new password: </label>
                                    <input type="password" name="confirm_password" id="confirm_password" required/>
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

                                    <input type="submit" value="Update" />
                                </form>
                            </td>
                            <td>
                                <button type="button" id="edit_password" class="edit-button">Edit</button>
                            </td>
                        </tr>
                        <tr>
                            <td>Address</td>
                            <td>
                                <div id="current_address"></div>
                                <form action="php/edit/updateAddress.php" method="POST" id="form_address" style="display: none">
                                    <label for="full_name">Full Name: </label>
                                    <input type="text" name="full_name" id="full_name" required/>
                                    <label for="street_address">Street address: </label>
                                    <input type="text" name="street_address" id="street_address" required/>
                                    <label for="city">City: </label>
                                    <input type="text" name="city" id="city" required/>
                                    <label for="province">Province: </label>
                                    <input type="text" name="province" id="province" required/>
                                    <label for="postal">Postal Code: </label>
                                    <input type="text" name="postal" id="postal" maxlength="6" minlength="6" placeholder="L7R3T5" required/>
                                    <input type="submit" value="Update" />
                                </form>
                            </td>
                            <td>
                                <button type="button" id="edit_address" class="edit-button">Edit</button>
                            </td>
                        </tr>
                        <tr>
                            <td>Created</td>
                            <td id="created"></td>
                            <td></td>
                        </tr>
                    </table>
                </div>
            </div>
        </main>
        <footer>
        
        </footer>
    </body>
</html>