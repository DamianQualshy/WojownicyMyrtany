<?php
include('error_template.php');

$stat = mysqli_fetch_object(mysqli_query($GLOBALS['db'], "SELECT `id` FROM `acct_data` WHERE `nick`='".$_SESSION['nick']."' AND `pass`='".$_SESSION['pass']."'"));
if ($stat == false) die ($before.'Taki użytkownik nie istnieje! <a href="index.php?signout">Wyloguj</a>'.$after);
$pid = $stat -> id;
class User
{
    private $pid;
	var $get;
    function getBasic($pid)
	{
        $z = mysqli_query($GLOBALS['db'], 'SELECT * FROM `acct_data` WHERE `id`='.$pid); 
        $this -> get = mysqli_fetch_array($z);
    }
}
$user = new User;
$user -> getBasic($pid);
?>