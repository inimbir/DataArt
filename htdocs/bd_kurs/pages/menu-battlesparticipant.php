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
	select {
		margin-top: 5px;
		margin-right:5px;
		height: 25px;
		max-width: 250px;
	}
</style>

<div id="editingField" style="font-family: 'Roboto', sans-serif;font-weight: 500;font-size: 18px;text-align:center;top: 10px; position: relative;">
</div>

<div id="countriesPage" style="font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 20px;text-align:center;top: 50px; position: relative;">
	<table id="stateTable" align="center" style="width: 95%; padding:0; border-collapse: collapse;">
		<tr style="height: 50px;">
			<td class="Td" style="width: 35%;"><b>Страна</b></td>
			<td class="Td" style="width: 35%;"><b>Битва</b></td>
			<td class="Td" style="width: 15%;"><b>Войска</b></td>
			<td class="Td" style="width: 15%;"><b>Потери</b></td>
		</tr>
	</table>
	<?php
	session_start();
	if ($_SESSION['usertype']>0) echo "<button class='obuttons' onclick='addBattlePart()'>Добавить</button>";
	?>
</div>

<script>
	$.get("bdController.php?getUsertype", function(data){
		if (data>0) {
			$.ajax({
				method: 'get',
				url: 'bdController.php?loadBattleParts',
				dataType: 'json',
				success: function(data) {
					var l = data.length;
					for (var i=0; i<l; i++) {
						$('#stateTable').append("<tr style='height: 30px;'>" +
							"<td class='Td'>" + data[i]['stateName'] + "</td>" +
							"<td class='Td'>" + data[i]['battlename'] + "</td>" +
							"<td class='Td'>" + data[i]['troopsnumber'] + "</td>" +
							"<td class='Td'>" + data[i]['lossesnumber'] + "</td>" +
							"<td><img onclick='deleteBattlePart(" + data[i]['idState'] + "," + data[i]['idBattle'] + ")' style='height:20px;margin-left: 5px;' src='img/delete.png'></td></tr>");
					}
				}
			});
		}
		else {
			$.ajax({
				method: 'get',
				url: 'bdController.php?loadBattleParts',
				dataType: 'json',
				success: function(data) {
					var l = data.length;
					for (var i=0; i<l; i++) {
						$('#stateTable').append("<tr style='height: 30px;'>" +
							"<td class='Td'>" + data[i]['stateName'] + "</td>" +
							"<td class='Td'>" + data[i]['battlename'] + "</td>" +
							"<td class='Td'>" + data[i]['troopsnumber'] + "</td>" +
							"<td class='Td'>" + data[i]['lossesnumber'] + "</td></tr>");
					}
				}
			});
		}
	});

	function addBattlePart() {
		$('#editingField').hide(100);
		$('#editingField').empty();
		$('#editingField').append("Добавление<br>" +
			"<select id='stateList'></select>"  +
			"<select id='battleList'></select>" +
			"<input id='troops' class='ofields' type='text' placeholder='Войска'>" +
			"<input id='losses' class='ofields' type='text' placeholder='Потери'>" +
			"<br><button  class='obuttons' onclick='addBattlePartFinish()'>Сохранить</button>" +
			"<button class='obuttons' onclick='$(\"#editingField\").hide(500)'>Отмена</button>");
		$.ajax({
			method: 'get',
			url: 'bdController.php?getStates',
			dataType: 'json',
			success: function (data) {
				$('#stateList').empty();
				var l = data.length;
				for (var i = 0; i < l; i++) {
					$('#stateList').append("<option value='" + data[i]['idState'] + "'>" + data[i]['stateName'] + "</option>");
				}
			}
		});
		$.ajax({
			method: 'get',
			url: 'bdController.php?loadBattles',
			dataType: 'json',
			success: function (data) {
				$('#battleList').empty();
				var l = data.length;
				for (var i = 0; i < l; i++) {
					$('#battleList').append("<option value='" + data[i]['idBattle'] + "'>" + data[i]['battlename'] + "</option>");
				}
			}
		});
		$('#editingField').show(500);
	}

	function addBattlePartFinish() {
		var idState = $('#stateList option:selected').val();
		var idBattle = $('#battleList option:selected').val();
		var troopsnumber = document.getElementById('troops').value;
		var lossesnumber = document.getElementById('losses').value;
		if (troopsnumber==""||lossesnumber=="") alert("Заполните обязательные поля!");
		else {
			if (!isNaN(troopsnumber)&&!isNaN(lossesnumber)) {
				if (parseInt(troopsnumber) < parseInt(lossesnumber)) alert("Потери не могут быть больше изначального количества войск!");
				else {
					$.get("bdController.php?addBattlePart", {
						idState: idState,
						idBattle: idBattle,
						troopsnumber: troopsnumber,
						lossesnumber: lossesnumber
					}, function (data) {
						if (data == 1) {
							$("#battlePartButton").trigger("click");
						}
						else alert("Данная страна уже привязана к данной битве!");
					});
				}
			}
			else alert("Войска и потери должны состоять только из цифр!");
		}
	}

	function deleteBattlePart(i1, i2) {
		if (confirm("Вы уверены, что хотите удалить данную запись?")) {
			$.get("bdController.php?deleteBattlePart", {idState: i1, idBattle: i2}, function(){
				$("#battlePartButton").trigger( "click" );
			});
		}
	}
</script>