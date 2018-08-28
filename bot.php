<?php
sleep(1);
global $color,$clothe,$isReview;//Создаем глобальные переменные которые далее будут хранить цвет и тип вещи, isReview если пользователь хочет оставить отзыв становится true
$isReview = false;
$workTime = "режим/работ";//Строка которая содержит корни слов на которые бот ответит про работу
$workTimeAnswer = explode("/",$workTime);//Составляем массив с помощью функции php explode который разделяет строку с корнями через разделитель (в нашем случае это слэш /) получается что $workTimeAnswer[0] = режим а $workTimeAnswer[1] = работ

$afterSale = "возврат/верну";//Строка которая содержит корни слов на которые бот ответит про возврат
$afterSaleAnswer = explode("/",$afterSale);//Функция explode описанная выше

$clothes = "пухов/футболк/джинс/кофт";//Строка которая содержит корни слов одежды
$clothesAnswer = explode("/", $clothes);//Функция explode описанная выше

$colors = "бел/черн/син/красн";//Строка которая содержит корни слов цвета одежды
$colorsMass = explode("/", $colors);//Функция explode описанная выше

$fabric_structure = "хлоп/пух/джинс";//Строка которая содержит корни слов состава ткани
$fabric_structureAnswer = explode("/",$fabric_structure);

$request = mb_strtolower($_POST['message']);//С помощью функции mb_strtolower приводим входящее сообщение от пользователя в нижний регистр это нужно для того что-бы не имело значение в каком регистре пользователь ввел сообщения тоесть между ФутБоЛка и футболка не будет разницы
$requestMass = explode(" ", $request);//Разбиваем входящюю строку от пользователя функцией explode в данном случае разделителем является пробел

// for($i = 0; $i < count($colorsMass); $i++){
// 	if(stristr($request, $colorsMass[$i]) !== false){
// 		 $boof = stristr($request, $colorsMass[$i]);
// 		 echo $color = stristr($boof, $colorsMass[$i]);
// 		 $color = stristr($boof, $colorsMass[$i],true);
// 		for($j = 0; $j < count($clothesAnswer); $j++)
// 		if(stristr($boof, $clothesAnswer[$j]) !== false){
// 			$clothe = stristr($boof, $clothesAnswer[$j]);
// 			//$clothe = stristr($clothe, $clothesAnswer[$j],true);
// 			$color = stristr($boof, $clothesAnswer[$j],true);
// 			//echo $color;
// 			//echo $clothe;
// 		}
// 		return 0;
// 	}
// }
//writeReview($isReview,$requestMass);

if(stristr($request, ":") !== false){//Проверяем во входящем сообщение присутствие двоеточия
	writeReview($requestMass);
	return 0;
}

for($i = 0; $i < count($colorsMass); $i++){//Перебираем массив который содержит искомые нами цвета
	if(stristr($request, $colorsMass[$i]) !== false){//ищем вхождения подстроки $colorsMass[$i] в строке которую нам отправил пользователь
		$colorL = stristr($request, $colorsMass[$i]);//Запоминаем строку начинающуюся с интересующего нас цвета
		strripos($colorL, $colorsMass[$i]);//Находим позицию начала вхождения искомого цвета в строке содержащей искомый цвет
		$color = substr($colorL, 0,strlen($colorsMass[$i]));//Выделяем из строки $colorL точное значение нашего цвета
		for($j = 0; $j < count($clothesAnswer); $j++){//Перебираем массив который содержит искомые нами вещи
			if(stristr($request, $clothesAnswer[$j]) !== false){//ищем вхождения подстроки $clothesAnswer[$i] в строке которую нам отправил пользователь
				$clothesL = stristr($request, $clothesAnswer[$j]);//запоминаем строку начинающуюся с искомой нами одежды
				strripos($clothesL, $clothesAnswer[$j]);//Находим позицию начала вхождения искомой нами вещи в строке содержащей нащ цвет
				$clothe = substr($clothesL, 0,strlen($clothesAnswer[$j]));//выделяем точное значение искомой вещи
			}
		}
		require_once 'botbdconnection.php';//подключаемся к БД
		$query1 = $bd->query("SELECT *  FROM product WHERE lower(color) LIKE '$color%' AND product.id_clothes in (SELECT id_clothes from clothes WHERE lower(name_clothes) like '$clothe%')");//отправляем запрос к бд с типом вещи и ее цветом
		if($query1->num_rows == 0 || $clothe == "" || $color == ""){//если запрос вернул 0 строк сообщаем пользователю что одежды по его запросу нету
			echo "Извините по ващему запросы нету одежды";
		}
		else//иначе выдаем ссылку на таблицу в которой параметрами color указываем цвет а clothe указываем тип вещи
			echo "<a href='http://localhost/botfreelance/showproduct.php?color=$color&clothe=$clothe'>Я подобрал для вас вещи</a>";
		return 0;
	}
}

