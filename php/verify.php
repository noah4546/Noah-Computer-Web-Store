<?php

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

    function verifyPasswords($passwordA, $passwordB) {

        if ($passwordA != $passwordB) {
            return false;
        }

        if (verifyPassword($passwordA) && verifyPassword($passwordB)) {
            return true;
        }

        return false;

    }

    function verifyUsername($username) {

        if ($username === null || empty($username)) {
            return 0;
        }
        if (strlen($username) < 6 || strlen($username) > 50) {
            return 0;
        }

        return 1;
    }

    function verifyEmail($email) {

        if ($email === null || empty($email)) {
            return false;
        }

        return true;
    }