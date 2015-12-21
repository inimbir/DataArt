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
			<td class="Td" style="width: 35%;"><b>Название</b></td>
			<td class="Td" style="width: 35%;"><b>Столица</b></td>
			<td class="Td" style="width: 15%;"><b>Год основания</b></td>
			<td class="Td" style="width: 15%;"><b>Год распада</b></td>
		</tr>
	</table>
	<?php
	session_start();
	if ($_SESSION['usertype']>0) echo "<button class='obuttons' onclick='addState()'>Добавить</button>";
	?>
</div>


<script>
	$.get("bdController.php?getUsertype", function(data){
		if (data>0) {
			$.ajax({
				method: 'get',
				url: 'bdController.php?loadStates',
				dataType: 'json',
				success: function(data) {
					var l = data.length;
					for (var i=0; i<l; i++) {
						$('#stateTable').append("<tr style='height: 30px;'>" +
							"<td class='Td'>" + data[i]['stateName'] + "</td>" +
							"<td class='Td'>" + data[i]['capitalCity'] + "</td>" +
							"<td class='Td'>" + data[i]['foundationYear'] + "</td>" +
							"<td class='Td'>" + data[i]['terminationYear'] + "</td>" +
							"<td><img onclick='editState(" + data[i]['idState'] + ")' style='height:20px;margin-left: 5px;' src='img/edit.png'></td>" +
							"<td><img onclick='deleteState(" + data[i]['idState'] + ")' style='height:20px;margin-left: 5px;' src='img/delete.png'></td></tr>");
					}
				}
			});
		}
		else {
			$.ajax({
				method: 'get',
				url: 'bdController.php?loadStates',
				dataType: 'json',
				success: function(data) {
					var l = data.length;
					for (var i=0; i<l; i++) {
						$('#stateTable').append("<tr style='height: 30px;'>" +
							"<td class='Td'>" + data[i]['stateName'] + "</td>" +
							"<td class='Td'>" + data[i]['capitalCity'] + "</td>" +
							"<td class='Td'>" + data[i]['foundationYear'] + "</td>" +
							"<td class='Td'>" + data[i]['terminationYear'] + "</td></tr>");
					}
				}
			});
		}
	});

	function addState() {
		$('#editingField').hide(100);
		$('#editingField').empty();
		$('#editingField').append("Добавление<br>" +
			"<input id='name' class='ofields' type='text' placeholder='Название'>" +
			"<input id='capital' class='ofields' type='text' placeholder='Столица'>" +
			"<input id='sy' class='ofields' type='text' placeholder='Год основания'>" +
			"<input id='ty' class='ofields' type='text' placeholder='Год распада (не обяз.)'>" +
			"<br><button  class='obuttons' onclick='addStateFinish()'>Сохранить</button>" +
			"<button class='obuttons' onclick='$(\"#editingField\").hide(500)'>Отмена</button>");
		$('#editingField').show(500);
	}

	function addStateFinish() {
		var Name = document.getElementById('name').value;
		var Capital = document.getElementById('capital').value;
		var SY = document.getElementById('sy').value;
		var TY = document.getElementById('ty').value;
		if (Name==""||Capital==""||SY=="") alert("Заполните обязательные поля!");
		else {
			if (!isNaN(SY)) {
				if (TY != "" && SY > TY) alert("Год основания не может быть больше года распада!");
				else {
					$.get("bdController.php?addState", {Name: Name, Capital: Capital, SY: SY, TY: TY}, function (data) {
						if (data == 1) {
							$("#statesButton").trigger("click");
						}
						else alert("Старана с таким названием уже существует в системе!");
					});
				}
			}
			else alert("Год основания и год распада должны состоять только из цифр!");
		}
	}

	function editState(i) {
		$('#editingField').hide(100);
		$('#editingField').empty();
		$.getJSON("bdController.php?getState", {id:i}, function(data){
			if (data[3]==null) data[3]="";
			$('#editingField').append("Редактирование<br>" +
				"<input id='name' class='ofields' type='text' placeholder='Название' value='" + data[1] + "'>" +
				"<input id='capital' class='ofields' type='text' placeholder='Столица' value='" + data[4] + "'>" +
				"<input id='sy' class='ofields' type='text' placeholder='Год основания' value='" + data[2] + "'>" +
				"<input id='ty' class='ofields' type='text' placeholder='Год распада (не обяз.)' value='" + data[3] + "'>" +
				"<br><button  class='obuttons' onclick='editStateFinish(" + i + ")'>Сохранить</button>" +
				"<button class='obuttons' onclick='$(\"#editingField\").hide(500)'>Отмена</button>");
			$('#editingField').show(500);
		});
	}

	function editStateFinish(i) {
		var Name = document.getElementById('name').value;
		var Capital = document.getElementById('capital').value;
		var SY = document.getElementById('sy').value;
		var TY = document.getElementById('ty').value;
		if (Name==""||Capital==""||SY=="") alert("Заполните обязательные поля!");
		else {
			if (!isNaN(SY)) {
				if (TY != "" && SY > TY) alert("Год основания не может быть больше года распада!");
				else {
					$.get("bdController.php?editState", {
						id: i,
						Name: Name,
						Capital: Capital,
						SY: SY,
						TY: TY
					}, function (data) {
						if (data == 1) {
							$("#statesButton").trigger("click");
						}
						else alert("Старана с таким названием уже существует в системе!");
					});
				}
			}
			else alert("Год основания и год распада должны состоять только из цифр!");
		}
	}

	function deleteState(i) {
		if (confirm("Вы уверены, что хотите удалить данную запись?")) {
			$.get("bdController.php?deleteState", {id: i}, function(){
				$("#statesButton").trigger( "click" );
			});
		}
	}
</script>