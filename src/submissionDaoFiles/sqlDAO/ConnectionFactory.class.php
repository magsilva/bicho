<?php
//require_once(__DIR__ . '/ConnectionProperty.class.php');

class ConnectionFactory{
	
	static public function getConnection(){
		$connectionProperty = new ConnectionProperty();
		$host = $connectionProperty->getHost();
		$user = $connectionProperty->getUser();
		$database = $connectionProperty->getDatabase();
		$port = $connectionProperty->getPort();
		$password = $connectionProperty->getPassword();

		$conn = pg_connect("host=" . $host . " port=". $port . " dbname=" . $database . " user=" . $user . " password=" .$password)
		        or die("Não foi possível conectar\n");
		
		return $conn;
	}

	static public function getClose($connection){
		pg_close($connection);
	}
}
?>