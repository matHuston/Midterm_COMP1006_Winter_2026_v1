<?php
$host = "localhost"; //hostname
$db = "event_manager"; //database name
$user = "root"; //username
$password = ""; //password

//points to the database mysql server (driver), database name, username and password
$dsn = "mysql:host=$host;dbname=$db";

// connection try and catch block to handle errors during connection, echo successful connection message or error message
try {
    $pdo = new PDO($dsn, $user, $password);
    //set the error mode to exception so that we can catch any errors that occur during the connection process
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
// output error message and stop script on catch
catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}