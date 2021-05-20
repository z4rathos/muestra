  
<?php
header('Content-Type: application/json');
$pdo=new PDO("mysql:dbname=mp15jdb;host=localhost","mp15jdb","196798");
switch($_GET['q']){
		// Buscar Último Dato
		case 1:
		    $statement=$pdo->prepare("SELECT temperatura,humedad,motor FROM _analogos ORDER BY analogosID DESC LIMIT 0,1");
			$statement->execute();
			$results=$statement->fetchAll(PDO::FETCH_ASSOC);
			$json=json_encode($results);
			echo $json;

		break; 
		// Buscar Todos los datos
		default:
			
			$statement=$pdo->prepare("SELECT temperatura,humedad,motor FROM _analogos ORDER BY analogosID ASC");
			$statement->execute();
			$results=$statement->fetchAll(PDO::FETCH_ASSOC);
			$json=json_encode($results);
			echo $json;
		break;

}
?>