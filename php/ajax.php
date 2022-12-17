<?php
	include("db-conn-data.php");

	$action = isset($_POST["action"]) ? $_POST["action"] : NULL;

	switch($action) {
		case "getPointsPerCanton":
			echo getPointsPerCanton();
			break;
	}

	function getPointsPerCanton() {
		if(!(isset($_POST["educationPoints"])) || !(isset($_POST["jobPoints"])) || !(isset($_POST["safetyPoints"])) || !(isset($_POST["costPoints"]))) {
            return;
        }

        $educationPoints = $_POST["educationPoints"];
        $jobPoints = $_POST["jobPoints"];
        $safetyPoints = $_POST["safetyPoints"];
        $costPoints = $_POST["costPoints"];


        if(!(is_numeric($educationPoints)) || !(is_numeric($jobPoints)) || !(is_numeric($safetyPoints)) || !(is_numeric($costPoints))) {
            return;
        }

        if($educationPoints < 0 || $jobPoints < 0 || $safetyPoints < 0 || $costPoints < 0) {
            return;
        }

        if($educationPoints > 100 || $jobPoints > 100 || $safetyPoints > 100 || $costPoints > 100) {
            return;
        }

        if($educationPoints + $jobPoints + $safetyPoints + $costPoints != 100) {
            return;
        }

        $sql = "CALL getPointsPerKanton(" . $safetyPoints . ", " . $educationPoints . ", " . $jobPoints . ", " . $costPoints . "); ";

        $conn = connectToDB();            
        $result = mysqli_query($conn, $sql) or die("Error in Selecting " . mysqli_error($conn));
        closeDBConnection($conn);

        $i = 0;
        $maxPunkteTotal = 0;
        $returnJSON = '{"cantons": [ ';
       	while($row = mysqli_fetch_assoc($result)) {
            if($i == 0) {
                $punkteTotalProzent = 1;
                $maxPunkteTotal = $row["PunkteTotal"];
                $i++;
            } else {
                $punkteTotalProzent = $row["PunkteTotal"] / $maxPunkteTotal;
            }
       		$returnJSON .= '{"title": "' . $row["KantonKuerzel"] . '", "educationPoints": "' . $row["PunkteBildung"] . ' ", "jobPoints": "' . $row["PunkteArbeit"] . ' ", "safetyPoints": "' . $row["PunkteSicherheit"] . ' ", "costPoints": "' . $row["PunkteKosten"] . '", "totalPoints": "' . $punkteTotalProzent . '"},';
        }
		
		return substr($returnJSON, 0, -1) . "]}";
	}

	function connectToDB() {
        $connection = mysqli_connect(SERVERNAME, USERNAME, PASSWORD, DB_NAME) or die("Error " . mysqli_error($connection));
        mysqli_query($connection, "SET NAMES 'utf8'");
        return $connection;
    }

    function closeDBConnection($conn) {
        mysqli_close($conn);
    }
?>