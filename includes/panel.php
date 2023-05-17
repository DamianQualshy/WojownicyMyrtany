<?php
	if(isset($panel) && $panel == 1)
	{}
	else
	{
		require_once('../common/session.php');
		require_once('../common/config.php');
		require_once('../common/user.php');
	}

	include('lvlup.php');

	$staty = mysqli_fetch_array(mysqli_query($GLOBALS['db'], "SELECT * FROM konta WHERE id=".$user -> get['id'])); 
	
	$siedempiec3 = $staty['maxhp']/4;
	$siedempiec2 = $siedempiec3*3;
	$siedempiec = round($siedempiec2, 0);
	$pieczero2 = $staty['maxhp']/2;
	$pieczero = round($pieczero2, 0);
	$dwapiec2 = $staty['maxhp']/4;
	$dwapiec = round($dwapiec2, 0);
	
	if($staty['hp'] >= $siedempiec)
	{$hpcolor = '#E5E4E2';}
	else if($staty['hp'] >= $pieczero && $staty['hp'] < $siedempiec)
	{$hpcolor = 'yellow';}
	else if($staty['hp'] >= $dwapiec && $staty['hp'] < $pieczero)
	{$hpcolor = 'orange';}
	else if($staty['hp'] >= 0 && $staty['hp'] < $dwapiec)
	{$hpcolor = 'red';}
	else
	{$hpcolor = 'red';}
	
	echo '<p style="margin-left: 5px; margin-right: 5px; font-size: 14px;">';
	echo '<span>'.$staty['kasa'].' $</span><br />';
	// echo '<img style="margin-left: 10px; margin-right: 5px; height: 18px;" src="/images/brylki.png">'.$staty -> brylki.'';
	// echo '<img style="margin-left: 10px; height: 22px; margin-right: 5px;" src="/images/Eliksir.png">'.$staty -> hp .'/'.$staty -> maxhp.'';
	echo '<span>HP: <span style="color: '.$hpcolor.';">'.$staty['hp'].'</span>/'.$staty['maxhp'].'</span><br />';
	// echo '<span>PN: '.$staty -> pkt.'</span>';
	echo '<span>XP: '.$staty['exp'].'/'.$maxexp.'</span><br />'; // $maxexp jest z include('lvlup.php');
	echo '<span>Poziom: '.$staty['lvl'].'</span><br />';
	echo '<span>Zmęczenie: '.$staty['zmeczenie'].'/'.$staty['max_zmeczenie'].'</span>';
	echo '</p>';
?>