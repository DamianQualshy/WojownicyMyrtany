<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_SCHEMA', '1079133');

include('error_template.php');

if (!$GLOBALS['db'] =  mysqli_connect(DB_HOST, DB_USER, DB_PASS)) die ($before.'Nie udało się nawiązać połączenia z bazą danych!'.$after);
if (!mysqli_select_db($GLOBALS['db'], DB_SCHEMA))
{
    mysqli_close($GLOBALS['db']);
    die ($before.'Nie udało się wybrać schematu bazy danych!'.$after);
}
mysqli_set_charset($GLOBALS['db'],"utf8");
?>
