<?php

// Read the JSON file content
$jsonFile = 'database/year.json';
$jsonData = file_get_contents($jsonFile);

// Decode the JSON data as an array
$data = json_decode($jsonData, true);

// Check if decoding was successful
if (is_array($data)) {
    // Display each entry
    echo "<select>";
    foreach ($data as $entry) {
        echo "<option>Name:" . $entry['ModelYear'] . "<option>";
    }
    echo "</select>";
} else {
    echo "Error decoding JSON file.";
}

?>

