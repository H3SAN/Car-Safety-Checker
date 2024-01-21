<?php
ini_set('max_execution_time', 45000);
// Re-Add 7765 and 7766
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
$sql = "SELECT model.* FROM model LEFT JOIN car_review ON model.VehicleId = car_review.VehicleId WHERE car_review.VehicleId IS NULL";
$query = mysqli_query($conn, $sql);

	if (mysqli_num_rows($query) !== 0) {
		while ($row = mysqli_fetch_assoc($query)) {
			//Get all the years and place them in a variable
			$vid = $row["VehicleId"];
			
			// If the Details of the vehicle exists, then skip it
			$check = "SELECT * FROM `car_review` WHERE `VehicleId` = ".$vid."";
			$queryty = mysqli_query($conn, $check);
			if (mysqli_num_rows($queryty) !== 0) {
                    echo "Record Already Exists<br>";
            }
			else {
				// API URL
				$apiUrl = "https://api.nhtsa.gov/SafetyRatings/VehicleId/" .$vid. "?format=json";
				
				// Fetch data from the API
				$data = file_get_contents($apiUrl);
				$jsonData = json_decode($data, true);
				
				foreach ($jsonData as $key => $value) {
					if (is_array($value)) {
						foreach ($value as $item) {
							// Assuming theres a table with appropriate columns
							$sql2 = "INSERT INTO `car_review` (`id`, `VehiclePicture`, `FrontCrashVideo`, `OverallRating`, `OverallFrontCrashRating`, `FrontCrashDriversideRating`,
							`FrontCrashPassengersideRating`, `OverallSideCrashRating`, `SideCrashDriversideRating`, `SideCrashPassengersideRating`,
							`combinedSideBarrierAndPoleRating-Front`, `combinedSideBarrierAndPoleRating-Rear`, `sideBarrierRating-Overall`, `RolloverRating`,
							`RolloverRating2`, `RolloverPossibility`, `RolloverPossibility2`, `dynamicTipResult`, `SidePoleCrashRating`,
							`NHTSAElectronicStabilityControl`, `NHTSAForwardCollisionWarning`, `NHTSALaneDepartureWarning`, `ComplaintsCount`,
							`RecallsCount`, `InvestigationCount`, `ModelYear`, `Make`, `Model`, `VehicleDescription`, `VehicleId`) 
							VALUES (NULL, '".$item['VehiclePicture']."', '".$item['FrontCrashVideo']."', '".$item['OverallRating']."', '".$item['OverallFrontCrashRating']."', '".$item['FrontCrashDriversideRating']."', '".$item['FrontCrashPassengersideRating']."'
							, '".$item['OverallSideCrashRating']."', '".$item['SideCrashDriversideRating']."', '".$item['SideCrashPassengersideRating']."', '".$item['combinedSideBarrierAndPoleRating-Front']."'
							, '".$item['combinedSideBarrierAndPoleRating-Rear']."', '".$item['sideBarrierRating-Overall']."', '".$item['RolloverRating']."', '".$item['RolloverRating2']."', '".$item['RolloverPossibility']."'
							, '".$item['RolloverPossibility2']."', '".$item['dynamicTipResult']."', '".$item['SidePoleCrashRating']."'
							, '".$item['NHTSAElectronicStabilityControl']."', '".$item['NHTSAForwardCollisionWarning']."', '".$item['NHTSALaneDepartureWarning']."'
							, '".$item['ComplaintsCount']."', '".$item['RecallsCount']."', '".$item['InvestigationCount']."', '".$item['ModelYear']."', '".$item['Make']."'
							, '".$item['Model']."', '".$item['VehicleDescription']."', '".$item['VehicleId']."')";

							// Execute the SQL query
							if ($conn->query($sql2) === TRUE) {
								echo "Record details inserted successfully<br>";
							} else {
								echo "Error inserting record: " . $conn->error . "<br>";
							}
						}
					}
				}
			}
		}
	}
?>