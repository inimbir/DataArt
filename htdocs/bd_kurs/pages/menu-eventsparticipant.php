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
			<td class="Td" style="width: 50%;"><b>Название события</b></td>
			<td class="Td" style="width: 50%;"><b>Имя участника</b></td>
		</tr>
	</table>
	<?php
	session_start();
	if ($_SESSION['usertype']>0) echo "<button class='obuttons' onclick='addEventPart()'>Добавить</button>";
	?>
</div>

<script>
	$.get("bdController.php?getUsertype", function(data){
		if (data>0) {
			$.ajax({
				method: 'get',
				url: 'bdController.php?loadEventPart',
				dataType: 'json',
				success: function(data) {
					var l = data.length;
					for (var i=0; i<l; i++) {
						$('#stateTable').append("<tr style='height: 30px;'>" +
							"<td class='Td'>" + data[i]['eventName'] + "</td>" +
							"<td class='Td'>" + data[i]['personName'] + "</td>" +
							"<td><img onclick='deleteEventPart(" + data[i]['idEvent'] + "," + data[i]['idPerson'] + ")' style='height:20px;margin-left: 5px;' src='img/delete.png'></td></tr>");
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
							"<td class='Td'>" + data[i]['personName'] + "</td></tr>");
					}
				}
			});
		}
	});

	function addEventPart() {
		$('#editingField').hide(100);
		$('#editingField').empty();
		$('#editingField').append("Добавление<br>" +
			"<select id='eventList'></select>" +
			"<select id='personList'></select>" +
			"<br><button  class='obuttons' onclick='addEventPartFinish()'>Сохранить</button>" +
			"<button class='obuttons' onclick='$(\"#editingField\").hide(500)'>Отмена</button>");
		$('#editingField').show(500);
		$.ajax({
			method: 'get',
			url: 'bdController.php?getEvents',
			dataType: 'json',
			success: function (data) {
				var l = data.length;
				for (var i = 0; i < l; i++) {
					$('#eventList').append("<option value='" + data[i]['idEvent'] + "'>" + data[i]['eventName'] + "</option>");
				}
			}
		});
		$.ajax({
			method: 'get',
			url: 'bdController.php?getPersons',
			dataType: 'json',
			success: function (data) {
				var l = data.length;
				for (var i = 0; i < l; i++) {
					$('#personList').append("<option value='" + data[i]['idPerson'] + "'>" + data[i]['personName'] + "</option>");
				}
			}
		});
	}

	function addEventPartFinish() {
		var idEvent = $('#eventList option:selected').val();
		var idPerson = $('#personList option:selected').val();
		var eventName = $('#eventList option:selected').text();
		var personName = $('#personList option:selected').text();
		$.get("bdController.php?addEventPart", {idEvent: idEvent, idPerson: idPerson, eventName: eventName, personName: personName}, function (data) {
			if (data == 1) {
				$("#eventPartButton").trigger("click");
			}
			else alert("Выбранная личность уже является участником данного события!");
		});
	}

	function deleteEventPart(i1, i2) {
		if (confirm("Вы уверены, что хотите удалить данную запись?")) {
			$.get("bdController.php?deleteEventPart", {idEvent: i1, idPerson: i2}, function(){
				$("#eventPartButton").trigger( "click" );
			});
		}
	}
</script>