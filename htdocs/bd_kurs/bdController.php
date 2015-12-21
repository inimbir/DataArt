<?php
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname= "bd_kurs";
	$conn = new mysqli($servername, $username, $password, $dbname);
	$conn->query("SET CHARACTER SET 'utf8';");

	if(isset($_GET['getUsertype'])) {
		session_start();
		echo $_SESSION['usertype'];
	}

	if(isset($_GET['loadJournal'])) {
		$res = $conn->query("SELECT * FROM journal");
		$rows = array();
		while($r = mysqli_fetch_assoc($res)) {
			$rows[] = $r;
		}
		echo json_encode($rows);
	}

	if(isset($_GET['getPersons'])) {
		$res=$conn->query("SELECT idPerson, personName FROM historicperson");
		$rows = array();
		while($r = mysqli_fetch_assoc($res)) {
			$rows[] = $r;
		}
		echo json_encode($rows);
	}

	if(isset($_GET['getStates'])) {
		$res=$conn->query("SELECT idState, stateName FROM states");
		$rows = array();
		while($r = mysqli_fetch_assoc($res)) {
			$rows[] = $r;
		}
		echo json_encode($rows);
	}

	//блок стран

	if(isset($_GET['loadStates'])) {
		$res = $conn->query("SELECT * FROM states");
		$rows = array();
		while($r = mysqli_fetch_assoc($res)) {
			if (is_null($r['terminationYear'])) $r['terminationYear']="---";
			$rows[] = $r;
		}
		echo json_encode($rows);
	}

	if(isset($_GET['deleteState'])) {
		session_start();
		$res = $conn->query("SELECT stateName FROM states WHERE idState={$_GET['id']}");
		$r = $res->fetch_row();
		$conn->query("INSERT INTO journal (username ,text) VALUES ('{$_SESSION['username']}', ' удалил данные о стране. ({$r[0]})')");
		$conn->query("DELETE FROM states WHERE idState={$_GET['id']}");
	}

	if(isset($_GET['getState'])) {
		$res=$conn->query("SELECT * FROM states WHERE idState={$_GET['id']}");
		echo json_encode($res->fetch_row());
	}

	if(isset($_GET['editState'])) {
		session_start();
		$res = $conn->query("SELECT * FROM states WHERE stateName='{$_GET['Name']}'");
		$r=$res->fetch_row();
		if ($res->num_rows == 0 || $r[1]==$_GET['Name']) {
			if ($_GET['TY'] == 0) $conn->query("UPDATE states SET stateName='{$_GET['Name']}', foundationYear={$_GET['SY']}, terminationYear=NULL, capitalCity='{$_GET['Capital']}' WHERE idState={$_GET['id']}");
			else $conn->query("UPDATE states SET stateName='{$_GET['Name']}', foundationYear='{$_GET['SY']}', terminationYear='{$_GET['TY']}', capitalCity='{$_GET['Capital']}' WHERE idState={$_GET['id']}");
			$conn->query("INSERT INTO journal (username ,text) VALUES ('{$_SESSION['username']}', ' изменил данные о стране. ({$_GET['Name']})')");
			echo 1;
		}
		else echo -1;
	}

	if(isset($_GET['addState'])) {
		session_start();
		$res = $conn->query("SELECT * FROM states WHERE stateName='{$_GET['Name']}'");
		if ($res->num_rows == 0) {
			if ($_GET['TY']==0) $conn->query("INSERT INTO states (stateName, foundationYear, terminationYear, capitalCity) VALUES ('{$_GET['Name']}', '{$_GET['SY']}',NULL, '{$_GET['Capital']}')");
			else $conn->query("INSERT INTO states (stateName, foundationYear, terminationYear, capitalCity) VALUES ('{$_GET['Name']}', '{$_GET['SY']}','{$_GET['TY']}', '{$_GET['Capital']}')");
			$conn->query("INSERT INTO journal (username ,text) VALUES ('{$_SESSION['username']}', ' добавил данные о стране. ({$_GET['Name']})')");
			echo 1;
		}
		else echo -1;
	}

	//конец блока стран
	//блок исторических личностей

	if(isset($_GET['loadPersons'])) {
		$res = $conn->query("SELECT * FROM historicperson");
		$rows = array();
		while($r = mysqli_fetch_assoc($res)) {
			if (is_null($r['deathYear'])) $r['deathYear']="---";
			$rows[] = $r;
		}
		echo json_encode($rows);
	}

	if(isset($_GET['addPerson'])) {
		session_start();
		$res = $conn->query("SELECT * FROM historicperson WHERE personName='{$_GET['Name']}'");
		if ($res->num_rows == 0) {
			if ($_GET['DY']==0) $conn->query("INSERT INTO historicperson (personName, birthYear, deathYear, birthCity) VALUES ('{$_GET['Name']}', '{$_GET['BY']}',NULL, '{$_GET['City']}')");
			else $conn->query("INSERT INTO historicperson (personName, birthYear, deathYear, birthCity) VALUES ('{$_GET['Name']}', '{$_GET['BY']}', '{$_GET['DY']}', '{$_GET['City']}')");
			$conn->query("INSERT INTO journal (username ,text) VALUES ('{$_SESSION['username']}', ' добавил данные об исторической личности. ({$_GET['Name']})')");
			echo 1;
		}
		else echo -1;
	}

	if(isset($_GET['getPerson'])) {
		$res=$conn->query("SELECT * FROM historicperson WHERE idPerson={$_GET['id']}");
		echo json_encode($res->fetch_row());
	}

	if(isset($_GET['editPerson'])) {
		session_start();
		$res = $conn->query("SELECT * FROM historicperson WHERE personName='{$_GET['Name']}'");
		$r=$res->fetch_row();
		if ($res->num_rows == 0 || $r[1]==$_GET['Name']) {
			if ($_GET['DY'] == 0) $conn->query("UPDATE historicperson SET personName='{$_GET['Name']}', birthYear={$_GET['BY']}, deathYear=NULL, birthCity='{$_GET['City']}' WHERE idPerson={$_GET['id']}");
			else $conn->query("UPDATE historicperson SET personName='{$_GET['Name']}', birthYear='{$_GET['BY']}', deathYear='{$_GET['DY']}', birthCity='{$_GET['City']}' WHERE idPerson={$_GET['id']}");
			$conn->query("INSERT INTO journal (username ,text) VALUES ('{$_SESSION['username']}', ' изменил данные об исторической личности. ({$_GET['Name']})')");
			echo 1;
		}
		else echo -1;
	}

	if(isset($_GET['deletePerson'])) {
		session_start();
		$res = $conn->query("SELECT personName FROM historicperson WHERE idPerson={$_GET['id']}");
		$r = $res->fetch_row();
		$conn->query("INSERT INTO journal (username ,text) VALUES ('{$_SESSION['username']}', ' удалил данные об исторической личности. ({$r[0]})')");
		$conn->query("DELETE FROM historicperson WHERE idPerson={$_GET['id']}");
	}

	//конец исторических личностей
	//блок правлений

	if(isset($_GET['loadGovernment'])) {
		$res = $conn->query("SELECT * FROM government");
		$rows = array();
		while($r = mysqli_fetch_assoc($res)) {
			if (is_null($r['endYear'])) $r['endYear']="---";
			$personName = $conn->query("SELECT personName FROM historicperson WHERE idPerson={$r['idPerson']}");
			$r['personName']=mysqli_fetch_assoc($personName)['personName'];
			$stateName = $conn->query("SELECT stateName FROM states WHERE idState={$r['idState']}");
			$r['stateName']=mysqli_fetch_assoc($stateName)['stateName'];
			$rows[] = $r;
		}
		echo json_encode($rows);
	}

	if(isset($_GET['getYears'])) {
		$res = $conn->query("SELECT foundationYear, terminationYear FROM states WHERE idState={$_GET['idState']}");
		echo json_encode(mysqli_fetch_assoc($res));
	}

	if(isset($_GET['addGovernment'])) {
		session_start();
		$conn->query("INSERT INTO government (idPerson, idState, startYear, endYear) VALUES ({$_GET['idPerson']}, {$_GET['idState']}, {$_GET['SG']}, {$_GET['FG']})");
		$res = $conn->query("SELECT personName FROM historicPerson WHERE idPerson={$_GET['idPerson']}");
		$pname = $res->fetch_row();
		$res = $conn->query("SELECT stateName FROM states WHERE idState={$_GET['idState']}");
		$sname = $res->fetch_row();
		$conn->query("INSERT INTO journal (username ,text) VALUES ('{$_SESSION['username']}', ' добавил данные о правлении. ({$pname[0]} - {$sname[0]})')");
		echo 1;
	}

	if(isset($_GET['deleteGovernment'])) {
		session_start();
		$res = $conn->query("SELECT personName FROM historicPerson WHERE idPerson={$_GET['idPerson']}");
		$pname = $res->fetch_row();
		$res = $conn->query("SELECT stateName FROM states WHERE idState={$_GET['idState']}");
		$sname = $res->fetch_row();
		$conn->query("INSERT INTO journal (username ,text) VALUES ('{$_SESSION['username']}', ' удалил данные о правлении. ({$pname[0]} - {$sname[0]})')");
		$conn->query("DELETE FROM government WHERE idPerson={$_GET['idPerson']} AND idState={$_GET['idState']} AND startYear={$_GET['startYear']} AND endYear={$_GET['endYear']}");
	}

	//конец правлений
	//блок исторических событий

	if(isset($_GET['loadEvents'])) {
		$res = $conn->query("SELECT * FROM historicevent");
		$rows = array();
		while($r = mysqli_fetch_assoc($res)) {
			$rows[] = $r;
		}
		echo json_encode($rows);
	}

	if(isset($_GET['addEvent'])) {
		session_start();
		$res = $conn->query("SELECT * FROM historicevent WHERE eventName='{$_GET['Name']}'");
		if ($res->num_rows == 0) {
			$conn->query("INSERT INTO historicevent (eventName, type, description, startYear, endYear) VALUES ('{$_GET['Name']}', '{$_GET['Type']}', '{$_GET['Desc']}' , '{$_GET['SY']}', '{$_GET['EY']}')");
			$conn->query("INSERT INTO journal (username ,text) VALUES ('{$_SESSION['username']}', ' добавил данные об историческом событии. ({$_GET['Name']})')");
			echo 1;
		}
		else echo -1;
	}

	if(isset($_GET['deleteEvent'])) {
		session_start();
		$res = $conn->query("SELECT eventName FROM historicevent WHERE idEvent={$_GET['id']}");
		$r = $res->fetch_row();
		$conn->query("INSERT INTO journal (username ,text) VALUES ('{$_SESSION['username']}', ' удалил данные об историческом событии. ({$r[0]})')");
		$conn->query("DELETE FROM historicevent WHERE idEvent={$_GET['id']}");
	}
	//конец исторических событий
	//блок битв
	if(isset($_GET['loadBattles'])) {
		$res = $conn->query("SELECT * FROM battle");
		$rows = array();
		while($r = mysqli_fetch_assoc($res)) {
			$personName = $conn->query("SELECT eventName FROM historicevent WHERE idEvent={$r['idEvent']}");
			$r['eventName']=mysqli_fetch_assoc($personName)['eventName'];
			$rows[] = $r;
		}
		echo json_encode($rows);
	}

	if(isset($_GET['getWars'])) {
		$res = $conn->query("SELECT * FROM historicevent WHERE type=1");
		$rows = array();
		while($r = mysqli_fetch_assoc($res)) {
			$personName = $conn->query("SELECT eventName FROM historicevent WHERE idEvent={$r['idEvent']}");
			$r['eventName']=mysqli_fetch_assoc($personName)['eventName'];
			$rows[] = $r;
		}
		echo json_encode($rows);
	}

	if(isset($_GET['addBattle'])) {
		session_start();
		$res = $conn->query("SELECT * FROM battle WHERE idEvent={$_GET['idEvent']} AND battlename='{$_GET['Name']}'");
		if ($res->num_rows==0) {
			$conn->query("INSERT INTO battle (idEvent, battlename, battleyear) VALUES ({$_GET['idEvent']}, '{$_GET['Name']}', {$_GET['Year']})");
			$conn->query("INSERT INTO journal (username ,text) VALUES ('{$_SESSION['username']}', ' добавил данные о битве. ({$_GET['Name']})')");
			echo 1;
		}
		else echo -1;
	}

	if(isset($_GET['getYearsForWar'])) {
		$res = $conn->query("SELECT startYear, endYear FROM historicevent WHERE idEvent={$_GET['idEvent']}");
		echo json_encode(mysqli_fetch_assoc($res));
	}

	if(isset($_GET['deleteBattle'])) {
		session_start();
		$res = $conn->query("SELECT battleName FROM battle WHERE idBattle={$_GET['id']}");
		$r = $res->fetch_row();
		$conn->query("INSERT INTO journal (username ,text) VALUES ('{$_SESSION['username']}', ' удалил данные о битве. ({$r[0]})')");
		$conn->query("DELETE FROM battle WHERE idBattle={$_GET['id']}");
	}
	//конец битв
	//блок участников событий
	if(isset($_GET['loadEventPart'])) {
		$res = $conn->query("SELECT * FROM historiceventparticipant");
		$rows = array();
		while($r = mysqli_fetch_assoc($res)) {
			$personName = $conn->query("SELECT eventName FROM historicevent WHERE idEvent={$r['idEvent']}");
			$r['eventName']=mysqli_fetch_assoc($personName)['eventName'];
			$personName = $conn->query("SELECT personName FROM historicperson WHERE idPerson={$r['idPerson']}");
			$r['personName']=mysqli_fetch_assoc($personName)['personName'];
			$rows[] = $r;
		}
		echo json_encode($rows);
	}

	if(isset($_GET['getEvents'])) {
		$res = $conn->query("SELECT idEvent, eventName FROM historicevent");
		$rows = array();
		while ($r = mysqli_fetch_assoc($res)){
			$rows[] = $r;
		}
		echo json_encode($rows);
	}

	if(isset($_GET['addEventPart'])) {
		session_start();
		$res = $conn->query("SELECT * FROM historiceventparticipant WHERE idEvent={$_GET['idEvent']} AND idPerson='{$_GET['idPerson']}'");
		if ($res->num_rows==0) {
			$conn->query("INSERT INTO historiceventparticipant (idEvent, idPerson) VALUES ({$_GET['idEvent']}, {$_GET['idPerson']})");
			$conn->query("INSERT INTO journal (username ,text) VALUES ('{$_SESSION['username']}', ' добавил данные об участнике событий. ({$_GET['eventName']} - {$_GET['personName']})')");
			echo 1;
		}
		else echo -1;
	}

	if(isset($_GET['deleteEventPart'])) {
		session_start();
		$conn->query("INSERT INTO journal (username ,text) VALUES ('{$_SESSION['username']}', ' удалил данные об участнике событий.')");
		$conn->query("DELETE FROM historiceventparticipant WHERE idPerson={$_GET['idPerson']} AND idEvent={$_GET['idEvent']}");
	}
	//конец участников событий
	//блок участников битв
	if(isset($_GET['loadBattleParts'])) {
		$res = $conn->query("SELECT * FROM governmentparticipant");
		$rows = array();
		while($r = mysqli_fetch_assoc($res)) {
			$personName = $conn->query("SELECT stateName FROM states WHERE idState={$r['idState']}");
			$r['stateName']=mysqli_fetch_assoc($personName)['stateName'];
			$personName = $conn->query("SELECT battlename FROM battle WHERE idBattle={$r['idBattle']}");
			$r['battlename']=mysqli_fetch_assoc($personName)['battlename'];
			$rows[] = $r;
		}
		echo json_encode($rows);
	}

	if(isset($_GET['addBattlePart'])) {
		session_start();
		$res = $conn->query("SELECT * FROM governmentparticipant WHERE idState={$_GET['idState']} AND idBattle='{$_GET['idBattle']}'");
		if ($res->num_rows==0) {
			$res = $conn->query("SELECT battleName FROM battle WHERE idBattle={$_GET['idBattle']}");
			$r = $res->fetch_row();
			$conn->query("INSERT INTO governmentparticipant (idState, idBattle, troopsnumber, lossesnumber) VALUES ({$_GET['idState']}, {$_GET['idBattle']}, {$_GET['troopsnumber']}, {$_GET['lossesnumber']})");
			$conn->query("INSERT INTO journal (username ,text) VALUES ('{$_SESSION['username']}', ' добавил данные об участнике битвы. ({$r[0]})')");
			echo 1;
		}
		else echo -1;
	}

	if(isset($_GET['deleteBattlePart'])) {
		session_start();
		$res = $conn->query("SELECT battleName FROM battle WHERE idBattle={$_GET['idBattle']}");
		$r = $res->fetch_row();
		$conn->query("INSERT INTO journal (username ,text) VALUES ('{$_SESSION['username']}', ' удалил данные об участнике битвы. ({$r[0]})')");
		$conn->query("DELETE FROM governmentparticipant WHERE idState={$_GET['idState']} AND idBattle={$_GET['idBattle']}");
	}
?>