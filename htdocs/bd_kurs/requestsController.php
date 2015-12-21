<?php
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname= "bd_kurs";
	$conn = new mysqli($servername, $username, $password, $dbname);
	$conn->query("SET CHARACTER SET 'utf8';");

	if(isset($_GET['get1'])) {
		session_start();
		$res = $conn->query("SELECT personName, eventName
		FROM historicperson T1
		LEFT JOIN historiceventparticipant T2
		ON T1.idPerson=T2.idPerson
		LEFT JOIN historicevent T3
		ON T2.idEvent=T3.idEvent
		WHERE personName='{$_GET['condition']}'
		ORDER BY eventName
		");
		if ($res->num_rows==0) echo -1;
		else {
			while ($r = $res->fetch_row()) echo $r[1] . ", ";
		}
	}

	if(isset($_GET['get2'])) {
		session_start();
		$res = $conn->query("SELECT stateName, personName
		FROM states T1
		LEFT JOIN government T2
		ON T1.idState=T2.idState
		LEFT JOIN historicperson T3
		ON T2.idPerson=T3.idPerson
		WHERE stateName='{$_GET['condition']}'
		ORDER BY personName");
		if ($res->num_rows==0) echo -1;
		else {
			while ($r = $res->fetch_row()) echo $r[1] . ", ";
		}
	}

	if(isset($_GET['get3'])) {
		session_start();
		$res = $conn->query("SELECT personName
		FROM historicperson
		WHERE personName
		LIKE '{$_GET['condition']}%'
		");
		if ($res->num_rows==0) echo -1;
		else {
			while ($r = $res->fetch_row()) echo $r[0] . ", ";
		}
	}

	if(isset($_GET['get4'])) {
		session_start();
		$res = $conn->query("SELECT stateName
		FROM states
		WHERE stateName
		LIKE '{$_GET['condition']}%'
		");
		if ($res->num_rows==0) echo -1;
		else {
			while ($r = $res->fetch_row()) echo $r[0] . ", ";
		}
	}

	if(isset($_GET['get5'])) {
		session_start();
		$res = $conn->query("SELECT eventName
		FROM historicevent
		WHERE startYear BETWEEN {$_GET['condition1']} AND {$_GET['condition2']}
		");
		if ($res->num_rows==0) echo -1;
		else {
			while ($r = $res->fetch_row()) echo $r[0] . ", ";
		}
	}

	if(isset($_GET['get6'])) {
		session_start();
		$res = $conn->query("SELECT battlename
		FROM battle
		WHERE battleyear BETWEEN {$_GET['condition1']} AND {$_GET['condition2']}
		");
		if ($res->num_rows==0) echo -1;
		else {
			while ($r = $res->fetch_row()) echo $r[0] . ", ";
		}
	}

	if(isset($_GET['get7'])) {
		session_start();
		$res = $conn->query("SELECT COUNT(*) FROM battle WHERE battleyear BETWEEN {$_GET['condition1']} AND {$_GET['condition2']}");
		if ($res->num_rows==0) echo -1;
		echo $res->fetch_row()[0];
	}

	if(isset($_GET['get8'])) {
		session_start();
		$res = $conn->query("SELECT COUNT(*) FROM historicperson WHERE birthYear BETWEEN {$_GET['condition1']} AND {$_GET['condition2']}");
		if ($res->num_rows==0) echo -1;
		echo $res->fetch_row()[0];
	}

	if(isset($_GET['get9'])) {
		session_start();
		$res = $conn->query("SELECT personName, COUNT(idEvent) AS Number
		FROM historicperson T1
		LEFT JOIN historiceventparticipant T2
		ON T1.idPerson=T2.idPerson
		GROUP BY personName
		");
		while ($r = $res->fetch_row()) echo "<br>" . $r[0] . " - " . $r[1] . ",";
	}

	if(isset($_GET['get10'])) {
		session_start();
		$res = $conn->query("SELECT stateName, COUNT(idBattle) AS Number
		FROM states T1
		LEFT JOIN governmentparticipant T2
		ON T1.idState=T2.idState
		GROUP BY stateName
		");
		while ($r = $res->fetch_row()) echo "<br>" . $r[0] . " - " . $r[1] . ",";
	}

	if(isset($_GET['get11'])) {
		session_start();
		$res = $conn->query("SELECT stateName FROM states INNER JOIN (SELECT idState FROM governmentparticipant GROUP BY idState HAVING count(idBattle) > ANY (SELECT count(idBattle) FROM governmentparticipant GROUP BY idState)) T1 ON states.idState=T1.idState");
		echo $res->fetch_row()[0];
	}

	if(isset($_GET['get12'])) {
		session_start();
		$res = $conn->query("SELECT personName FROM historicperson T1 INNER JOIN (SELECT idPerson, COUNT(idState) as num FROM government GROUP BY idPerson ORDER BY num DESC LIMIT 1) T2 ON T1.idPerson=T2.idPerson");
		echo $res->fetch_row()[0];
	}

	if(isset($_GET['get13'])) {
		session_start();
		$res = $conn->query("SELECT eventName, battlename, TotalTroops
		FROM historicevent T1
		LEFT JOIN (
		SELECT idEvent, battlename, SUM(Troops) as TotalTroops
				   FROM battle T2
				   LEFT JOIN (
				   SELECT idBattle, SUM(troopsnumber) as Troops
				   FROM governmentparticipant
				   GROUP BY idBattle) T3
				   ON T2.idBattle=T3.idBattle
				   GROUP BY idEvent) T3
				   ON T1.idEvent=T3.idEvent
				   WHERE type=1
		");
		while ($r = $res->fetch_row()) {
			if ($r[1]=="") $r[1]="---";
			echo "<br>" . $r[0] . " - " . $r[1] . ",";
		}
	}

	if(isset($_GET['get14'])) {
		session_start();
		$res = $conn->query("SELECT personName, T2.eventName
		FROM historicperson T3
		LEFT JOIN (
		SELECT idPerson, T.eventName
		FROM historiceventparticipant
		LEFT JOIN (SELECT startYear, idEvent, eventName
				   FROM historicevent) T
		ON T.idEvent=historiceventparticipant.idEvent
		WHERE startYear IN (SELECT MIN(startYear) as startYear
									   FROM historicevent Z
									   LEFT JOIN historiceventparticipant Z1
									   ON Z.idEvent=Z1.idEvent
									   GROUP BY idPerson)
		GROUP BY idPerson) T2
		ON T3.idPerson=T2.idPerson
		");
		while ($r = $res->fetch_row()) {
			if ($r[1]=="") $r[1]="---";
			echo "<br>" . $r[0] . " - " . $r[1] . ",";
		}
	}

	if(isset($_GET['get15'])) {
		session_start();
		$res = $conn->query("SELECT personName
		FROM historicperson
		LEFT JOIN (SELECT idPerson
		FROM historicevent T1
		INNER JOIN historiceventparticipant T2
		ON T1.idEvent=T2.idEvent
		WHERE T1.startYear>{$_GET['condition']}
		GROUP BY idPerson) T
		ON historicperson.idPerson=T.idPerson
		WHERE T.idPerson IS NULL");
		if ($res->num_rows==0) echo -1;
		else {
			while ($r = $res->fetch_row()) {
				echo $r[0] . ", ";
			}
		}
	}

	if(isset($_GET['get16'])) {
		session_start();
		$res = $conn->query("SELECT personName
		FROM historicperson
		LEFT JOIN (
			SELECT idPerson, idState
			FROM government
			WHERE startYear >= {$_GET['condition1']} AND endYear <={$_GET['condition2']}) T1
		ON historicperson.idPerson=T1.idPerson
		WHERE idState IS NULL
		");
		if ($res->num_rows==0) echo -1;
		else {
			while ($r = $res->fetch_row()) {
				echo $r[0] . ", ";
			}
		}
	}

	if(isset($_GET['get17'])) {
		session_start();
		$res = $conn->query("SELECT StateName, 'Больше всего боёв' FROM
			(SELECT stateName, COUNT(idBattle) as Battles
				FROM states T1
				LEFT JOIN governmentparticipant T2
				ON T1.idState=T2.idState
				GROUP BY stateName
				ORDER BY Battles DESC
				LIMIT 1) T3
				UNION
				SELECT T3.stateName, 'Меньше всего боёв' as Comment FROM
			(SELECT stateName, COUNT(idBattle) as Battles
				FROM states T1
				LEFT JOIN governmentparticipant T2
				ON T1.idState=T2.idState
				GROUP BY stateName
				ORDER BY Battles ASC
				LIMIT 1) T3");
		echo '<br><br><b>' . $res->fetch_row()[0] . '</b> - Больше всего боёв<br>';
		echo '<br><b>' . $res->fetch_row()[0] . '</b> - Меньше всего боёв';
	}

	if(isset($_GET['get18'])) {
		session_start();
		$res = $conn->query("SELECT personName, 'Наибольшее количество исторических событий' as Comment
		FROM historicperson T1
		INNER JOIN (
		SELECT idPerson, COUNT(idEvent) as Events
		FROM historiceventparticipant
		GROUP BY idPerson
		ORDER BY Events DESC
		LIMIT 1) T2
		ON T1.idPerson=T2.idPerson
		UNION
		SELECT personName, 'Наименьшее количество исторических событий' as Comment
		FROM historicperson T1
		INNER JOIN (
		SELECT idPerson, COUNT(idEvent) as Events
		FROM historiceventparticipant
		GROUP BY idPerson
		ORDER BY Events ASC
		LIMIT 1) T2
		ON T1.idPerson=T2.idPerson
		");
		echo '<br><br><b>' . $res->fetch_row()[0] . '</b> - Наибольшее количество исторических событий<br>';
		echo '<br><b>' . $res->fetch_row()[0] . '</b> - Наименьшее количество исторических событий';
	}

	if(isset($_GET['get19'])) {
		session_start();
		$res = $conn->query("UPDATE users
		SET comment='Больше всего записей в журнале!'
		WHERE username = (SELECT username FROM (SELECT username, count(username) AS num FROM journal GROUP BY username ORDER BY num DESC LIMIT 1) T1)");
		echo "Успех";
	}

	if(isset($_GET['get20'])) {
		session_start();
		$res = $conn->query("UPDATE users
		SET comment='Меньше всего записей в журнале!'
		WHERE username = (SELECT username FROM (SELECT username, count(username) AS num FROM journal GROUP BY username ORDER BY num ASC LIMIT 1) T1)");
		echo "Успех";
	}
	?>