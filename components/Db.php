<?php
namespace components;

class Db {

    public static function getConnection(){
         
        $paramsPath = ROOT.'/config/db_params.php';
        $params = include ($paramsPath);
        $params = array(
            'host' => 'localhost',
            'dbname' => 'bwtreg_db',
            'user' => 'root',
            'password' => '25021973'
        );
        
        $dsn = "mysql:host={$params['host']};dbname={$params['dbname']}";
        $db = new \PDO($dsn,$params['user'],$params['password']);

        $db->exec("set names utf8");
        return $db;
    }

}

