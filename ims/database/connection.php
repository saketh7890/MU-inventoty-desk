<?php

$servername = 'localhost';
$username = 'root';
$password = ''; // <-- Provide your database password here

// Connecting to database
try {
    $conn = new PDO("mysql:host=$servername;dbname=project_data", $username, $password);
    
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    //echo "Connected Successfully.";
} catch (PDOException $e) {
    // If an exception occurs, catch it and handle it here
    echo "Connection failed: " . $e->getMessage();
}

?>
