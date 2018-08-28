<?php
	require_once 'botbdconnection.php';
	if(isset($_GET['color']) && isset($_GET['clothe'])){
		$color = $_GET['color'];
		$clothe = $_GET['clothe'];
	}
	if(isset($_GET['new_price']) && $_GET['new_price'] == true){
		$query = $bd->query("SELECT clothes.name_clothes, firm.name_firm,season.name_season,product.color, product.fabric_structure, product.discription, fabric_structure.structure_name, product.new_price,product.price,product.image FROM product,clothes,firm,season,fabric_structure WHERE clothes.id_clothes = product.id_clothes and product.id_firm = firm.id_firm and product.id_season = season.id_season and new_price > 0");
	}
	else
		$query = $bd->query("SELECT clothes.name_clothes, firm.name_firm,season.name_season,product.color, product.price, product.fabric_structure, product.discription, fabric_structure.structure_name, product.new_price, product.image FROM product,clothes,firm,season,fabric_structure WHERE clothes.id_clothes = product.id_clothes and product.id_firm = firm.id_firm and product.id_season = season.id_season and lower(color) LIKE '$color%' AND product.id_clothes in (SELECT id_clothes from clothes WHERE lower(name_clothes) like '$clothe%')") or die ("Ошибка ".mysqli_error($bd));
?>
<!DOCTYPE html>
<html>
<head>
	<title>Подобранные вещи</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
	<table>
		<th>Тип одежды 
		</th>
		<th>Фирма 
		</th>
		<th>Сезон 
		</th>
		<th>Цвет
		</th>
		<th>Ткань
		</th>
		<th>Цена 
		</th>
		<th>Описание</th>
		<th>Картинка</th>
		<?php foreach($query as $value): ?>
			<tr>
			<td><?= $value["name_clothes"]; ?></td>
			<td><?= $value["name_firm"]; ?></td>
			<td><?= $value["name_season"]; ?></td>
			<td><?= $value["color"]; ?></td>
			<td><?= $value["structure_name"]; ?></td>
			<td><?php if(isset($value['new_price']) && $value['new_price'] > 0){ echo $value["new_price"]." (скидка составляет ".(string)((int)$value["price"] - (int)$value["new_price"]).")"; }  else echo $value["price"];  ?></td>
			<td><?= $value["discription"]; ?></td>
			<td><img src="<?= $value['image']; ?>"></td>
		<?php endforeach; ?>
	</table>
</body>
</html>