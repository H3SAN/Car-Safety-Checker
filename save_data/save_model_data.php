<?php
ini_set('max_execution_time', 2000);
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
			
			//Second loop to Load the make from the MySQL Data
			$sql2 = "SELECT * FROM make WHERE ModelYear ='" .$year. "'";
			$query2 = mysqli_query($conn, $sql2);
			
			if (mysqli_num_rows($query2) !== 0) {
				while ($row2 = mysqli_fetch_assoc($query2)) {
					$make = $row2["Make"];
					
					echo "Record for " .$make. "<br>";
					
					// API URL
					$apiUrl = "https://api.nhtsa.gov/SafetyRatings/modelyear/" .$year. "/make/" .$make. "?format=json";
			
					// Fetch data from the API
					$data = file_get_contents($apiUrl);
					$jsonData = json_decode($data, true);

					foreach ($jsonData as $key => $value) {
						if (is_array($value)) {
							foreach ($value as $item) {
								// Assuming theres a table with appropriate columns
								$sql = "INSERT INTO model (ModelYear, Make, Model, VehicleId) VALUES ('" . $year . "', '" . $make . "', '" . $item['Model'] . "', '" . $item['VehicleId'] . "')";

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
		}
	}
?>