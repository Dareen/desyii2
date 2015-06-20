<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host='.getenv(MYSQL_PORT_3306_TCP_ADDR).';dbname=yii2db',
    'username' => 'admin',
    'password' => 'password',
    'charset' => 'utf8',
];
