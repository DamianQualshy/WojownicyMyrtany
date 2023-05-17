<?php
	$stats = mysqli_fetch_array(mysqli_query($GLOBALS['db'], "SELECT * FROM acct_stats WHERE id=".$user -> get['id']));
	$maxexp = (((($stats['lvl']+3)/2)*500)*$stats['lvl'])+500;

	if ($stats['exp'] >= $maxexp)
	{
		if($stats['lvl'] <= 2930){
			$levelup = $stats['lvl']+1;
			
			$pn_po_lvl = $stats['lp']+10;
			$zycieup = $stats['maxhp']+20;
			$zmeczenieup = $user -> $stats['maxftg']+15;
			if ($stats['lvl'] == 0)
			{
				$date = date("Y-m-d H:i:s");
				$wiad2 = 'gratulujemy! Zdobyłeś PIERWSZY poziom! W nagrodę dostajesz Sztylet w twoim ekwipunku. Powodzenia w drodze do szczytu!';
				$wiad = nl2br(strip_tags($wiad2));
				$temat = 'NOWY POZIOM';
				$id_wiad = '0';
				$adminsi = 'ADMIN';
				mysqli_query($GLOBALS['db'], "INSERT INTO `mail` (`owner`, `text`, `title`, `autor_id`, `autor`, `date`, `type`) VALUES (".$user -> get['id'].", '<i><span style=font-size:20px;>".$user -> get['nick']."</span></i>, ".$wiad."', '".$temat."', ".$id_wiad.", '".$adminsi."', '".$date."', 'odebrane')");
				mysqli_query($GLOBALS['db'], "INSERT INTO `ekwipunek` (`stan`, `owner`, `id_broni`) VALUES (0,".$user -> get['id'].",2)");
			}
			if ($stats['lvl'] == 2930)
			{
				$date = date("Y-m-d H:i:s");
				$wiad2 = 'gratulujemy! NIESAMOWITE! Osiągnąłeś maksymalny poziom dostępny w tej grze!!';
				$wiad = nl2br(strip_tags($wiad2));
				$temat = 'MAKSYMALNY POZIOM';
				$id_wiad = '0';
				$adminsi = 'ADMIN';
				mysqli_query($GLOBALS['db'], "INSERT INTO `mail` (`owner`, `text`, `title`, `autor_id`, `autor`, `date`, `type`) VALUES (".$user -> get['id'].", '<i><span style=font-size:20px;>".$user -> get['nick']."</span></i>, ".$wiad."', '".$temat."', ".$id_wiad.", '".$adminsi."', '".$date."', 'odebrane')");
			}
			mysqli_query($GLOBALS['db'], 'UPDATE `acct_stats` SET `maxftg`='.$zmeczenieup.', `maxhp`='.$zycieup.', `lp`='.$pn_po_lvl.', `lvl`='.$levelup.' WHERE `id`='.$user -> get['id']);
			
			$quest = mysqli_fetch_array(mysqli_query($GLOBALS['db'], 'SELECT `piaty_poziom` FROM `acct_quests` WHERE `id`='.$user -> get['id']));
			if($quest['piaty_poziom'] <= 5)
			{
				mysqli_query($GLOBALS['db'], 'UPDATE `acct_quests` SET `piaty_poziom`='.$levelup.' WHERE `id`='.$user -> get['id']);
			}
		}
	}
?>