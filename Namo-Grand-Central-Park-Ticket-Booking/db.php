<?php

// Define your database connection parameters
$dbhost = 'localhost';
$dbuser = 'u654573886_namogrand'; // Your database username
$dbpass = 'L3~VfbG#vXb$'; // Your database password
$dbname = 'u654573886_namogrand'; // Your database name

// Create a connection to the database
$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

// Check the connection
if (!$conn) {
    die('Could not connect: ' . mysqli_error());
}

// You are now connected to the "aquaspla_brainpowerdb" database.

?>