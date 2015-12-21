$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

var main = function() {
    popUp();
    $("#mapBlock").load("main");
    $("#ratingBlock").load("rating");
    $("#ratingBlock").hide();
};

function signIn() {
		var Login=document.getElementById('fieldLogin').value;
		var Password=document.getElementById('fieldPassword').value;
		if (Login==""||Password=="") alert("Заполните все поля!");
		else {$.ajax({
			method: 'post',
			url: 'signin',
			data: {
				'Login': Login,
				'Password': Password
			},
			success: function(data) {
				if (data==1) {
                    location.reload();
                }
				if (data==-1) alert("Неправильный логин/пароль!");
            },
			error: function(error) {
				alert(error);
			}
		});
	}
}

function signOut() {
		$.ajax({
			method: 'post',
			url: 'signout',
			data: {
			'ajax': true
			},
			success: function(data) {
				location.reload();
			}
		});
    }

function popUp() {
    $('#signup').click(function () {
		$('#popup').css('top', (($(window).height() - $('#popup').height())/2));
		$('#popup-back').show();
		$('#popup').fadeIn(200);
		//$('#popup').css('top', $(this).scrollTop());

	});
	$('#popup-back').click(function(){
		$('#popup-back').hide();
		$('#popup').fadeOut(250);
	});
}

function confirmReg() {
		var Login=document.getElementById('regLogin').value;
		var Password=document.getElementById('regPassword').value;
		var PasswordConfirm=document.getElementById('regPasswordConfirm').value;
		if (Login==""||Password==""||PasswordConfirm=="") alert("Заполните все поля!");
		else {
			if (Login.match(/^[a-z0-9]+$/i)&&Password.match(/^[a-z0-9]+$/i)) {
				if (Password==PasswordConfirm) {
					$.ajax({
						method: 'post',
						url: 'register',
						data: {
						'Login': Login,
						'Password': Password,
						'ajax': true
						},
						success: function(data) {
							if (data==1) {
								alert("Регистрация успешна!");
								$("#popup").hide(1000);
								location.reload();
							}
							if (data==-1) alert("Такой логин уже зарегистрирован!");
						}
					});
				}
				else alert("Пароли должны совпадать!");
			}
			else alert("Поля могут содержать только цифры и латинские буквы!");
		}
}

function setMap() {
    if ($("#mapSwitch").attr('class') == 'active') {
        return;
    }
    $("#ratingSwitch").removeClass('active');
    $("#mapSwitch").addClass('active');
    $("#ratingBlock").empty();
    $("#mapBlock").show();
    $("#addRest").show();
}

function setRating() {
    if ($("#ratingSwitch").attr('class') == 'active') {
        return;
    }
    $("#mapSwitch").removeClass('active');
    $("#ratingSwitch").addClass('active');
    $("#mapBlock").hide();
    $("#ratingBlock").load('rating');
    $("#ratingBlock").show();
    $("#addRest").hide();
}

$(document).ready(main);
