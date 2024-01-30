<?php

header('Content-Type: application/json');

require_once 'db_connect.php';

// Define the JSON templates for each table
$tables = ['Products'];
$templates = [];

foreach ($tables as $table) {
    $templateJson = file_get_contents(strtolower($table) . '_template.json');
    $templates[$table] = json_decode($templateJson);
}

// Fetch data from each table
foreach ($tables as $table) {
    $sql = "SELECT * FROM $table";
    $result = $conn->query($sql);

    // Check if the query was successful
    if ($result instanceof mysqli_result) {
        // Output data of each row
        while($row = $result->fetch_assoc()) {
            $tempObj = clone $templates[$table]; // Clone the template
            foreach($row as $key => $value) {
                if(property_exists($tempObj, $key)) {
                    $tempObj->$key = $value; // Populate the template
                }
            }
            $json_array[$table][] = $tempObj;
        }
    } else {
        echo "0 results for $table query";
    }
}


echo json_encode($json_array, JSON_PRETTY_PRINT); // Add JSON_PRETTY_PRINT here

$conn->close();
?>
