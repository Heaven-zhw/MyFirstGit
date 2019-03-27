<?php
/*
define('DB_HOST','10.245.144.96');
define('DB_USER','user');
define('DB_PWD','123456');
*/
define('DB_HOST','127.0.0.1');
define('DB_USER','root');
define('DB_PWD','root');
define('DB_CHARSET','utf8');
define('DB_DBNAME','stusystem');

define('MYSQL_EXE',"D:\phpStudy\PHPTutorial\MySQL\bin\mysql");//MySQL.exe的位置，注意斜线方向
define('MYSQLDUMP_EXE',"D:\phpStudy\PHPTutorial\MySQL\bin\mysqldump");//MySQLDump的位置，注意斜线方向
define('BACKUP_PATH',"F:/mysqlbackup/"); //备份文件路径，注意斜线方向


$config = array(
    'host'=>DB_HOST,
    'user'=>DB_USER,
    'password'=>DB_PWD,
    'charset'=>DB_CHARSET,
    'dbName'=>DB_DBNAME
);

