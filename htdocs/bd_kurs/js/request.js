$( window ).load(function() {
    switch (id) {
        case 1:
            $('#request-text').append("События в которых принимала участие историческая личность: ");
            $('#request-text').append('<input id="request-input" class="ofields" style="margin-left: 10px;">');
            break;
        case 2:
            $('#request-text').append("Правители державы: ");
            $('#request-text').append('<input id="request-input" class="ofields" style="margin-left: 10px;">');
            break;
        case 3:
            $('#request-text').append("Исторические личности, чьи имена начинаются на букву: ");
            $('#request-text').append('<input id="request-input" class="ofields" style="margin-left: 10px;">');
            break;
        case 4:
            $('#request-text').append("Страны, названия которых начинаются на букву: ");
            $('#request-text').append('<input id="request-input" class="ofields" style="margin-left: 10px;">');
            break;
        case 5:
            $('#request-text').append("Исторические события, начавшиеся в заданный период: ");
            $('#request-text').append('<input id="request-input1" class="ofields" style="margin-left: 10px;width: 50px;">');
            break;
        case 6:
            $('#request-text').append("Битвы, проходившие в заданный период: ");
            $('#request-text').append('<input id="request-input1" class="ofields" style="margin-left: 10px;width: 50px;">');
            break;
        case 7:
            $('#request-text').append("Количество битв, прошедших в заданный период: ");
            $('#request-text').append('<input id="request-input1" class="ofields" style="margin-left: 10px;width: 50px;">');
            break;
        case 8:
            $('#request-text').append("Количество исторических личностей, родившихся в заданный период: ");
            $('#request-text').append('<input id="request-input1" class="ofields" style="margin-left: 10px;width: 50px;">');
            break;
        case 9:
            $('#request-text').append("В скольких исторических событиях принимала участие каждая историческая личность: ");
            break;
        case 10:
            $('#request-text').append("В скольких боях принимала участие каждая страна: ");
            break;
        case 11:
            $('#request-text').append("Государство принимавшее участие в наибольшем количестве битв: ");
            break;
        case 12:
            $('#request-text').append("Историческая личность правившая наибольшее количество раз: ");
            break;
        case 13:
            $('#request-text').append("Для каждой войны определить битву в которой участвовало наибольшее число войск: ");
            break
        case 14:
            $('#request-text').append("Для каждой исторической личности определить первое историческое событие в котором она принимала участие: ");
            break;
        case 15:
            $('#request-text').append("Исторические личности, которые не участвовали в исторических событиях после заданного года: ");
            $('#request-text').append('<input id="request-input" class="ofields" style="margin-left: 10px;width: 50px;">');
            break;
        case 16:
            $('#request-text').append("Исторические личности, которые не правили в заданный период: ");
            $('#request-text').append('<input id="request-input1" class="ofields" style="margin-left: 10px;width: 50px;">');
            break;
        case 17:
            $('#request-text').append("Страна принявшая участие в наибольшем/наименьшем количестве боёв: ");
            break;
        case 18:
            $('#request-text').append("Историческая личность принимавшая участие в наибольшем/наименьшем количестве исторических событий: ");
            break;
        case 19:
            $('#request-text').append("Оставить самому активному пользователю комментарий: ");
            break;
        case 20:
            $('#request-text').append("Пользователю с наименьшим числом записей в журнале оставить соответствующий комментарий: ");
            break;
        default:
            break;
    }
    switch (id){
        case 1:
        case 2:
        case 3:
        case 4:
        case 15:
            $('#request-text').append('<button onclick="makeRequest1_4(' + id + ')" class="obuttons" style="margin-left: 10px;margin-top:0;">Выполнить</button>');
            break;
        case 5:
        case 6:
        case 7:
        case 8:
        case 16:
            $('#request-text').append('<input id="request-input2" class="ofields" style="margin-left: 10px;width: 50px;">');
            $('#request-text').append('<button onclick="makeRequest5_8(' + id + ')" class="obuttons" style="margin-left: 10px;margin-top:0;">Выполнить</button>');
            break;
        case 9:
        case 10:
        case 11:
        case 12:
        case 13:
        case 14:
        case 17:
        case 18:
        case 19:
        case 20:
            $('#request-text').append('<button onclick="makeRequestOther(' + id + ')" class="obuttons" style="margin-left: 10px;margin-top:0;">Показать</button>');
            break;
        default:
            break;
    }
});

function makeRequest1_4(idR) {
    var cond = document.getElementById('request-input').value;
    $.ajax({
        method: 'get',
        url: 'requestsController.php?get'+idR,
        data: {
          condition: cond
        },
        success: function(data) {
            if (data==-1) document.getElementById('request-result').innerHTML = "Результатов нет.";
            else {
                var s = data.toString();
                s = s.substr(0, s.length - 2);
                document.getElementById('request-result').innerHTML = s + ".";
            }
        }
    });
}

function makeRequest1_4(idR) {
    var cond = document.getElementById('request-input').value;
    if (cond=="") alert("Поле не может быть пустым!");
    else {
        $.ajax({
            method: 'get',
            url: 'requestsController.php?get' + idR,
            data: {
                condition: cond
            },
            success: function (data) {
                if (data == -1) document.getElementById('request-result').innerHTML = "Результатов нет.";
                else {
                    var s = data.toString();
                    s = s.substr(0, s.length - 2);
                    document.getElementById('request-result').innerHTML = "Результат: " + s + ".";
                }
            }
        });
    }
}

function makeRequest5_8(idR) {
    var cond1 = document.getElementById('request-input1').value;
    var cond2 = document.getElementById('request-input2').value;
    $.ajax({
        method: 'get',
        url: 'requestsController.php?get'+idR,
        data: {
            condition1: cond1,
            condition2: cond2
        },
        success: function(data) {
            if (data==-1) document.getElementById('request-result').innerHTML = "Результатов нет.";
            else {
                var s = data.toString();
                if (idR==5||idR==6||idR==16) s = s.substr(0, s.length - 2);
                document.getElementById('request-result').innerHTML = "Результат: " + s + ".";
            }
        }
    });
}

function makeRequestOther(idR) {
    $.ajax({
        method: 'get',
        url: 'requestsController.php?get'+idR,
        success: function(data) {
            if (data==-1) document.getElementById('request-result').innerHTML = "Результатов нет.";
            else {
                var s = data.toString();
                if (idR==9||idR==10||idR==13||idR==14) s = s.substr(0, s.length - 1);
                document.getElementById('request-result').innerHTML = "Результат: " + s + ".";
            }
        }
    });
}