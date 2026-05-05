<?php

function isosial_db_connection(): mysqli
{
    static $connection = null;

    if ($connection instanceof mysqli) {
        return $connection;
    }

    $host = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'isosial_db';

    $connection = new mysqli($host, $username, $password, $database);

    if ($connection->connect_error) {
        die("Failed to connect to db: " . $connection->connect_error);
    }

    return $connection;
}
