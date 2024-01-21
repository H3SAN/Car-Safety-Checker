<?php

// MySQL database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "safety_ratings";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check the MySQL connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

// Select all the year available and put it in a loop
$sql = "SELECT * FROM Year";
$query = mysqli_query($conn, $sql);

	if (mysqli_num_rows($query) !== 0) {
		while ($row = mysqli_fetch_assoc($query)) {
			//Get all the years and place them in a variable
			$year = $row["ModelYear"];
			
			// API URL
			$apiUrl = "https://api.nhtsa.gov/SafetyRatings/modelyear/" .$year. "?format=json";
			
			// Fetch data from the API
			$data = file_get_contents($apiUrl);
			$jsonData = json_decode($data, true);
			
			foreach ($jsonData as $key => $value) {
				if (is_array($value)) {
					foreach ($value as $item) {
						// Assuming theres a table with appropriate columns
						$sql = "INSERT INTO make (ModelYear, Make, VehicleId) VALUES ('" . $year . "', '" . $item['Make'] . "', '" . $item['VehicleId'] . "')";

						// Execute the SQL query
						if ($conn->query($sql) === TRUE) {
							echo "Record has been inserted successfully<br>";
						} else {
							echo "Error inserting record: " . $conn->error . "<br>";
						}
					}
				}
			}
		}
	}
?>