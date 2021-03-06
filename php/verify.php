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

    /**
     * Verrifes the password given
     * 
     * @param $password
     */
    function verifyPassword($password) {

        if ($password === null || empty($password)) {
            return false;
        }

        $containsUppercase = preg_match('/[A-Z]/', $password);
        $containsLowercase = preg_match('/[a-z]/', $password);
        $containsDigit = preg_match('/\d/', $password);
        //$containsSpecial = preg_match('/[^a-zA-z\d]/',$password);
        $containsAll = $containsUppercase && $containsLowercase && $containsDigit;// && $containsSpecial;

        if (!$containsAll) {
            return false;
        }
        if (strlen($password) < 8 || strlen($password) > 30) {
            return false;
        }

        return true;
    }

    /**
     * Verifies two passwords make sure they
     * are the same and each in correct format
     */
    function verifyPasswords($passwordA, $passwordB) {

        if ($passwordA != $passwordB) {
            return false;
        }

        if (verifyPassword($passwordA) && verifyPassword($passwordB)) {
            return true;
        }

        return false;

    }

    /**
     * verifies username
     */
    function verifyUsername($username) {

        if ($username === null || empty($username)) {
            return 0;
        }
        if (strlen($username) < 6 || strlen($username) > 20) {
            return 0;
        }

        return 1;
    }

    /**
     * verifies email
     */
    function verifyEmail($email) {

        if ($email === null || empty($email)) {
            return false;
        }

        return true;
    }