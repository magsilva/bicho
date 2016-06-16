<?php
 //require_once( . '/private/conf.php');

class ConnectionProperty{
	private static $host;
	private static $user;
	private static $password;
	private static $database;
	private static $port;

	function __construct() {
		$conf = globalconf();
		ConnectionProperty::$host = $conf['dbhost'];
		ConnectionProperty::$user = $conf['dbuser'];
		ConnectionProperty::$password = $conf['dbpass'];
		ConnectionProperty::$database = $conf['dbname'];
		ConnectionProperty::$port = $conf['dbport'];

	}

	public static function getHost(){
		return ConnectionProperty::$host;
	}

	public static function getUser(){
		return ConnectionProperty::$user;
	}

	public static function getPassword(){
		return ConnectionProperty::$password;
	}

	public static function getDatabase(){
		return ConnectionProperty::$database;
	}

	public static function getPort(){
		return ConnectionProperty::$port;
	}
}
?>