<?php 

namespace App;

class Test{
	public static function test(){
		echo "testy shit ";
		return 0;
	}

	public function pdo(){

	global $config;

	$host = $config['db']['host'];
    $db   = $config['db']['dbname'];
    $user = $config['db']['user'];
    $pass = $config['db']['pass'];
    $charset = 'utf8';

    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    
    $pdo = new \PDO($dsn, $user, $pass, $opt);

    return $pdo;
	}
}

?>