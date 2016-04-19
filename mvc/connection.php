<?php
  class Database {
    private static $instance = NULL;

    private function __construct() {}

    private function __clone() {}

    public static function getInstance() {
	
	  // Start a PHP session
	  session_start();
	  
	  //Connect with the database:
      if (!isset(self::$instance)) {
        $pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
		$servername = "mysql.agh.edu.pl";
		$username = "jtveiro";
		$password = "D8DQmB1c";
		$dbname = "jtveiro";
        self::$instance = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password, $pdo_options);
      }
      return self::$instance;
    }
  }
?>