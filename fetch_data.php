<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "silkskull";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    // If connection failed, end the script
    die("Connection failed: " . $conn->connect_error);
}

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

// Define the JSON templates for each table
$tables = ['Products'];
$templates = [];

foreach ($tables as $table) {
    $templateJson = file_get_contents(strtolower($table) . '_template.json');
    $templates[$table] = json_decode($templateJson);
}

$json_array = []; // Initialize the array

$sort = 'ASC';
if (isset($_GET['sort']) && strtoupper($_GET['sort']) == 'DESC') {
    $sort = 'DESC';
}

// Fetch data from each table
foreach ($tables as $table) {
    $sql = "SELECT * FROM $table ORDER BY price $sort";
    $result = $conn->query($sql);

    // Check if the query was successful
    if ($result instanceof mysqli_result) {
        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            $tempObj = clone $templates[$table]; // Clone the template
            foreach ($row as $key => $value) {
                if (property_exists($tempObj, $key)) {
                    // Convert numeric values
                    if ($key == 'id') {
                        $value = intval($value);
                    } elseif ($key == 'price') {
                        $value = floatval($value);
                    }
                    $tempObj->$key = $value; // Populate the template
                }
            }
            $json_array[] = $tempObj; // Append the object directly to the array
        }
    } else {
        echo "0 results for $table query";
    }
}

// Check the request URI and filter the array accordingly
if (isset($_GET['type']) && $_GET['type'] == 'categories') {
    $json_array = array_map(function($item) {
        return $item->category;
    }, $json_array);
}

echo json_encode($json_array); // Add JSON_PRETTY_PRINT here

$conn->close();
?>
