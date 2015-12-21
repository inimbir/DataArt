<style>
	.Td {
		border: 3px solid black;
		border-spacing: 0;
	}
	.Td {
		border: 3px solid black;
		border-spacing: 0;
	}
	.obuttons {
		width: 100px;
		margin-top: 5px;
		margin-right: 5px;
		font-size: 14px;
		font-weight: 450;
		background-color:#212121;
		color:#E0E0E0;
		border-style:none;
		height: 23px;
	}

	.obuttons:hover {
		background-color:#E0E0E0;
		color:#000000;
	}

	.obuttons:active {
		background-color:#212121;
		color:#E0E0E0;
	}
	.ofields {
		margin-top: 5px;
		margin-right:5px;
		height: 20px;
	}
</style>

<div id="editingField" style="font-family: 'Roboto', sans-serif;font-weight: 500;font-size: 18px;text-align:center;top: 10px; position: relative;">
</div>

<div id="countriesPage" style="font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 20px;text-align:center;top: 50px; position: relative;">
	<table id="stateTable" align="center" style="width: 95%; padding:0; border-collapse: collapse;">
		<tr style="height: 50px;">
			<td class="Td" style="width: 35%;"><b>Имя</b></td>
			<td class="Td" style="width: 35%;"><b>Место рождения</b></td>
			<td class="Td" style="width: 15%;"><b>Год рождения</b></td>
			<td class="Td" style="width: 15%;"><b>Год смерти</b></td>
		</tr>
	</table>
	<?php
	session_start();
	if ($_SESSION['usertype']>0) echo "<button class='obuttons' onclick='addPerson()'>Добавить</button>";
	?>
</div>

<script>
	$.get("bdController.php?getUsertype", function(data){
		if (data>0) {
			$.ajax({
				method: 'get',
				url: 'bdController.php?loadPersons',
				dataType: 'json',
				success: function(data) {
					var l = data.length;
					for (var i=0; i<l; i++) {
						$('#stateTable').append("<tr style='height: 30px;'>" +
							"<td class='Td'>" + data[i]['personName'] + "</td>" +
							"<td class='Td'>" + data[i]['birthCity'] + "</td>" +
							"<td class='Td'>" + data[i]['birthYear'] + "</td>" +
							"<td class='Td'>" + data[i]['deathYear'] + "</td>" +
							"<td><img onclick='editPerson(" + data[i]['idPerson'] + ")' style='height:20px;margin-left: 5px;' src='img/edit.png'></td>" +
							"<td><img onclick='deletePerson(" + data[i]['idPerson'] + ")' style='height:20px;margin-left: 5px;' src='img/delete.png'></td></tr>");
					}
				}
			});
		}
		else {
			$.ajax({
				method: 'get',
				url: 'bdController.php?loadPersons',
				dataType: 'json',
				success: function(data) {
					var l = data.length;
					for (var i=0; i<l; i++) {
						$('#stateTable').append("<tr style='height: 30px;'>" +
							"<td class='Td'>" + data[i]['personName'] + "</td>" +
							"<td class='Td'>" + data[i]['birthCity'] + "</td>" +
							"<td class='Td'>" + data[i]['birthYear'] + "</td>" +
							"<td class='Td'>" + data[i]['deathYear'] + "</td></tr>");
					}
				}
			});
		}
	});

	function addPerson() {
		$('#editingField').hide(100);
		$('#editingField').empty();
		$('#editingField').append("Добавление<br>" +
			"<input id='name' class='ofields' type='text' placeholder='Имя'>" +
			"<input id='city' class='ofields' type='text' placeholder='Место рождения'>" +
			"<input id='by' class='ofields' type='text' placeholder='Год рождения'>" +
			"<input id='dy' class='ofields' type='text' placeholder='Год смерти (не обяз.)'>" +
			"<br><button  class='obuttons' onclick='addPersonFinish()'>Сохранить</button>" +
			"<button class='obuttons' onclick='$(\"#editingField\").hide(500)'>Отмена</button>");
		$('#editingField').show(500);
	}

	function addPersonFinish() {
		var Name = document.getElementById('name').value;
		var City = document.getElementById('city').value;
		var BY = document.getElementById('by').value;
		var DY = document.getElementById('dy').value;
		if (Name==""||City==""||BY=="") alert("Заполните обязательные поля!");
		else {
			if (!isNaN(BY)) {
				if (DY != "" && BY > DY) alert("Год рождения не может быть больше года смерти!");
				else {
					$.get("bdController.php?addPerson", {Name: Name, City: City, BY: BY, DY: DY}, function (data) {
						if (data == 1) {
							$("#personsButton").trigger("click");
						}
						else alert("Данная личность уже существует в базе данных!");
					});
				}
			}
			else alert("Год рождения и год смерти должны состоять только из цифр!");
		}
	}

	function editPerson(i) {
		$('#editingField').hide(100);
		$('#editingField').empty();
		$.getJSON("bdController.php?getPerson", {id:i}, function(data){
			if (data[4]==null) data[4]="";
			$('#editingField').append("Редактирование<br>" +
				"<input id='name' class='ofields' type='text' placeholder='Имя' value='" + data[1] + "'>" +
				"<input id='city' class='ofields' type='text' placeholder='Место рождения' value='" + data[2] + "'>" +
				"<input id='by' class='ofields' type='text' placeholder='Год рождения' value='" + data[3] + "'>" +
				"<input id='dy' class='ofields' type='text' placeholder='Год смерти (не обяз.)' value='" + data[4] + "'>" +
				"<br><button  class='obuttons' onclick='editPersonFinish(" + i + ")'>Сохранить</button>" +
				"<button class='obuttons' onclick='$(\"#editingField\").hide(500)'>Отмена</button>");
			$('#editingField').show(500);
		});
	}

	function editPersonFinish(i) {
		var Name = document.getElementById('name').value;
		var City = document.getElementById('city').value;
		var BY = document.getElementById('by').value;
		var DY = document.getElementById('dy').value;
		if (Name==""||City==""||BY=="") alert("Заполните обязательные поля!");
		else {
			if (!isNaN(BY)) {
				if (DY != "" && BY > DY) alert("Год рождения не может быть больше года смерти!");
				else {
					$.get('bdController.php?editPerson', {
						id: i,
						Name: Name,
						City: City,
						BY: BY,
						DY: DY
					}, function (data) {
						if (data == 1) {
							$("#personsButton").trigger("click");
						}
						else alert("Данная личность уже существует в базе данных!");
					});
				}
			}
			else alert("Год рождения и год смерти должны состоять только из цифр!");
		}
	}

	function deletePerson(i) {
		if (confirm("Вы уверены, что хотите удалить данную запись?")) {
			$.get("bdController.php?deletePerson", {id: i}, function(){
				$("#personsButton").trigger( "click" );
			});
		}
	}
</script>