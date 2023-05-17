<?php
$install = 'zainstalowana';

define('DB_HOST', 'localhost');
define('DB_USER', '1079133');
define('DB_PASS', 'wojemyrtany');
define('DB_SCHEMA', '1079133'); 

if (!$GLOBALS['db'] =  mysqli_connect(DB_HOST, DB_USER, DB_PASS)) die ('Nie udało się nawiązać połączenia z bazą danych!');
if (!mysqli_select_db($GLOBALS['db'], DB_SCHEMA))
{
    mysqli_close($GLOBALS['db']);
    die ('Nie udało się wybrać schematu bazy danych!');
}
mysqli_set_charset($GLOBALS['db'],"utf8");

/*
sql7.freemysqlhosting.net
Name: sql7252443
Username: sql7252443
Password: USsTx1bhY4
Port number: 3306
*/
?>
