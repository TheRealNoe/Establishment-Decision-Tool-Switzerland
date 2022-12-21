<?php
	include("db-conn-data.php");

	$action = isset($_POST["action"]) ? $_POST["action"] : NULL;

	switch($action) {
		case "getPointsPerCanton":
			echo getPointsPerCanton();
			break;
        case "getTopicData":
            echo getTopicData();
            break;
        case "getRanksPerCanton":
            echo getRanksPerCanton();
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

        $conn = connectToDB();            
        $stmt = $conn->prepare("CALL getPointsPerKanton(?, ?, ?, ?); ");    
        $stmt->bind_param("dddd", $safetyPoints, $educationPoints, $jobPoints, $costPoints);  
        $stmt->execute();
        $result = $stmt->get_result();

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
       		$returnJSON .= '{"kuerzel": "' . $row["KantonKuerzel"] . '", "educationPoints": "' . $row["PunkteBildung"] . ' ", "jobPoints": "' . $row["PunkteArbeit"] . ' ", "safetyPoints": "' . $row["PunkteSicherheit"] . ' ", "costPoints": "' . $row["PunkteKosten"] . '", "totalPoints": "' . $punkteTotalProzent . '"},';
        }
		
		return substr($returnJSON, 0, -1) . "]}";
	}

    function getTopicData() {
        if(!(isset($_POST["topic"]))) {
            return;
        }

        $topic = $_POST["topic"];

        if(is_null($topic)) {
            return $topic;
        }

        switch($topic) {
            case "e":
                $sql = "SELECT (SELECT Kuerzel FROM Kanton AS k WHERE k.ID = sk.Kanton) AS Kanton, Rang, Anzahl AS Kennzahl FROM statistikkantonbildung AS sk ";
                break;
            case "j":
                $sql = "SELECT (SELECT Kuerzel FROM Kanton AS k WHERE k.ID = sk.Kanton) AS Kanton, Rang, Anzahl AS Kennzahl FROM statistikkantonarbeit AS sk ";
                break;
            case "s":
                $sql = "SELECT (SELECT Kuerzel FROM Kanton AS k WHERE k.ID = sk.Kanton) AS Kanton, Rang, Anzahl AS Kennzahl FROM statistikkantonsicherheit AS sk ";
                break;
            case "c":
                $sql = "SELECT (SELECT Kuerzel FROM Kanton AS k WHERE k.ID = sk.Kanton) AS Kanton, Rang, Durchschnittliche_Kosten AS Kennzahl FROM statistikkantonkosten AS sk ";
                break;
        }

        $conn = connectToDB();            
        $result = mysqli_query($conn, $sql) or die("Error in Selecting " . mysqli_error($conn));
        closeDBConnection($conn);

        $returnJSON = '{"cantons": [ ';
        while($row = mysqli_fetch_assoc($result)) {
            $returnJSON .= '{"rang": "' . $row["Rang"] . '", "kuerzel": "' . $row["Kanton"] . '", "kennzahl": "' . $row["Kennzahl"] . '"},';
        }

        return substr($returnJSON, 0, -1) . "]}";
    }

    function getRanksPerCanton(){
        $sql = "SELECT SB.Punkte * (SELECT 10000 / SUM(Punkte) FROM StatistikKantonBildung) As PunkteB, 
            SA.Punkte * (SELECT 10000 / SUM(Punkte) FROM StatistikKantonArbeit) AS PunkteA,
            SS.Punkte * (SELECT 10000 / SUM(Punkte) FROM StatistikKantonSicherheit) AS PunkteS,
            SK.Punkte * (SELECT 10000 / SUM(Punkte) FROM StatistikKantonKosten) AS PunkteK, 
            (SELECT Kuerzel FROM Kanton AS k WHERE k.ID = SB.Kanton) AS Kanton,
            (SELECT AVG(Punkte) * 10000 / SUM(Punkte) FROM StatistikKantonBildung) As AvgB,
            (SELECT AVG(Punkte) * 10000 / SUM(Punkte) FROM StatistikKantonArbeit) As AvgA,
            (SELECT AVG(Punkte) * 10000 / SUM(Punkte) FROM StatistikKantonSicherheit) As AvgS,
            (SELECT AVG(Punkte) * 10000 / SUM(Punkte) FROM StatistikKantonKosten) As AvgK
            FROM StatistikKantonBildung SB JOIN statistikkantonarbeit SA ON SA.Kanton = SB.Kanton JOIN statistikkantonsicherheit SS ON SS.Kanton = SB.Kanton JOIN statistikkantonkosten SK ON SK.Kanton = SB.Kanton;";
        $conn = connectToDB();            
        $result = mysqli_query($conn, $sql) or die("Error in Selecting " . mysqli_error($conn));
        closeDBConnection($conn);

        $returnJSON = '{"cantons": [ ';
        while($row = mysqli_fetch_assoc($result)) {
            $returnJSON .= '{"PunkteB": "' . $row["PunkteB"] . '", "PunkteA": "' . $row["PunkteA"] . '", "PunkteS": "' . $row["PunkteS"] . '", "PunkteK": "' . $row["PunkteK"] . '",  "kuerzel": "' . $row["Kanton"] . '", "AvgB": "' . $row["AvgB"] . '", "AvgA": "' . $row["AvgA"] . '", "AvgS": "' . $row["AvgS"] . '", "AvgK": "' . $row["AvgK"] . '"},';
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