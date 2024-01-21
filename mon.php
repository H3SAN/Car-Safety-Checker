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

$sql = "SELECT * FROM `model`";
$query = mysqli_query($conn, $sql);

	if (mysqli_num_rows($query) !== 0) {
		while ($row = mysqli_fetch_assoc($query)) {
			//Get all the years and place them in a variable
			$vid = $row["VehicleId"];
			$id = $row["id"];
			
			$sub3 = substr($vid, 3, 1);
			if ($sub3 == NULL || $sub3 == "]") {
				echo "store 3 digit number</br>";
				$vid3 = substr($vid, 0, 3);
				$sql2 = "UPDATE `model` SET `VehicleId` = '".$vid3."' WHERE `id` = '".$id."'";
				if ($conn->query($sql2) === TRUE) {
					echo "Record details inserted successfully<br>";
					echo "New String: ".$vid3."</br>";
				} else {
					echo "Error inserting record: " . $conn->error . "<br>";
				}
			} 
			else if($sub3 >= 0) {
				echo "more than 3 Digit number</br>";
				$sub4 = substr($vid, 4, 1);
				if ($sub4 == NULL || $sub4 == "]") {
					echo "store 4 digit number</br>";
					$vid4 = substr($vid, 0, 4);
					$sql3 = "UPDATE `model` SET `VehicleId` = '".$vid4."' WHERE `id` = '".$id."'";
					if ($conn->query($sql3) === TRUE) {
						echo "Record details inserted successfully<br>";
						echo "New String: ".$vid4."</br>";
					} else {
						echo "Error inserting record: " . $conn->error . "<br>";
					}
				} 
				else if($sub4 >= 0) {
					echo "more than 4 Digit number</br>";
					$sub5 = substr($vid, 5, 1);
					if ($sub5 == NULL||$sub5 == "]") {
						echo "store 5 digit number</br>";
						$vid5 = substr($vid, 0, 5);
						$sql4 = "UPDATE `model` SET `VehicleId` = '".$vid5."' WHERE `id` = '".$id."'";
						if ($conn->query($sql4) === TRUE) {
							echo "Record details inserted successfully<br>";
							echo "New String: ".$vid5."</br>";
						} else {
							echo "Error inserting record: " . $conn->error . "<br>";
						}
					}
				}
			}
		}
	}
?>