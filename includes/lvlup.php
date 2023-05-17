<?php
	$levelup = $user -> get['lvl'];

	$maxexp5 = $levelup+3;
	$maxexp4 = $maxexp5/2;
	$maxexp3 = $maxexp4*500;
	$maxexp2 = $maxexp3*$levelup;
	$maxexp = $maxexp2+500;

	if ($user -> get['exp'] >= $maxexp)
	{
		if($user -> get['lvl'] <= 2930){
			$levelup = $user -> get['lvl']+1;
			
			$pn_po_lvl = $user -> get['pkt']+10;
			$zycieup = $user -> get['maxhp']+20;
			$zmeczenieup = $user -> get['max_zmeczenie']+15;
			if ($user -> get['lvl'] == 0)
			{
				$date = date("Y-m-d H:i:s");
				$wiad2 = 'gratulujemy! Zdobyłeś PIERWSZY poziom! W nagrodę dostajesz Sztylet w twoim ekwipunku. Powodzenia w drodze do szczytu!';
				$wiad = nl2br(strip_tags($wiad2));
				$temat = 'NOWY POZIOM';
				$id_wiad = '0';
				$adminsi = 'ADMIN';
				mysqli_query($GLOBALS['db'], "INSERT INTO `mail` (`owner`, `text`, `title`, `autor_id`, `autor`, `date`, `type`) VALUES (".$user -> get['id'].", '<i><span style=font-size:20px;>".$user -> get['login']."</span></i>, ".$wiad."', '".$temat."', ".$id_wiad.", '".$adminsi."', '".$date."', 'odebrane')");
				mysqli_query($GLOBALS['db'], "INSERT INTO `ekwipunek` (`stan`, `owner`, `id_broni`) VALUES (0,".$user -> get['id'].",2)");
			}
			if ($user -> get['lvl'] == 2930)
			{
				$date = date("Y-m-d H:i:s");
				$wiad2 = 'gratulujemy! NIESAMOWITE! Osiągnąłeś maksymalny poziom dostępny w tej grze!!';
				$wiad = nl2br(strip_tags($wiad2));
				$temat = 'MAKSYMALNY POZIOM';
				$id_wiad = '0';
				$adminsi = 'ADMIN';
				mysqli_query($GLOBALS['db'], "INSERT INTO `mail` (`owner`, `text`, `title`, `autor_id`, `autor`, `date`, `type`) VALUES (".$user -> get['id'].", '<i><span style=font-size:20px;>".$user -> get['login']."</span></i>, ".$wiad."', '".$temat."', ".$id_wiad.", '".$adminsi."', '".$date."', 'odebrane')");
			}
			mysqli_query($GLOBALS['db'], 'UPDATE `konta` SET `max_zmeczenie`='.$zmeczenieup.', `maxhp`='.$zycieup.', `pkt`='.$pn_po_lvl.', `lvl`='.$levelup.' WHERE `id`='.$user -> get['id']);
			
			$quest = mysqli_fetch_array(mysqli_query($GLOBALS['db'], 'SELECT `piaty_poziom` FROM `zadania` WHERE `id_gracza`='.$user -> get['id']));
			if($quest['piaty_poziom'] <= 5)
			{
				mysqli_query($GLOBALS['db'], 'UPDATE `zadania` SET `piaty_poziom`='.$levelup.' WHERE `id_gracza`='.$user -> get['id']);
			}
		}
	}
?>