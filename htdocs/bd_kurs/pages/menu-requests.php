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
		width: 50px;
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
</style>
<?php
session_start();
?>
<div id="countriesPage" style="font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 20px;margin-left:50px;top: 50px; position: relative;">
	1. Показать события в которых принимала участие заданная историческая личность. <button class="obuttons" onclick="window.location='request.php?id=1'">→</button><br><br>
	2. Показать правителей заданной державы. <button class="obuttons" onclick="window.location='request.php?id=2'">→</button><br><br>
	3. Показать исторические личности, чьи имена начинаются на заданную букву. <button class="obuttons" onclick="window.location='request.php?id=3'">→</button><br><br>
	4. Показать страны, названия которых начинаются на заданную букву. <button class="obuttons" onclick="window.location='request.php?id=4'">→</button><br><br>
	5. Исторические события, начавшиеся в заданный период. <button class="obuttons" onclick="window.location='request.php?id=5'">→</button><br><br>
	6. Битвы, проходившие в заданный период. <button class="obuttons" onclick="window.location='request.php?id=6'">→</button><br><br>
	7. Количество битв, прошедших в заданный период. <button class="obuttons" onclick="window.location='request.php?id=7'">→</button><br><br>
	8. Количество исторических личностей, родившихся в заданный период. <button class="obuttons" onclick="window.location='request.php?id=8'">→</button><br><br>
	9. В скольких исторических событиях принимала участие каждая историческая личность. <button class="obuttons" onclick="window.location='request.php?id=9'">→</button><br><br>
	10. В скольких боях принимала участие каждая страна. <button class="obuttons" onclick="window.location='request.php?id=10'">→</button><br><br>
	11. Государство принимавшее участие в наибольшем количестве битв. <button class="obuttons" onclick="window.location='request.php?id=11'">→</button><br><br>
	12. Историческая личность правившая наибольшее количество раз. <button class="obuttons" onclick="window.location='request.php?id=12'">→</button><br><br>
	13. Для каждой войны определить битву в которой участвовало наибольшее число войск. <button class="obuttons" onclick="window.location='request.php?id=13'">→</button><br><br>
	14. Для каждой исторической личности определить первое историческое событие в котором она принимала участие. <button class="obuttons" onclick="window.location='request.php?id=14'">→</button><br><br>
	15. Исторические личности, которые не участвовали в исторических событиях после заданного года. <button class="obuttons" onclick="window.location='request.php?id=15'">→</button><br><br>
	16. Исторические личности, которые не правили в заданный период. <button class="obuttons" onclick="window.location='request.php?id=16'">→</button><br><br>
	17. Страна принявшая участие в наибольшем/наименьшем количестве боёв. <button class="obuttons" onclick="window.location='request.php?id=17'">→</button><br><br>
	18. Историческая личность принимавшая участие в наибольшем/наименьшем количестве исторических событий. <button class="obuttons" onclick="window.location='request.php?id=18'">→</button><br><br>
	<?php
		if($_SESSION['usertype']==2) echo '19. Оставить самому активному пользователю комментарий. <button class="obuttons" onclick="window.location=\'request.php?id=19\'">→</button><br><br>
		20. Пользователю с наименьшим числом записей в журнале оставить соответствующий комментарий. <button class="obuttons" onclick="window.location=\'request.php?id=20\'">→</button><br><br>';
	?>
</div>
