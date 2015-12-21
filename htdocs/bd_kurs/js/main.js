$(document).ready(function(){
    $("#signup").click(function () {
        $("#popup").fadeIn(500);
    });

    $("#close_popup").click(function () {
        $("#popup").fadeOut(500);
    });
    $(".menuButton").click(function () {
        $('.menuButton').not(this).css("background", "#00BCD4");
        $(this).css("background", "#E0F7FA");
    });
    $("#mainButton").trigger("click");
});

function confirmReg() {
    var Login=document.getElementById('regLogin').value;
    var Password=document.getElementById('regPassword').value;
    var PasswordConfirm=document.getElementById('regPasswordConfirm').value;
    if (Login==""||Password==""||PasswordConfirm=="") alert("Заполните все поля!");
    else {
        if (Login.match(/^[a-z0-9]+$/i)&&Password.match(/^[a-z0-9]+$/i)) {
            if (Password==PasswordConfirm) {
                $.ajax({
                    method: 'get',
                    url: 'regLogController.php?register',
                    data: {
                        'Login': Login,
                        'Password': Password
                    },
                    success: function(data) {
                        if (data==1) {
                            alert("Регистрация успешна!");
                            $("#popup").fadeOut(500);
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

function confirmRegWorker() {
    var Login=document.getElementById('regLogin').value;
    var Password=document.getElementById('regPassword').value;
    var PasswordConfirm=document.getElementById('regPasswordConfirm').value;
    var WorkerCode=document.getElementById('regWorkerCode').value;
    if (Login==""||Password==""||PasswordConfirm==""||WorkerCode=="") alert("Заполните все поля!");
    else {
        if (Login.match(/^[a-z0-9]+$/i)&&Password.match(/^[a-z0-9]+$/i)) {
            if (Password==PasswordConfirm) {
                $.ajax({
                    method: 'get',
                    url: 'regLogController.php?register',
                    data: {
                        'Login': Login,
                        'Password': Password,
                        'WorkerCode': WorkerCode
                    },
                    success: function(data) {
                        if (data==1) {
                            alert("Регистрация успешна!");
                            $("#popup").fadeOut(500);
                            location.reload();
                        }
                        if (data==2) {
                            alert("Регистрация успешна!");
                            $("#popup").fadeOut(500);
                            window.location.assign('/bd_kurs');
                        }
                        if (data==-1) alert("Такой логин уже зарегистрирован!");
                        if (data==-2) alert("Неверный код работника!");
                    }
                });
            }
            else alert("Пароли должны совпадать!");
        }
        else alert("Поля могут содержать только цифры и латинские буквы!");
    }
}

function signIn() {
    var Login=document.getElementById('fieldLogin').value;
    var Password=document.getElementById('fieldPassword').value;
    if (Login==""||Password=="") alert("Заполните все поля!");
    else {
        $.ajax({
            method: 'get',
            url: 'regLogController.php?signin',
            data: {
                'Login': Login,
                'Password': Password
            },
            success: function(data) {
                if (data==1) location.reload();
                if (data==-1) alert("Неправильный логин/пароль!");
            }
        });
    }
}

function signOut() {
    $.ajax({
        method: 'get',
        url: 'regLogController.php?signout',
        success: function() {
            location.reload();
        }
    });
}

function pushMenu(id) {
    $("#content").hide();
    switch(id) {
        case 1:
            $("#content").load("pages/menu-main.php");
            break;
        case 2:
            $("#content").load("pages/menu-countries.php");
            break;
        case 3:
            $("#content").load("pages/menu-government.php");
            break;
        case 4:
            $("#content").load("pages/menu-persons.php");
            break;
        case 5:
            $("#content").load("pages/menu-events.php");
            break;
        case 6:
            $("#content").load("pages/menu-battles.php");
            break;
        case 7:
            $("#content").load("pages/menu-eventsparticipant.php");
            break;
        case 8:
            $("#content").load("pages/menu-battlesparticipant.php");
            break;
        case 9:
            $("#content").load("pages/menu-requests.php");
            break;
        case 10:
            $("#content").load("pages/menu-journal.php");
            break;
    }
    $("#content").fadeIn(500);
}