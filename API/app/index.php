<?php 
require_once("Database/DB.php");

if(!is_file('Build/Built')){
    DB_Admin::mkDB('HovesAdmin');
    DB_Admin::exFile(file_get_contents('Database/sql/admin.sql'));
    touch('Build/Built');
}