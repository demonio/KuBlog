<?php
$databases['default'] =
[
    'dsn'      => 'mysql:host=127.0.0.1:3307;dbname=wordpress;charset=utf8',
    'username' => 'root',
    'password' => '',
    'params'   =>
    [
        //PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8', //UTF8 en PHP < 5.3.6
        PDO::ATTR_PERSISTENT => true,
        PDO::ATTR_ERRMODE    => PDO::ERRMODE_EXCEPTION,
    ],
];

return $databases; //Siempre al final
