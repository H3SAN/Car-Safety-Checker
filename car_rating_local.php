<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>EMU - Car Safety Rating</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800">NHTSA Car Safety Specification</h1>
					
					<p class="mb-4">Search for the car type and model to reveal the specifications for safety</a>.</p>

                    <!-- Content Row -->
                    <div class="row">
						<div class="col-xl-12 col-lg-7">
						<!-- Question form -->
							<div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Search form</h6>
                                </div>
                                <div class="card-body">
                                    <form class="user">
										<div class="form-group row">
											<div class="form-group col-lg-4">
												<label for="role">Select the Year:</label>
												<?php
													// Read the JSON file content
													$jsonYear = 'database/year.json';
													$jsonData = file_get_contents($jsonYear);

													// Decode the JSON data as an array
													$data = json_decode($jsonData, true);
												?>
												<select class="form-select form-control" id="yearSelect" name="year">
												<?php
													// Check if decoding was successful
													if (is_array($data)) {
														// Display each entry
														foreach ($data as $entry) {
															echo "<option>" . $entry['ModelYear'] . "</option>";
														}
													} else {
														echo "Error decoding JSON file.";
													}
													?>
												</select>
											</div>
											<div class="form-group col-lg-4">
												<label for="role">Select the Brand:</label>
												<select class="form-select form-control" id="brandSelect" name="brand">

												</select>
											</div>
											<div class="form-group col-lg-4">
												<label for="role">Select the Model:</label>
												<select class="form-select form-control" id="modelSelect" name="model">
													<option>---</option>
												</select>
											</div>
											<input type="text" hidden id="vehicleId" readonly>
										</div>
										<div class="form-group justify-content-center row">
											<a class="btn btn-primary" onclick="fetchAndDisplayData()">Display Data</a>
										</div>
									</form>
                                </div>
                            </div>
							
							<!-- Results card -->
							<div id="result" class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Results</h6>
                                </div>
                                <div class="card-body">
                                    <form class="user">
										<div class="form-group row p-3">
											<div class="col-sm-6 mb-3 mb-sm-0">
												<div class="text-left">
													<img id="apiImage" class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 25rem;" alt="...">
												</div>
											</div>
											<div class="col-sm-6 mb-3 mb-sm-0">
												<p class="h3 mb-4 text-gray-800" id="make"></p>
												<p class="h3 mb-4 text-gray-800" id="year"></p>
												<p class="h3 mb-4 text-gray-800" id="model"></p>
												<div class="col-sm-7 mb-4" id="starRating">
													<p class="h3 text-gray-800" id="model">Overall Rating</p>
													<i id="star1" style="color: orange;" class="fas fa-star fa-lg ratecolor"></i>
													<i id="star2" style="color: orange;" class="fas fa-star fa-lg ratecolor"></i>
													<i id="star3" style="color: orange;" class="fas fa-star fa-lg ratecolor"></i>
													<i id="star4" style="color: orange;" class="fas fa-star fa-lg ratecolor"></i>
													<i id="star5" style="color: orange;" class="fas fa-star fa-lg ratecolor"></i>
												</div>
											</div>
										</div>
										<div class="form-group justify-content-center row">
											<div class="rating col-sm-4 mb-3 row">
												<label for="staticEmail" class="col-sm-5 col-form-label" id="model">Overall Front Crash Rating:</label>
												<p class="mb-4 text-gray-800 py-2" id="OverallRating"></p>
											</div>
											<div class="rating col-sm-4 mb-3 row">
												<label for="staticEmail" class="col-sm-5 col-form-label" id="model">Front Crash Driver side Rating:</label>
												<p class="mb-4 text-gray-800 py-2" id="FrontCrashDriversideRating"></p>
											</div>
											<div class="rating col-sm-4 mb-3 row">
												<label for="staticEmail" class="col-sm-5 col-form-label" id="model">Front Crash Passenger side Rating:</label>
												<p class="mb-4 text-gray-800 py-2" id="FrontCrashPassengersideRating"></p>
											</div>
											<div class="rating col-sm-4 mb-3 row">
												<label for="staticEmail" class="col-sm-5 col-form-label" id="model">Overall Side Crash Rating:</label>
												<p class="mb-4 text-gray-800 py-2" id="OverallSideCrashRating"></p>
											</div>
											<div class="rating col-sm-4 mb-3 row">
												<label for="staticEmail" class="col-sm-5 col-form-label" id="model">Side Crash Driver side Rating:</label>
												<p class="mb-4 text-gray-800 py-2" id="SideCrashDriversideRating"></p>
											</div>
											<div class="rating col-sm-4 mb-3 row">
												<label for="staticEmail" class="col-sm-5 col-form-label" id="model">Side Crash Passenger side Rating:</label>
												<p class="mb-4 text-gray-800 py-2" id="SideCrashPassengersideRating"></p>
											</div>
											<div class="rating col-sm-4 mb-3 row">
												<label for="staticEmail" class="col-sm-5 col-form-label" id="model">Roll-over Rating:</label>
												<p class="mb-4 text-gray-800 py-2" id="RolloverRating"></p>
											</div>
											<div class="rating col-sm-4 mb-3 row">
												<label for="staticEmail" class="col-sm-5 col-form-label" id="model">Roll-over Rating 2:</label>
												<p class="mb-4 text-gray-800 py-2" id="RolloverRating2"></p>
											</div>
											<div class="rating col-sm-4 mb-3 row">
												<label for="staticEmail" class="col-sm-5 col-form-label" id="model">Roll-over Possibility:</label>
												<p class="mb-4 text-gray-800 py-2" id="RolloverPossibility"></p>
											</div>
											<div class="rating col-sm-4 mb-3 row">
												<label for="staticEmail" class="col-sm-5 col-form-label" id="model">Roll-over Possibility 2:</label>
												<p class="mb-4 text-gray-800 py-2" id="RolloverPossibility2"></p>
											</div>
											<div class="rating col-sm-4 mb-3 row">
												<label for="staticEmail" class="col-sm-5 col-form-label" id="model">dynamic Tip Result:</label>
												<p class="mb-4 text-gray-800 py-2" id="dynamicTipResult"></p>
											</div>
											<div class="rating col-sm-4 mb-3 row">
												<label for="staticEmail" class="col-sm-5 col-form-label" id="model">Side Pole Crash Rating:</label>
												<p class="mb-4 text-gray-800 py-2" id="SidePoleCrashRating"></p>
											</div>
											<div class="rating col-sm-4 mb-3 row">
												<label for="staticEmail" class="col-sm-5 col-form-label" id="model">NHTSA Electronic Stability Control:</label>
												<p class="mb-4 text-gray-800 py-2" id="NHTSAElectronicStabilityControl"></p>
											</div>
											<div class="rating col-sm-4 mb-3 row">
												<label for="staticEmail" class="col-sm-5 col-form-label" id="model">NHTSA Forward Collision Warning:</label>
												<p class="mb-4 text-gray-800 py-2" id="NHTSAForwardCollisionWarning"></p>
											</div>
											<div class="rating col-sm-4 mb-3 row">
												<label for="staticEmail" class="col-sm-5 col-form-label" id="model">NHTSA Lane Departure Warning:</label>
												<p class="mb-4 text-gray-800 py-2" id="NHTSALaneDepartureWarning"></p>
											</div>
											<div class="rating col-sm-4 mb-3 row">
												<label for="staticEmail" class="col-sm-5 col-form-label" id="model">Complaints Count:</label>
												<p class="mb-4 text-gray-800 py-2" id="ComplaintsCount"></p>
											</div>
											<div class="rating col-sm-4 mb-3 row">
												<label for="staticEmail" class="col-sm-5 col-form-label" id="model">Recalls Count:</label>
												<p class="mb-4 text-gray-800 py-2" id="RecallsCount"></p>
											</div>
											<div class="rating col-sm-4 mb-3 row">
												<label for="staticEmail" class="col-sm-5 col-form-label" id="model">Investigation Count:</label>
												<p class="mb-4 text-gray-800 py-2" id="InvestigationCount"></p>
											</div>
										</div>
									</form>
                                </div>
                            </div>
						</div>
					</div>
					</div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
	<style>
	#resultuu {
		display: none;
	}
	.ratecolor {
	  color: orange;
	  display: none;
	}
	</style>

    <!-- Core plugin JavaScript -->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>
	
	<script>
	// Fetch JSON data based on the selected year
	function fetchDataBasedOnYear(year) {
		fetch('database/data_' + year + '.json')
			.then(response => response.json())
			.then(data => {
				// Populate the new select with JSON data
				var newSelect = document.getElementById('newSelect');
				newSelect.innerHTML = ''; // Clear previous options

				data.forEach(entry => {
					var option = document.createElement('option');
					option.value = entry.id;
					option.text = entry.name;
					newSelect.appendChild(option);
				});
			})
			.catch(error => console.error('Error fetching or parsing JSON:', error));
	}

	// Add event listener to yearSelect dropdown
	var yearSelect = document.getElementById('yearSelect');
	yearSelect.addEventListener('change', function() {
		var selectedYear = yearSelect.value;
		fetchDataBasedOnYear(selectedYear);
	});

	// Initial population based on the default selected year
	fetchDataBasedOnYear(yearSelect.value);
	</script>
</body>

</html>

