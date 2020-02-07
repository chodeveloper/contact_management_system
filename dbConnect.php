<?php
function db_connect() {

    // a static connection variable
    static $connection;

    if(!isset($connection)) {
        // connect to the database usind configuration file if a connection has not been established yet
        $config = parse_ini_file('./config.ini'); 
        if (trim(empty($config['dbname'])) || !isset($config['dbname'])) $connection = mysqli_connect($config['servername'], $config['username'], $config['password']);
        else $connection = mysqli_connect($config['servername'], $config['username'], $config['password'], $config['dbname']);
    } 
    if($connection === false) {
        return mysqli_connect_error(); 
    }
    return $connection;
}

// Connect to the database
$connection = db_connect();

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}