<!DOCTYPE html>
<html>
<head>
	<title>Чат-бот</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<!-- <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet"> -->
</head>
<body>
	<section id="bot-window">
		<header id="hbot">
			<h3>Бот</h3>
		</header>
		<div id="bot-main"> <!--  Диалоговое окно -->
			<div id="bot-message"><!--  Самое первое сообщения от бота -->
				
					<h3>Здравствуйте, я бот! Могу помочь вам с </h3><br><br>
					<h3>1 - Поиск и показ(предоставление) товара </h3><br><br>
					<h3>2 - Консультация о подборе образа: введите артикул товара или наименование, цвет и фасон </h3><br><br>
					<h3 onclick="getResponse('акци')" style="cursor: pointer;">3 - Уведомление об акциях</h3><br><br><!-- Вещаем на пункт js событие onclick которые срабатывает при нажатие на пункт и тогда вызывает функция getResponse с входным параметром 'акци' (функция описана ниже) точно так-же это работает с пунктами преведенными ниже -->
					<h3 onclick="getResponse('режим')" style="cursor: pointer;">4 - Режим работы </h3><br><br>
					<h3 onclick="getResponse('возврат')" style="cursor: pointer;">5 - Помощь в послепродажной процедуре </h3><br><br>
					<h3>6 - Уход за вещами. Введите наименование товара или состав ткани </h3><br><br>
					<h3 onclick="getResponse('отзыв')" style="cursor: pointer;">7 - Оставить отзыв</h3><br><br>
					<h3 onclick="getResponse('скидк')" style="cursor: pointer;">8 - Скидки</h3>
				
			</div>
		</div>
		<footer id="bot-footer">
			<textarea rows="4" cols="40" id="textarea-bot" keydown></textarea>
			<button onClick=getResponse() style="float: right;">Отправить</button>
		</footer>
	</section>
</body>
 <script src="http://code.jquery.com/jquery-latest.js"></script><!-- Подключение JQuery библиотеки -->
<script>
function getResponse( message=null ){//Создаем функцию с необязательным параметром message 
	if(message != null)//если message != null(тоесть входной параметр был отправлен) значит отправляем сразу нужную нам фразу на сервер без ввода сообщения пользователем (для того что-бы можно было по клику на пункт получить интересующию информацию)
		var userMessage = message;//Присваиваем переменной userMessage значения нашего входного параметра
	else{//Иначе
    	var userMessage = $('#textarea-bot').val();//Присваиваем переменной userMessage значения сообщения отправленного пользователем из text-area
    	addUserMessage();//Печатаем сообщения пользователя в диалоговом окне
	}
    
    $.ajax({//Создаем ajax объект с помошью глобального объета $ библиотеки JQuery
        type: "POST",//Задаем метод передачи данных на сервер
        url: "bot.php",//Указываем адресс файла на которые отправляются данные
        data: {message:userMessage}//Серриализуем переменные
    }).done(function( answer )//При успещном ответе оо сервера вызывается обратная функция которая принимает в себя параметр answer
        {
            $("#bot-main").append("<div id='bot-message'><h4>" + answer + "</h4><div>");//С помощью $ JQuery объекта выбираем div с id = bot-main (диалоговое окно) и вставляем туда ответ от бота (answer это тот ответ который вернул нам сервер)
            var textscroll = document.getElementById("bot-main");//Выбираем div который отображает диалоговое окно с ботом
    		textscroll.scrollTop = textscroll.scrollHeight;//Каждый раз при получение ответа прижимаем scroll-bar в самый низ
        });
    	var textscroll = document.getElementById("bot-main");//Выбираем div который отображает диалоговое окно с ботом
    	textscroll.scrollTop = textscroll.scrollHeight;//Каждый раз при отправке сообщения прижимаем scroll-bar в самый низ
    	setTimeout('document.getElementById("textarea-bot").value = ""', 1);//Через 1 мс после отправки сообщения отчищаем textarea
}

function addUserMessage() {//Функция отправки сообщения в диалоговое окно
	var message = $('#textarea-bot').val();//получаем данные их textarea
	$("#bot-main").append("<div id='user-message'><h4>" + message + "</h4><div>");//Добавляем сообщения в окно диалога
	$('#textarea-bot').val('');//Отчищаем textarea
}

document.getElementById('textarea-bot').onkeypress = function(e) {//Привязываем событие нажатия клавиши когда textarea имеет фокус пользователя и инициализируем функция обратного вызова которая принимает параметр e отвечающий за код нажатой клавиши в фокусе
	if(e.keyCode == 13){//через метод keyCode проверяем код клавиши и если она равняется 13 (нажата клавиша Enter) то вызываем функцию отправки данных на сервер
		getResponse();//Функция описана выше
	}
}
</script>
</html>