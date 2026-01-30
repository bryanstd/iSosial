<?php
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'isosial_db';

$connection = new mysqli($host, $username, $password, $database);

if ($connection->connect_error) {
    die("Failed to connect to db: " . $connection->connect_error);
}

return $connection;
?>