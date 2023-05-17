<?php

require_once('head.php');
?>

<div class="post">
    <div class="postheader"><h1>Karczma</h1></div>
	<div class="postcontent">
	<img src="images/ikonki/karczma.png" border="0">

<?php
if ($user -> get['zmeczenie'] >= $user -> get['max_zmeczenie'])
{
	echo '<span style="color:red;">Jesteś zbyt zmęczony, aby pracować</span>';
}
else
{
    echo '<p>Zarób 20$ | Zmęczenie +5<a href="szybkakasa.php?get=20"> Pracuj</a></p>';
    if (isset($_GET['get']) && $_GET['get'] == '20')
	{
	    if ($user -> get['zmeczenie']+5 <= $user -> get['max_zmeczenie'])
		{
	        mysqli_query($GLOBALS['db'], 'UPDATE `konta` SET ``=`zmeczenie`+5 `kasa`=`kasa`+20 WHERE `id`='.$user -> get['id']);
			$pracuj5 = $user -> get['zmeczenie']+5;
			$zarob20 = $user -> get['kasa']+20;
			mysqli_query($GLOBALS['db'], 'UPDATE `konta` SET `zmeczenie`='.$pracuj5.', `kasa`='.$zarob20.' WHERE `id`='.$user -> get['id']);
			echo '<p>Zarabiasz 20$ Zmęczenie wzrasta o 5.</p>';
		}
		else echo '<span style="color:red;">Jesteś zbyt zmęczony, aby pracować</span>';
	}
}
?>
    </div>
    <div class="postfooter"></div>
</div>
<?php
require_once('bottom.php');
?>	 