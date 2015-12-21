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
			<td class="Td" style="width: 38%;"><b>Имя правителя</b></td>
			<td class="Td" style="width: 38%;"><b>Страна правления</b></td>
			<td class="Td" style="width: 12%;"><b>Начало правления</b></td>
			<td class="Td" style="width: 12%;"><b>Конец правления</b></td>
		</tr>
	</table>
	<?php
	session_start();
	if ($_SESSION['usertype']>0) echo "<button class='obuttons' onclick='addGovernment()'>Добавить</button>";
	?>
</div>

<script>
	$.get("bdController.php?getUsertype", function(data){
		if (data>0) {
			$.ajax({
				method: 'get',
				url: 'bdController.php?loadGovernment',
				dataType: 'json',
				success: function(data) {
					var l = data.length;
					for (var i=0; i<l; i++) {
						$('#stateTable').append("<tr style='height: 30px;'>" +
							"<td class='Td'>" + data[i]['personName'] + "</td>" +
							"<td class='Td'>" + data[i]['stateName'] + "</td>" +
							"<td class='Td'>" + data[i]['startYear'] + "</td>" +
							"<td class='Td'>" + data[i]['endYear'] + "</td>" +
							"<td><img onclick='deleteGovernment(" + data[i]['idPerson'] + ", " + data[i]['idState'] + ", " + data[i]['startYear'] + ", " + data[i]['endYear'] + ")' style='height:20px;margin-left: 5px;' src='img/delete.png'></td></tr>");
					}
				}
			});
		}
		else {
			$.ajax({
				method: 'get',
				url: 'bdController.php?loadGovernment',
				dataType: 'json',
				success: function(data) {
					var l = data.length;
					for (var i=0; i<l; i++) {
						$('#stateTable').append("<tr style='height: 30px;'>" +
							"<td class='Td'>" + data[i]['personName'] + "</td>" +
							"<td class='Td'>" + data[i]['stateName'] + "</td>" +
							"<td class='Td'>" + data[i]['startYear'] + "</td>" +
							"<td class='Td'>" + data[i]['endYear'] + "</td></tr>");
					}
				}
			});
		}
	});

	function addGovernment() {
		$('#editingField').hide(100);
		$('#editingField').empty();
		$('#editingField').append("Добавление<br>" +
			"<select id='personList'></select>" +
			"<select id='stateList'></select>"+
			"<select id='startYears'></select>" +
			"<select id='finishYears'></select>" +
			"<br><button  class='obuttons' onclick='addGovernmentFinish()'>Сохранить</button>" +
			"<button class='obuttons' onclick='$(\"#editingField\").hide(500)'>Отмена</button>");
		$('#editingField').show(500);
		$.ajax({
			method: 'get',
			url: 'bdController.php?getPersons',
			dataType: 'json',
			success: function (data) {
				var l = data.length;
				for (var i = 0; i < l; i++) $('#personList').append("<option value='" + data[i]['idPerson'] + "'>" + data[i]['personName'] + "</option>");
			}
		});
		$.ajax({
			method: 'get',
			url: 'bdController.php?getStates',
			dataType: 'json',
			success: function (data) {
				var l = data.length;
				for (var i = 0; i < l; i++) $('#stateList').append("<option value='" + data[i]['idState'] + "'>" + data[i]['stateName'] + "</option>");
				var idState = $('#stateList option:selected').val();
				$.ajax({
					method: 'get',
					url: 'bdController.php?getYears',
					dataType: 'json',
					data: {
						idState: idState
					},
					success: function (data1) {
						var l = data1['terminationYear'];
						for (var i = data1['foundationYear']; i <= l; i++) {
							$('#startYears').append("<option>" + i + "</option>");
							$('#finishYears').append("<option>" + i + "</option>");
						}
					}
				});
			}
		});
		$("#stateList").change(function() {
			var idState = $('#stateList option:selected').val();
			$.ajax({
				method: 'get',
				url: 'bdController.php?getYears',
				dataType: 'json',
				data: {
					idState: idState
				},
				success: function (data) {
					$('#startYears').empty();
					$('#finishYears').empty();
					var l;
					if (data['terminationYear'] == null) l=2015;
					else l = data['terminationYear'];
					for (var i = data['foundationYear']; i <= l; i++) {
						$('#startYears').append("<option>" + i + "</option>");
						$('#finishYears').append("<option>" + i + "</option>");
					}
				}
			});
		});
	}

	function addGovernmentFinish() {
		var idPerson = $('#personList option:selected').val();
		var idState = $('#stateList option:selected').val();
		var SG = $('#startYears option:selected').text();
		var FG = $('#finishYears option:selected').text();
		if (SG > FG) alert("Год начала правления не может быть больше года окончания!");
		else {
			$.get("bdController.php?addGovernment", {idPerson: idPerson, idState: idState, SG: SG, FG: FG}, function (data) {
				if (data == 1) {
					$("#governmentButton").trigger("click");
				}
			});
		}
	}

	function deleteGovernment(i1, i2, sy, ey) {
		if (confirm("Вы уверены, что хотите удалить данную запись?")) {
			$.get("bdController.php?deleteGovernment", {idPerson: i1, idState: i2, startYear: sy, endYear: ey}, function(data){
				$("#governmentButton").trigger( "click" );
			});
		}
	}
</script>