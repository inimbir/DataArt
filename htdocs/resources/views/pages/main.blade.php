	<div id="page-preloader"><span class="spinner"></span></div>

	<div id="map">

	</div>
	<div id="fullPhoto"><img></div>
	<div id="list">
		<img id="closeList" src="img/closeList.png"></img>
		<br>
		<div id="placingTip"></div>
		<div id="newRestInfo"></div>
		<div id="RestInfo" style="word-wrap: break-word;"></div>
		<div class="container" style="text-align:center; width: 75%">
			<div id='slider' style='background: rgba(255, 255, 255, 1);'>
				<ul>
				</ul>
			</div>
		</div>
		<?php
		if(isset($usertype)&&$usertype==1) echo '<button style="margin-top:5px;float:none;" id="addPhoto" class="signbutton" onclick="$callUpload()">Добавить фото</button>';
		if(isset($username)) echo '<div id="userLabel" style="width: 100%;text-align:center;"><input class="userLabelText" type="text" placeholder="Что вы думаете об этом ресторане?"><br></div>';
		else echo '<div id="userLabel" style="visibility: hidden;">0</div>'
		?>
		<br>
		<div id="marks" class="container-fluid">
            <div class="row">
                <div class="crit col-xs-9 col-md-6">
                    <p id="general" class="p-crit">
                    Общая
                    </p>
                    <p id="kitchen" class="p-crit">
                    Кухня
                    </p>
                    <p id="interior" class="p-crit">
                    Интерьер
                    </p>
                    <p id="service" class="p-crit">
                    Сервис
                    </p>
                </div>
                <div class="stars col-xs-9 col-md-6">
                    <center id="general-stars" class="p-stars">
                    </center>
                    <center id="kitchen-stars" class="p-stars">
                    </center>
                    <center id="interior-stars" class="p-stars">
                    </center>
                    <center id="service-stars" class="p-stars">
                    </center>
                </div>
            </div>
        </div>
		<div id="RestReview"></div>
		<?php
		if(isset($usertype)&&$usertype==1) echo '<button style="margin-top:5px;float:none;" id="editReview" class="signbutton" onclick="editReview()">Изменить рецензию</button><button style="margin-top:5px;float:none;" id="saveReview" class="signbutton" onclick="saveReview()">Сохранить</button>';
		?>
		<div id="ShareDiv">
			<br>
			Поделиться рецензией:
			<a onclick="shareVK()"><img style="width: 35px;" src="img/share/logo_vk.png"></a>
			<a onclick="shareFB()"><img style="width: 35px;" src="img/share/logo_fb.png"> </a>
			<a onclick="shareTW()"><img style="width: 35px;" src="img/share/logo_tw.png"></i></a>
		</div>
		<?php
		if(isset($usertype)&&$usertype==1) echo '<button style="margin-top:20px;float:none;" class="signbutton" onclick="deleteRest()">Удалить ресторан</button>';
		?>
	</div>

	<input style="width:0px;height:0px;" type="file" id="Upload" onChange="uploadPhoto()" accept="image/*" tabindex="-1">
	<script type="text/javascript" src="js/jquery-1.11.3.js"></script>
	<script type="text/javascript" src="js/slider.js"></script>
	<script type="text/javascript" src="js/sharing.js"></script>
	<script type="text/javascript" src="js/main.js"></script>
	<script defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDE0G3dQnsjvZCkTF_6KR48M6hcN-8HuBM&callback=startMap"></script>