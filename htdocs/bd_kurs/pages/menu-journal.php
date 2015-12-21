<style>
	.leftTd {
		border: 3px solid black;
		border-spacing: 0;
		width: 20%;
	}
	.rightTd {
		border: 3px solid black;
		border-spacing: 0;
		width: 80%;
	}
</style>

<div style="font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 20px;text-align:center;top: 50px; position: relative;">
	<table id="journalTable" align="center" style="width: 95%; padding:0; border-collapse: collapse;">
		<tr style="height: 50px;">
			<td class="leftTd"><b>Дата</b></td>
			<td class="rightTd"><b>Описание</b></td>
		</tr>
	</table>
</div>


<script>
	$.ajax({
		method: 'get',
		url: 'bdController.php?loadJournal',
		dataType: 'json',
		success: function(data) {
			var l=data.length;
			for (var i=0; i<l; i++) {
				$('#journalTable').append("<tr style='height: 30px;'><td class='leftTd'>" + data[i]['time'] + "</td><td class='rightTd' style='text-align: left;'>&nbsp;&nbsp;" + data[i]['username'] + " " + data[i]['text'] + "</td></tr></table>");
			}
		}
	});
</script>