<?php
$stat = mysqli_fetch_object(mysqli_query($GLOBALS['db'], "SELECT `id` FROM `konta` WHERE `login`='".$_SESSION['login']."' AND `haslo`='".$_SESSION['pass']."'"));
if ($stat == false) die ('<br /><br /><center><p>Taki użytkownik nie istnieje! <a href="index.php?wyloguj">Wyloguj</a></p></center>');
$pid = $stat -> id;
class User
{
    private $pid;
	var $get;
    function getBasic($pid)
	{
        $z = mysqli_query($GLOBALS['db'], 'SELECT * FROM `konta` WHERE `id`='.$pid); 
        $this -> get = mysqli_fetch_array($z);
    }
}
$user = new User;
$user -> getBasic($pid);
?>