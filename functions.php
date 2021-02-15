<?php
	define('DB_SERVER', 'localhost:3306');
	define('DB_USERNAME', 'root');
	define('DB_PASSWORD', '');
	define('DB_DATABASE', 'dhvsu_app');
	$connection = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, );

	if($connection->connect_error) {
		die("Connection failed: " . $connection->connect_error);
	}


