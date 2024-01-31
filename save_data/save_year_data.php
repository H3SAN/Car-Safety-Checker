<?php

// MySQL database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "safety_ratings";

// API URL
$apiUrl = 'https://api.nhtsa.gov/SafetyRatings/?format=json';

// Fetch data from the API
$data = file_get_contents($apiUrl);
$jsonData = json_decode($data, true);

// Check if the data is successfully fetched
if ($jsonData) {
    // Create a MySQL connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check the MySQL connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Process and save data to the MySQL database
    foreach ($jsonData as $key => $value) {
        if (is_array($value)) {
            foreach ($value as $item) {
                // Assuming you have a table named 'Year' with appropriate columns
                $sql = "INSERT INTO Year (ModelYear, VehicleId) VALUES ('" . $item['ModelYear'] . "', '" . $item['VehicleId'] . "')";

                // Execute the SQL query
                if ($conn->query($sql) === TRUE) {
                    echo "Record inserted successfully<br>";
                } else {
                    echo "Error inserting record: " . $conn->error . "<br>";
                }
            }
        }
    }

    // Close the MySQL connection
    $conn->close();
} else {
    echo "Failed to fetch data from the API.";
}

?>