<?php
	$servername = "localhost";
	$username = "root";
	$password = "";
	try {
		$conn = new PDO("mysql:host=$servername;dbname=myDB", $username, $password);
		$resultJson = array();
		// set the PDO error mode to exception
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$conn -> exec("set names utf8");

		$stmt = $conn->prepare("SELECT * FROM establecimiento"); 
		$stmt->execute();
		foreach($stmt->fetchAll(PDO::FETCH_ASSOC) as $dato){
			$stmt2 = $conn->prepare("select tipo,imgCategoria from categoria c INNER JOIN estcat e on c.idCategoria = e.idCategoria where e.idEstablecimiento =".$dato['idEstablecimiento']);
			$stmt2->execute();
			if ($stmt2->rowCount() > 0){
				$array = array();
				foreach($stmt2->fetchAll(PDO::FETCH_ASSOC) as $dato2){
					$array[] = $dato2;
				}
				$dato['categoria'] = $array;
			}
			array_push($resultJson,$dato);
		}
		echo json_encode($resultJson);
    }catch(PDOException $e){
		echo "Connection failed: " . $e->getMessage();
    }
	$conn = null;
?>
