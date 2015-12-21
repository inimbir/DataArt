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
			<td class="Td" style="width: 42%;"><b>Война</b></td>
			<td class="Td" style="width: 42%;"><b>Битва</b></td>
			<td class="Td" style="width: 16%;"><b>Год</b></td>
		</tr>
	</table>
	<?php
	session_start();
	if ($_SESSION['usertype']>0) echo "<button class='obuttons' onclick='addBattle()'>Добавить</button>";
	?>
</div>

<script>
	$.get("bdController.php?getUsertype", function(data){
		if (data>0) {
			$.ajax({
				method: 'get',
				url: 'bdController.php?loadBattles',
				dataType: 'json',
				success: function(data) {
					var l = data.length;
					for (var i=0; i<l; i++) {
						$('#stateTable').append("<tr style='height: 30px;'>" +
							"<td class='Td'>" + data[i]['eventName'] + "</td>" +
							"<td class='Td'>" + data[i]['battlename'] + "</td>" +
							"<td class='Td'>" + data[i]['battleyear'] + "</td>" +
							"<td><img onclick='deleteBattle(" + data[i]['idBattle'] + ")' style='height:20px;margin-left: 5px;' src='img/delete.png'></td></tr>");
					}
				}
			});
		}
		else {
			$.ajax({
				method: 'get',
				url: 'bdController.php?loadEvents',
				dataType: 'json',
				success: function(data) {
					var l = data.length;
					for (var i=0; i<l; i++) {
						$('#stateTable').append("<tr style='height: 30px;'>" +
							"<td class='Td'>" + data[i]['eventName'] + "</td>" +
							"<td class='Td'>" + data[i]['battlename'] + "</td>" +
							"<td class='Td'>" + data[i]['battleyear'] + "</td></tr>");
					}
				}
			});
		}
	});

	function addBattle() {
		$('#editingField').hide(100);
		$('#editingField').empty();
		$('#editingField').append("Добавление<br>" +
			"<select id='warList'></select>"  +
			"<input id='name' class='ofields' type='text' placeholder='Название битвы'>" +
			"<select id='yearList'></select>" +
			"<br><button  class='obuttons' onclick='addBattleFinish()'>Сохранить</button>" +
			"<button class='obuttons' onclick='$(\"#editingField\").hide(500)'>Отмена</button>");
		$.ajax({
			method: 'get',
			url: 'bdController.php?getWars',
			dataType: 'json',
			success: function (data) {
				$('#warList').empty();
				var l = data.length;
				for (var i = 0; i < l; i++) $('#warList').append("<option value='" + data[i]['idEvent'] + "'>" + data[i]['eventName'] + "</option>");
				var idEvent = $('#warList option:selected').val();
				$.ajax({
					method: 'get',
					url: 'bdController.php?getYearsForWar',
					dataType: 'json',
					data: {
						idEvent: idEvent
					},
					success: function (data) {
						$('#yearList').empty();
						var l = data['endYear'];
						for (var i = data['startYear']; i <= l; i++) {
							$('#yearList').append("<option>" + i + "</option>");
						}
					}
				});
				$("#warList").change(function() {
					var idEvent = $('#warList option:selected').val();
					$.ajax({
						method: 'get',
						url: 'bdController.php?getYearsForWar',
						dataType: 'json',
						data: {
							idEvent: idEvent
						},
						success: function (data) {
							$('#yearList').empty();
							var l = data['endYear'];
							for (var i = data['startYear']; i <= l; i++) {
								$('#yearList').append("<option>" + i + "</option>");
							}
						}
					});
				});
			}
		});
		$('#editingField').show(500);
	}

	function addBattleFinish() {
		var idEvent = $('#warList option:selected').val();
		var Name = document.getElementById('name').value;
		var Year = $('#yearList option:selected').val();
		if (Name==""||Year=="") alert("Заполните обязательные поля!");
		else {
			$.get("bdController.php?addBattle", {Name: Name, Year: Year, idEvent: idEvent}, function (data) {
				if (data == 1) {
					$("#battlesButton").trigger("click");
				}
				else alert("Данная битва уже существует в базе данных!");
			});
		}
	}

	function deleteBattle(i) {
		if (confirm("Вы уверены, что хотите удалить данную запись?")) {
			$.get("bdController.php?deleteBattle", {id: i}, function(){
				$("#battlesButton").trigger( "click" );
			});
		}
	}
</script>