for($i = 0; $i < count($workTimeAnswer); $i++){//Перебираем массив содержащий на какие вопросы нам ответить про место и время работы
	if(stristr($request, $workTimeAnswer[$i]) !== false){//если что-то из массива содержится в строке которую нам прислала пользователь отвечаем ему
		echo "г. Иркутск, ул. Ленина, дом 86 время работы с 10-20:00";
		return 0;
	}
}

for($i = 0; $i < count($afterSaleAnswer); $i++){//перебираем массив который содержит корни на которые бот должен ответить про возврат
	if(stristr($request, $afterSaleAnswer[$i]) !== false){
		echo "Возврат оформляется не позднее 14 дней с момента покупки";
		return 0;
	}
}

for($i = 0; $i < count($fabric_structureAnswer); $i++){//Перебираем массив содержащий наш список тканей
	if(stristr($request, $fabric_structureAnswer[$i]) !== false){//проверям есть ли что-то  из списка в строке отправленной пользователем
		require_once 'botbdconnection.php';//подключаемся к бд
		$structureL = stristr($request, $fabric_structureAnswer[$i]);//запоминаем строку которая начинается с искомой ткани
		strripos($structureL, $fabric_structureAnswer[$i]);//находим позицию вхождения искомой ткани в строке
		$structure = substr($structureL, 0,strlen($fabric_structureAnswer[$i]));//записываем искомую ткань из строки
		$query3 = $bd->query("SELECT structure_name, care  FROM fabric_structure WHERE lower(structure_name) like '$structure%'") or die("Ошибка ".mysqli_error($bd));//делаем запрос к базе данных ищем ткань
		$res = $query3->fetch_assoc();//запоминаем объект запроса как ассоциативный массив
		echo $res["structure_name"]." советы по уходу ".$res["care"];//выводим ответ
		return 0;
	}
}

if(stristr($request, "отзыв") !== false){//если в строке пользователя есть слово отзыв записываем всю строку в файл отзывов
	//writeInFile("отзыв.txt",$request);
	echo "Оставьте отзыв в формате Фамилия Имя: ваш отзыв!";
	return 0;
}

if(stristr($request, "привет") !== false){//отвечаем на слово привет
	echo "Здравствуйте! Чем могу помочь?";
	return 0;
}

if(stristr($request, "акци") !== false){//если в строке пользователя находится слово акци
	require_once 'botbdconnection.php';//подключаемся к бд
	$query = $bd->query("SELECT * FROM stock");//отправляем запрос к таблице содержащей скидки
	if($query){//если запрос корректно отработал
		$i = 1;
		while($answers = $query->fetch_assoc()){//пока не кончится количество строк разбиваем их на ассоциативный массив
			echo $i.". ".$answers["name"]."<br><br>"." ".$answers["stock_text"]."<br><br>";//выводим каждую строку
			$i++;
		}
	}
	else
		echo "К сожалению у нас сейчас нет акций";//если акций на данный момент нету
	return 0;
}

if(stristr($request, "скидк") !== false){//проверяем пользовательскую строку на запрос по скидкам
	require_once 'botbdconnection.php';
	$query2 = $bd->query("SELECT new_price FROM product WHERE  product.new_price != 0");//отправляем запрос к БД который ишет товары у которых новая цена не равна 0 (тоесть есть скидка)
	if($query2->num_rows == 0)
		echo "На данный момент товаров со скидкой нет";
	else
		echo "<a href='http://localhost/botfreelance/showproduct.php?new_price=true'>Товары со скидкой для вас</a>";//если такие есть выдает ссылку на таблицу и передает параметр new_price=true который говорит таблице искать товары со скидкой
	return 0;
}


function writeInFile($filename,$message)//Функция записи в файл
{
	$fo = fopen($filename,'a');//открываем файл для записи
	$writeInFile = fwrite($fo, $message." ".date("d-m-Y H:i:s").PHP_EOL);//записываем сообщение и добовляем к ней дату, php_eol перенести курсор в файле на новую строку
	fclose($fo);//закрываем файл
}

function writeReview($message)
{
		$message[1] = trim($message[1],":");//Удаляем из сообщения :
		$fio = $message[0]." ".$message[1];//Конкатинация фамилии и имя
		unset($message[0]);//Удаляем фамилию из массива
		unset($message[1]);//Удаляем имя из массива
		$message = implode(" ", $message);//объединяем массив в строку
		require_once "botbdconnection.php";//подключаемся к бд
		$query = $bd->query("INSERT INTO review VALUES (null,'$fio','$message')") or die("Ошибка ".mysqli_error($bd));//записываем в бд
		$isReview = false;
		echo "Спасибо за ваш отзыв!";
}

echo "Ой, извините, не могу вас понять";//Если не одно из условий нам не подошло то бот не понимает что от него хотят
?>