<html>
	<head>
		<title>Switzerland Establishment Decision Tool</title>
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">
		<link rel="stylesheet" href="libs/MDB5-STANDARD-UI-KIT-Free-5.0.0/css/mdb.dark.min.css">
		<link rel="stylesheet" type="text/css" href="libs/DataTables/datatables.min.css"/>
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
	                            <a class="nav-link" href="#section-home">Home</a>
	                        </li>
	                        <li class="nav-item">
	                            <a class="nav-link" href="#section-manual">Manual</a>
	                        </li>
	                        <li class="nav-item">
	                            <a class="nav-link" href="#section-go-for-it">Go for it!</a>
	                        </li>
	                    </ul>
	                </div>
	            </div>
	        </nav>
			<div id="section-home">
	            <img id="header-image" src="res/background.jpg"/>
	            <div id="header-text">
	                <div class="container col-8">
	                    <div id="header-titles" class="text-center">
	                        <h3 class="display-3 fw-bold text-black">Establishment Decision Tool</h3>
	                        <h6 class="display-6 text-primary">Switzerland</h6>
	                    </div>
	                </div>
	            </div>
        	</div>
		</header>
		<section class="spacer" style="height: 5px;"></section>
		<section id="section-manual" class="py-5">
			<div class="container">
				<h1 class="h1-responsive text-center mb-5">Manual</h1>
				<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>

				<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>

				<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>
			</div>
		</section>
		<section class="spacer" style="height: 30px;"></section>
		<section id="section-go-for-it" class="py-5">
			<div class="container mb-8">
				<h1 class="h1-responsive text-center mb-5">Go for it!</h1>
				<form id="inputForm">
					<div class="row d-flex justify-content-center">
						<p class="fw-bold text-center">
							<span>Points to distribute:</span>
							<span id="pointsToDistribute" class="text-primary">0</span>
						<p>
						<div class="col-md-6 col-sm-10">
							<div class="form-outline mb-4">
								<input type="number" id="input-education" class="form-control input-points" min="0" max="100" step="1" autocomplete="off" value="25" required/>
								<label class="form-label" for="input-education">Education</label>
							</div>
							<div class="form-outline mb-4">
								<input type="number" id="input-jobs" class="form-control input-points" min="0" max="100" step="1" autocomplete="off" value="25" required/>
								<label class="form-label" for="input-jobs">Job offer</label>
							</div>
							<div class="form-outline mb-4">
								<input type="number" id="input-safety" class="form-control input-points" min="0" max="100" step="1" autocomplete="off" value="25" required/>
								<label class="form-label" for="input-safety">Safety</label>
							</div>
							<div class="form-outline mb-4">
								<input type="number" id="input-costs" class="form-control input-points" min="0" max="100" step="1" autocomplete="off" value="25" required/>
								<label class="form-label" for="input-costs">Living costs</label>
							</div>
							<button type="submit" class="btn btn-primary btn-block">Search</button>
						</div>
					</div>
				</form>
			</div>
			<div class="container mt-8" id="container-table-results">
				<table class="table" id="table-results">
					<thead>
						<tr>
							<th class="fw-bold">Kanton</th>
							<th class="fw-bold">Total</th>
							<th class="fw-bold">Education</th>
							<th class="fw-bold">Job offer</th>
							<th class="fw-bold">Safety</th>
							<th class="fw-bold">Living costs</th>
							<th class="no-sort"></th>
							<th class="no-sort"></th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>
		</section>
		<section id="section-go-for-it" class="py-5 mb-5">
			<div class="container">
				<h1 class="h1-responsive text-center mb-5">Developed by</h1>
				<div class="row">
					<div class="col-4 text-center">
						<i class="fas fa-user-tie mb-3" style="font-size: 100px; color: #ffffff1F;"></i><br>
						<span class="text-white fw-bold">Akilsan Skathakumar</span>
					</div>
					<div class="col-4 text-center">
						<i class="fas fa-user-tie mb-3" style="font-size: 100px; color: #ffffff1F;"></i><br>
						<span class="text-white fw-bold">Benjamin Anthamatten</span>
					</div>
					<div class="col-4 text-center">
						<i class="fas fa-user-tie mb-3" style="font-size: 100px; color: #ffffff1F;"></i><br>
						<span class="text-white fw-bold">Noe Aufdenblatten</span>
					</div>
				</div>
			</div>
		</section>
		<section id="notificationContainer"></section>
		<section id="blockUILoader">
			<img id="preloader-gif" src="res/preloader.gif"/>
		</section>
		<hr>
		<footer>
			<div class="row pt-4 pb-4">
				<div class="col"></div>
				<div class="col-6 col-md-2 col-sm-4 text-center hslu-logo-container">
					<a href="https://hslu.ch">
						<img class="hslu-logo" src="res/hslu-logo-w.png">
					</a>
				</div>
				<div class="col"></div>
			</div>
		</footer>
	</body>
	<script type="text/javascript" src="libs/jQuery-v3.6.1/jquery-3.6.1.min.js"></script>
	<script type="text/javascript" src="libs/MDB5-STANDARD-UI-KIT-Free-5.0.0/js/mdb.min.js"></script>
	<script type="text/javascript" src="libs/DataTables/datatables.min.js"></script>
	<script type="text/javascript" src="libs/blockUI/jquery.blockUI.js"></script>
	<script type="text/javascript" src="libs/ChartJS/chart.js"></script>
	<script type="text/javascript" src="js/script.js"></script>
</html>