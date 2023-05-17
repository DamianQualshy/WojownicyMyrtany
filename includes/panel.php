<?php
	if($panel == 1)
	{}
	else
	{
		require_once('../common/session.php');
		require_once('../common/config.php');
		require_once('../common/user.php');
	}

	include('lvlup.php');
	
	$staty2 = mysqli_query($GLOBALS['db'], "SELECT * FROM konta WHERE id=".$user -> get['id']); 
	$staty = mysqli_fetch_object($staty2); 

	echo '<p style="margin-left: 5px; margin-right: 5px; font-size: 14px;">';
	echo '<span>'.$staty -> kasa.' $</span><br />';
	// echo '<img style="margin-left: 10px; margin-right: 5px; height: 18px;" src="/images/brylki.png">'.$staty -> brylki.'';
	// echo '<img style="margin-left: 10px; height: 22px; margin-right: 5px;" src="/images/Eliksir.png">'.$staty -> hp .'/'.$staty -> maxhp.'';
	echo '<span>HP: '.$staty -> hp .'/'.$staty -> maxhp.'</span><br />';
	// echo '<span>PN: '.$staty -> pkt.'</span>';
	echo '<span>XP: '.$staty -> exp .'/'.$staty -> max_exp.'</span><br />';
	echo '<span>Poziom: '.$staty -> lvl .'</span><br />';
	echo '<span>Zmęczenie: '.$staty -> zmeczenie .'/'.$staty -> max_zmeczenie .'</span>';
	echo '</p>';
?>