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
		<section class="spacer" style="height: 30px;"></section>
		<section id="section-go-for-it" class="py-5">
			<div class="container mb-8">
				<h1 class="h1-responsive text-center mb-5">Go for it!</h1>
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
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>
		</section>
		<section id="notificationContainer"></section>
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
	<script type="text/javascript" src="../libs/jQuery-v3.6.1/jquery-3.6.1.min.js"></script>
	<script type="text/javascript" src="../libs/MDB5-STANDARD-UI-KIT-Free-5.0.0/js/mdb.min.js"></script>
	<script type="text/javascript" src="../js/script_detail.js"></script>
</html>