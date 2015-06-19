<?php
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            # Linking front docker containt to mysql containers creates env
            # var MYSQL_PORT_3306_TCP_ADDR
            'dsn' => 'mysql:host='.getenv(MYSQL_PORT_3306_TCP_ADDR).';dbname=yii2db',
            'username' => 'admin',
            'password' => 'password',
            'charset' => 'utf8',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
    ],
];
