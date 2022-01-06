<?php 

require('secret.php');

class DB_Admin{

    private static function connection(){
        global $ADMIN_SECRET_KEYS;
        $username=$ADMIN_SECRET_KEYS['username'];
        $password=$ADMIN_SECRET_KEYS['password'];
        $host="127.0.0.1";
        $db="HovesAdmin";
        $pdo = new PDO("mysql:dbname=$db;host=$host", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    }
    public static function mkDB($DB_Name){
        global $ADMIN_SECRET_KEYS;
        $pdo = new PDO("mysql:host=127.0.0.1", $ADMIN_SECRET_KEYS['username'], $ADMIN_SECRET_KEYS['password']);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = 'CREATE DATABASE IF NOT EXISTS '.$DB_Name.';';
        $pdo->exec($query);
    }
    public static function exFile($sql){
        $auth = self::connection();
        $qr = $auth->exec($sql);
    }
    public static function query($query, $params = array()){
        $stat = self::connection()->prepare($query);
        $stat->execute($params);
        if(explode(" ", $query)[0] == 'SELECT'){
            $data = $stat->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }else{
            return 1;
        }
    }
}

class DB{

    public $database;

    function __construct($init_parameter) {
        global $database;
        $database = $init_parameter;
    }
    private static function connection(){
        global $ADMIN_SECRET_KEYS;
        global $database;
        $username=$ADMIN_SECRET_KEYS['username'];
        $password=$ADMIN_SECRET_KEYS['password'];
        $host="127.0.0.1";
        $db=$database;
        $pdo = new PDO("mysql:dbname=$db;host=$host", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    }
    public static function exFile( $sql){
        $auth = self::connection();
        $qr = $auth->exec($sql);
    }
    public static function query( $query, $params = array()){
        $stat = self::connection()->prepare($query);
        $stat->execute($params);
        if(explode(" ", $query)[0] == 'SELECT'){
            $data = $stat->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }else{
            return 1;
        }
    }
}