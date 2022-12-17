<?php
	include("db-conn-data.php");
?>
<html>
	<head>
		<title>Switzerland Establishment Decision Tool</title>
		<link rel="stylesheet" type="text/css" href="../css/style.css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">
		<link rel="stylesheet" href="../libs/MDB5-STANDARD-UI-KIT-Free-5.0.0/css/mdb.dark.min.css">
		<link rel="stylesheet" type="text/css" href="../libs/DataTables/datatables.min.css"/>
	</head>
	<body>
		<header>
			<nav class="navbar navbar-dark bg-dark navbar-expand-lg navbar-dark fixed-top">
	            <div class="container">
	                <button class="navbar-toggler" data-mdb-toggle="collapse" data-mdb-target="#navbarMenu" aria-expanded="false">
    					<i class="fas fa-bars"></i>
					</button>
	                <div class="collapse navbar-collapse" id="navbarMenu">
	                	<a class="navbar-brand fw-bold text-primary" href="#">DBS-Project</a>
	                    <ul class="navbar-nav">
	                        <li class="nav-item">
	                            <a class="nav-link" href="../index.php">Home</a>
	                        </li>
	                    </ul>
	                </div>
	            </div>
	        </nav>
			<div id="section-home">
	            <img id="header-image" src="../res/background.jpg"/>
	            <div id="header-text">
	                <div class="container col-8">
	                    <div id="header-titles" class="text-center">
	                        <h3 class="display-3 fw-bold text-black">Details</h3>
	                        <h6 class="display-6 text-primary"><?=$_GET["canton"]?></h6>
	                    </div>
	                </div>
	            </div>
        	</div>
		</header>
		<section class="spacer" style="height: 30px;"></section>
		<section id="section-details" class="py-5">
			<div class="container mb-8">
				<h1 class="h1-responsive text-center mb-5">Ranking without user evaluation</h1>
				<table class="table">
					<thead>
						<tr>
							<th class="fw-bold">Topic</th>
							<th class="fw-bold">Rank</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<?php
							$connection = mysqli_connect(SERVERNAME, USERNAME, PASSWORD, DB_NAME) or die("Error " . mysqli_error($connection));
							mysqli_query($connection, "SET NAMES 'utf8'");
							
							$stmt = $connection->prepare("SELECT Rang FROM StatistikKantonBildung WHERE Kanton = (SELECT ID FROM Kanton WHERE Kuerzel LIKE ?); ");    
							$stmt->bind_param("s", $_GET["canton"]);  
							$stmt->execute();
							$result = $stmt->get_result(); 
						    $row = mysqli_fetch_row($result);
						    $rankEducation = $row[0];

						    $stmt = $connection->prepare("SELECT Rang FROM StatistikKantonArbeit WHERE Kanton = (SELECT ID FROM Kanton WHERE Kuerzel LIKE ?); ");    
							$stmt->bind_param("s", $_GET["canton"]);  
							$stmt->execute();
							$result = $stmt->get_result(); 
						    $row = mysqli_fetch_row($result);
						    $rankJob = $row[0];

						    $stmt = $connection->prepare("SELECT Rang FROM StatistikKantonSicherheit WHERE Kanton = (SELECT ID FROM Kanton WHERE Kuerzel LIKE ?); ");    
							$stmt->bind_param("s", $_GET["canton"]);  
							$stmt->execute();
							$result = $stmt->get_result(); 
						    $row = mysqli_fetch_row($result);
						    $rankSafety = $row[0];

						    $stmt = $connection->prepare("SELECT Rang FROM StatistikKantonKosten WHERE Kanton = (SELECT ID FROM Kanton WHERE Kuerzel LIKE ?); ");    
							$stmt->bind_param("s", $_GET["canton"]);  
							$stmt->execute();
							$result = $stmt->get_result(); 
						    $row = mysqli_fetch_row($result);
						    $rankCosts = $row[0];

						    mysqli_close($connection);
					   ?>
						<tr>
							<td>Education</td>
							<td><?=$rankEducation?></td>
							<td style="text-align: right;">
								<a class="btn text-white" style="padding: 5px; background-color: #3B71CA;" onclick="showDataTable('e');" role="button">
									<i class="far fa-eye"></i>
								</a>
							</td>
						</tr>
						<tr>
							<td>Job offer</td>
							<td><?=$rankJob?></td>
							<td style="text-align: right;">
								<a class="btn text-white" style="padding: 5px; background-color: #3B71CA;" onclick="showDataTable('j');" role="button">
									<i class="far fa-eye"></i>
								</a>
							</td>
						</tr>
						<tr>
							<td>Safety</td>
							<td><?=$rankSafety?></td>
							<td style="text-align: right;">
								<a class="btn text-white" style="padding: 5px; background-color: #3B71CA;" onclick="showDataTable('s');" role="button">
									<i class="far fa-eye"></i>
								</a>
							</td>
						</tr>
						<tr>
							<td>Living costs</td>
							<td><?=$rankCosts?></td>
							<td style="text-align: right;">
								<a class="btn text-white" style="padding: 5px; background-color: #3B71CA;" onclick="showDataTable('c');" role="button">
									<i class="far fa-eye"></i>
								</a>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</section>
		<section id="section-details-table" class="py-5">
			<div class="container mb-8">
				<h1 class="h1-responsive text-center mb-5" id="topicDataTitle"></h1>
				<table class="table" id="table-topic-data">
					<thead>
						<tr>
							<th class="fw-bold">Rank</th>
							<th class="fw-bold">Canton</th>
							<th class="fw-bold" id="value-description"></th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>
		</section>
		<section id="notificationContainer"></section>
		<section id="blockUILoader">
			<img id="preloader-gif" src="../res/preloader.gif"/>
		</section>
		<hr>
		<footer>
			<div class="row pt-4 pb-4">
				<div class="col"></div>
				<div class="col-6 col-md-2 col-sm-4 text-center hslu-logo-container">
					<a href="https://hslu.ch">
						<img class="hslu-logo" src="../res/hslu-logo-w.png">
					</a>
				</div>
				<div class="col"></div>
			</div>
		</footer>
	</body>
	<script type="text/javascript" src="../libs/jQuery-v3.6.1/jquery-3.6.1.min.js"></script>
	<script type="text/javascript" src="../libs/MDB5-STANDARD-UI-KIT-Free-5.0.0/js/mdb.min.js"></script>
	<script type="text/javascript" src="../libs/DataTables/datatables.min.js"></script>
	<script type="text/javascript" src="../libs/blockUI/jquery.blockUI.js"></script>
	<script type="text/javascript" src="../js/script_detail.js"></script>
</html>