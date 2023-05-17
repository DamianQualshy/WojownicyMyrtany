<?php
	if ($user -> get['exp'] >= $user -> get['max_exp'])
	{
		$levelup = $user -> get['lvl']+1;
		
		$dualexp5 = $levelup+3;
		$dualexp4 = $dualexp5/2;
		$dualexp3 = $dualexp4*500;
		$dualexp2 = $dualexp3*$levelup;
		$dualexp = $dualexp2+500;
		
		$pn_po_lvl = $user -> get['pkt']+10;
		$zycieup = $user -> get['maxhp']+20;
		$zmeczenieup = $user -> get['max_zmeczenie']+15;
		if ($user -> get['lvl'] == 0)
		{
			$date = date("Y-m-d H:i:s");
			$wiad2 = 'gratulujemy! Zdobyłeś PIERWSZY poziom! W nagrodę dostajesz dodatkowe 10 punktów nauki.';
			$wiad = nl2br(strip_tags($wiad2));
			$temat = 'NOWY POZIOM';
			$id_wiad = '0';
			$adminsi = 'ADMIN';
			mysqli_query($GLOBALS['db'], "INSERT INTO `mail` (`owner`, `text`, `title`, `autor_id`, `autor`, `date`, `type`) VALUES (".$user -> get['id'].", '<i><span style=font-size:20px;>".$user -> get['login']."</span></i>, ".$wiad."', '".$temat."', ".$id_wiad.", '".$adminsi."', '".$date."', 'odebrane')");

			$pn_po_lvl = $pn_po_lvl+10;
		}
			mysqli_query($GLOBALS['db'], 'UPDATE `konta` SET `max_zmeczenie`='.$zmeczenieup.', `maxhp`='.$zycieup.', `pkt`='.$pn_po_lvl.', `max_exp`='.$dualexp.', `lvl`='.$levelup.' WHERE `id`='.$user -> get['id']);
	}
?>