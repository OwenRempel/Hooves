<?php 
require_once("Database/DB.php");
header('Content-Type: application/json; charset=utf-8');

if(!is_file('Build/Built')){
    DB_Admin::mkDB('HovesAdmin');
    DB_Admin::exFile(file_get_contents('Database/sql/admin.sql'));
    touch('Build/Built');
}
$url = explode('/', $_SERVER['REQUEST_URI']);
$method = $_SERVER['REQUEST_METHOD'];

$viewCheck = './Views/'.$url[0].'.php';
if(is_file($viewCheck)){
    include($viewCheck);
}
