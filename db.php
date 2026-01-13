<?php

function getDbConnection()
{
    static $conn = null;

    if($conn === null) {
        $hostname = 'localhost';
        $username = 'vicfly5850';
        $password = 'Password1';
        $dbname = '310project';

        $conn = mysqli_connect($hostname, $username, $password, $dbname);

        if (!$conn) {
            die("Database connection failed: " . mysqli_connect_error());
        }
    }
    return $conn;
}