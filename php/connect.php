<?php
/**
 * Include this to connect. Change the dbname to match your database,
 * and make sure your login information is correct after you upload 
 * to csunix or your app will stop working.
 * 
 * Sam Scott, Mohawk College, 2019
 */
try {
    $dbh = new PDO(
        "mysql:host=localhost;dbname=000790079",
        "000790079",
        "20010801"
    );

    /**
     * To make sure the encoding is set to utf8 by default
     * this command is ran, in versions proir to PHP 5.3.6
     * this is broken and you must manualy set it.
     * 
     * This only becomes an issue for me because I am storing
     * raw html on the database in the manner of product pages,
     * on the product pages they allow for an adminastator to 
     * create there own descrtipion in any fasion they would like
     * using their own custom html.
     */
    $dbh->exec("set names utf8");
} catch (Exception $e) {
    die("ERROR: Couldn't connect. {$e->getMessage()}");
}
