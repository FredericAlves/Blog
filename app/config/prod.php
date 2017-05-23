<?php
// Doctrine (db)
$app['db.options'] = array(
    'driver'   => 'pdo_mysql',
    'charset'  => 'utf8',
    'host'     => 'localhost',
    'port'     => '3306',
    'dbname'   => 'Blog',
    'user'     => 'blog_db_user',
    'password' => 'blog_db_user_pwd',
);