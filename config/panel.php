<?php
	include('lvlup.php');
	
	if($stats['hp'] >= round($stats['maxhp']*0.75, 0))
	{$hpcolor = '#E5E4E2';}
	else if($stats['hp'] >= round($stats['maxhp']*0.5, 0) && $stats['hp'] < round($stats['maxhp']*0.75, 0))
	{$hpcolor = 'yellow';}
	else if($stats['hp'] >= round($stats['maxhp']*0.25, 0) && $stats['hp'] < round($stats['maxhp']*0.5, 0))
	{$hpcolor = 'orange';}
	else if($stats['hp'] >= 0 && $stats['hp'] < round($stats['maxhp']*0.25, 0))
	{$hpcolor = 'red';}
	else
	{$hpcolor = 'red';}
	
	echo '<p style="margin-left: 5px; margin-right: 5px; font-size: 14px;">';
	echo '<span>'.$stats['cash'].' $</span><br />';
	echo '<span>HP: <span style="color: '.$hpcolor.';">'.$stats['hp'].'</span>/'.$stats['maxhp'].'</span><br />';
	echo '<span>XP: '.$stats['exp'].'/'.$maxexp.'</span><br />'; // $maxexp jest z include('lvlup.php');
	echo '<span>Poziom: '.$stats['lvl'].'</span><br />';
	echo '<span>Zmęczenie: '.$stats['ftg'].'/'.$stats['maxftg'].'</span>';
	echo '</p>';
?>