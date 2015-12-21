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
	textarea {
		margin-top: 5px;
		margin-right:5px;
		position: relative;
		top: 9px;
		height: 19px;
		max-height: 70px;
		width: 250px;
		max-width: 250px;
	}
</style>

<div id="editingField" style="font-family: 'Roboto', sans-serif;font-weight: 500;font-size: 18px;text-align:center;top: 10px; position: relative;">
</div>

<div id="countriesPage" style="font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 20px;text-align:center;top: 50px; position: relative;">
	<table id="stateTable" align="center" style="width: 95%; padding:0; border-collapse: collapse;">
		<tr style="height: 50px;">
			<td class="Td" style="width: 40%;"><b>Название</b></td>
			<td class="Td" style="width: 40%;"><b>Описание</b></td>
			<td class="Td" style="width: 10%;"><b>Начало</b></td>
			<td class="Td" style="width: 10%;"><b>Конец</b></td>
		</tr>
	</table>
	<?php
	session_start();
	if ($_SESSION['usertype']>0) echo "<button class='obuttons' onclick='addEvent()'>Добавить</button>";
	?>
</div>

<script>
	$.get("bdController.php?getUsertype", function(data){
		if (data>0) {
			$.ajax({
				method: 'get',
				url: 'bdController.php?loadEvents',
				dataType: 'json',
				success: function(data) {
					var l = data.length;
					for (var i=0; i<l; i++) {
						$('#stateTable').append("<tr style='height: 30px;'>" +
							"<td class='Td'>" + data[i]['eventName'] + "</td>" +
							"<td class='Td'>" + data[i]['description'] + "</td>" +
							"<td class='Td'>" + data[i]['startYear'] + "</td>" +
							"<td class='Td'>" + data[i]['endYear'] + "</td>" +
							"<td><img onclick='deleteEvent(" + data[i]['idEvent'] + ")' style='height:20px;margin-left: 5px;' src='img/delete.png'></td></tr>");
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
							"<td class='Td'>" + data[i]['description'] + "</td>" +
							"<td class='Td'>" + data[i]['startYear'] + "</td>" +
							"<td class='Td'>" + data[i]['endYear'] + "</td></tr>");
					}
				}
			});
		}
	});

	function addEvent() {
		$('#editingField').hide(100);
		$('#editingField').empty();
		$('#editingField').append("Добавление<br>" +
			"<input id='name' class='ofields' type='text' placeholder='Название'>" +
			"<select id='typeList'><option value='1'>Война</option><option value='2'>Событие</option></select>"  +
			"<textarea id='desc' placeholder='Описание'></textarea>" +
			"<input id='sy' class='ofields' type='text' placeholder='Год начала'>" +
			"<input id='ey' class='ofields' type='text' placeholder='Год конца (не обяз.)'>" +
			"<br><button  class='obuttons' onclick='addEventFinish()'>Сохранить</button>" +
			"<button class='obuttons' onclick='$(\"#editingField\").hide(500)'>Отмена</button>");
		$('#editingField').show(500);
	}

	function addEventFinish() {
		var Name = document.getElementById('name').value;
		var Type = $('#typeList option:selected').val();
		var Desc = $('#desc').val();
		var SY = document.getElementById('sy').value;
		var EY = document.getElementById('ey').value;
		if (Name==""||Desc==""||SY==""||EY=="") alert("Заполните обязательные поля!");
		else {
			if (!isNaN(SY)&&!isNaN(EY)) {
				if (SY > EY) alert("Год начала не может быть больше года конца!");
				else {
					$.get("bdController.php?addEvent", {Name: Name, Type: Type, Desc: Desc, SY: SY, EY: EY}, function (data) {
						if (data == 1) {
							$("#eventsButton").trigger("click");
						}
						else alert("Данное событие уже существует в базе данных!");
					});
				}
			}
			else alert("Год начала и год конца должны состоять только из цифр!");
		}
	}

	function deleteEvent(i) {
		if (confirm("Вы уверены, что хотите удалить данную запись?")) {
			$.get("bdController.php?deleteEvent", {id: i}, function(){
				$("#eventsButton").trigger( "click" );
			});
		}
	}
</script>