<?php
require_once 'db_config.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    // If connection failed, end the script
    die("Connection failed: " . $conn->connect_error);
}
?>
