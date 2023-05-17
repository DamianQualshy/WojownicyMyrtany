<?php
require_once('head.php');
?>

<div class="post">
    <div class="postheader"><h1>Praca</h1></div>
	<div class="postcontent">
	<div class="postbg" style="background: url(images/tla_strony/praca.jpg);"></div>
	<div class="postbreak"></div>
<script type="text/javascript">
function toggle(id) {
  var elem = document.getElementById(id);
  if(elem.style.display==''){ elem.style.display='none'; return; }
  elem.style.display='';
}
</script>
<?php
$zmeczenie = $user -> get['zmeczenie']+5;
$max_zmeczenie = $user -> get['max_zmeczenie'];
echo "<script type='text/javascript'>\n";
echo "var zmeczenie = $zmeczenie\n";
echo "var max_zmeczenie = $max_zmeczenie\n";
echo "</script>\n";
?>
<?php
if (isset($_POST['anuluj']))
{
	mysqli_query($GLOBALS['db'], "UPDATE `konta` SET `praca_aktywna`=0, `praca_id`=0, `praca_czas`=0 WHERE `id`=".$user -> get['id']);
	echo '<div class="komunikat komyellow">Porzuciłeś pracę...</div>';
}

$aktywna = 0;
if (isset($_POST['pracuj']))
{
	$aktywna = 1;
	$check = mysqli_fetch_array(mysqli_query($GLOBALS['db'], 'SELECT `id`,`czas` FROM `prace` WHERE `id`='.$_POST['pracuj']));
	if ($check == true)
	{
		mysqli_query($GLOBALS['db'], "UPDATE `konta` SET `praca_czas`=".time()."+".$check['czas'].", `praca_aktywna`=1, `praca_id`=".$check['id']." WHERE `id`=".$user -> get['id']);
		$praca = mysqli_fetch_array(mysqli_query($GLOBALS['db'], 'SELECT `praca_czas` FROM `konta` WHERE `id`='.$user -> get['id']));
		
		$time = time();
		$czas2 = $praca['praca_czas'];
		$czas = $czas2-$time;
	}
	else $czas = 0;
} else $czas = 0;


if ($user -> get['praca_aktywna'] == 1)
{
	$aktywna = 1;
	$praca = mysqli_fetch_array(mysqli_query($GLOBALS['db'], 'SELECT `praca_czas`,`praca_id` FROM `konta` WHERE `id`='.$user -> get['id']));
	$time = time();
	$czas2 = $praca['praca_czas'];
	$czas = $czas2-$time;
	
	if($czas <= 0)
	{
		$check = mysqli_fetch_array(mysqli_query($GLOBALS['db'], 'SELECT `id`,`kasa`,`zmeczenie` FROM `prace` WHERE `id`='.$praca['praca_id']));
		if ($check == true)
		{
			if($user -> get['zmeczenie']+$check['zmeczenie'] > $user -> get['max_zmeczenie'])
			{
				echo '<div class="komunikat_m komred">Odpocznij trochę, zanim odbierzesz zyskane pieniącze.</div> <form style="margin-bottom: 20px;" method="post" action="praca.php"><input style="margin: 0 auto; margin-top: 10px; color: red;" class="gothbutton" name="anuluj" type="submit" value="Anuluj" /></form>';
				$aktywna = 0;
			}
			else
			{
				$praca_nagroda = '';
				
				if($praca['praca_id'] == 1)
				{
					$quest = mysqli_fetch_array(mysqli_query($GLOBALS['db'], 'SELECT `praca_lobart` FROM `zadania` WHERE `id_gracza`='.$user -> get['id']));
					if ($quest['praca_lobart'] < 3)
					{
						$random = rand(1, 100);
						if ($random <= 25)
						{
							mysqli_query($GLOBALS['db'], "UPDATE `konta` SET `praca_aktywna`=0, `praca_id`=0, `praca_czas`=0, `zmeczenie`=`zmeczenie`+".$check['zmeczenie']." WHERE `id`=".$user -> get['id']);
							mysqli_query($GLOBALS['db'], "UPDATE `zadania` SET `praca_lobart`=`praca_lobart`+1 WHERE `id_gracza`=".$user -> get['id']);
							echo '<div class="komunikat komgreen">Zapracowałeś sobie na zniżkę ceny Stroju Farmera. Pracuj dalej, a otrzymasz go za darmo. Zmęczenie wzrosło o <b>'.$check['zmeczenie'].'</b></div>';
							$aktywna = 0;
						}
						else
						{
							mysqli_query($GLOBALS['db'], "UPDATE `konta` SET `kasa`=`kasa`+".$check['kasa'].", `praca_aktywna`=0, `praca_id`=0, `praca_czas`=0, `zmeczenie`=`zmeczenie`+".$check['zmeczenie']." WHERE `id`=".$user -> get['id']);
							echo '<div class="komunikat komgreen">Do twojego mieszka wpłynęły pieniądze: <b>'.$check['kasa'].'</b>.<br />Zmęczenie wzrosło o <b>'.$check['zmeczenie'].'</b>.</div>';
							$aktywna = 0;
						}
					}
					else if ($quest['praca_lobart'] == 3)
					{
						$random = rand(1, 100);
						if ($random <= 25)
						{
							mysqli_query($GLOBALS['db'], "UPDATE `konta` SET `praca_aktywna`=0, `praca_id`=0, `praca_czas`=0, `zmeczenie`=`zmeczenie`+".$check['zmeczenie']." WHERE `id`=".$user -> get['id']);
							mysqli_query($GLOBALS['db'], "INSERT INTO `eq_zbroje` (`owner`, `id_zbroi`) VALUES (".$user -> get['id'].", 1)");
							mysqli_query($GLOBALS['db'], "UPDATE `zadania` SET `praca_lobart`=`praca_lobart`+1 WHERE `id_gracza`=".$user -> get['id']);
							echo '<div class="komunikat komgreen">Zapracowałeś sobie na Strój Farmera! Zmęczenie wzrosło o <b>'.$check['zmeczenie'].'</b></div>';
							$aktywna = 0;
						}
						else
						{
							mysqli_query($GLOBALS['db'], "UPDATE `konta` SET `kasa`=`kasa`+".$check['kasa'].", `praca_aktywna`=0, `praca_id`=0, `praca_czas`=0, `zmeczenie`=`zmeczenie`+".$check['zmeczenie']." WHERE `id`=".$user -> get['id']);
							echo '<div class="komunikat komgreen">Do twojego mieszka wpłynęły pieniądze: <b>'.$check['kasa'].'</b>.<br />Zmęczenie wzrosło o <b>'.$check['zmeczenie'].'</b>.</div>';
							$aktywna = 0;
						}
					}
					else
					{
						mysqli_query($GLOBALS['db'], "UPDATE `konta` SET `kasa`=`kasa`+".$check['kasa'].", `praca_aktywna`=0, `praca_id`=0, `praca_czas`=0, `zmeczenie`=`zmeczenie`+".$check['zmeczenie']." WHERE `id`=".$user -> get['id']);
						echo '<div class="komunikat komgreen">Do twojego mieszka wpłynęły pieniądze: <b>'.$check['kasa'].'</b>.<br />Zmęczenie wzrosło o <b>'.$check['zmeczenie'].'</b>.</div>';
						$aktywna = 0;
					}
				}
				else
				{
					mysqli_query($GLOBALS['db'], "UPDATE `konta` SET `kasa`=`kasa`+".$check['kasa'].", `praca_aktywna`=0, `praca_id`=0, `praca_czas`=0, `zmeczenie`=`zmeczenie`+".$check['zmeczenie']." WHERE `id`=".$user -> get['id']);
					echo '<div class="komunikat komgreen">Do twojego mieszka wpłynęły pieniądze: <b>'.$check['kasa'].'</b>.<br />Zmęczenie wzrosło o <b>'.$check['zmeczenie'].'</b>.</div>';
					$aktywna = 0;
				}
				
			}
		}
	}
	
	$nazwa_praca = mysqli_fetch_array(mysqli_query($GLOBALS['db'], 'SELECT `nazwa` FROM `prace` WHERE `id`='.$praca['praca_id']));
	if($nazwa_praca == true)
	{
		$paktywna = mysqli_fetch_array(mysqli_query($GLOBALS['db'], 'SELECT `praca_aktywna` FROM `konta` WHERE `id`='.$user -> get['id']));
		if($paktywna['praca_aktywna'] == 1)
		{
			echo '<div style="text-align: center;margin-bottom: 10px;font-style: italic;font-weight: bold;">'.$nazwa_praca['nazwa'].'</div>';
		}
	}
	
} else $czas = 0;

echo '<div id="div1" style="display: none;"></div>';

echo "<script>
var tak = 0;
var aktywna = ".$aktywna.";
var intervalHandler;

function stoper2()
{
	if(aktywna == 1)
	{
		toggle('div1');
		stoper1();
	}
}

function stoper1()
{
	tak = 1;
	ile=".$czas.";
	intervalHandler = setInterval(stoper,1000);
	stoper();
}

function stoper()
{
	if(tak == 1)
	{
		godzin=Math.floor(ile/3600);

		minut=Math.floor(ile/60)%60;
		sekund =ile%60;

		document.getElementById('div1').innerHTML = '<center>Pozostało: <b>'+godzin+'</b>h <b>'+minut+'</b>min <b>'+sekund+'</b>s"; echo '<form method="post" action="praca.php"><input style="margin-top: 10px; color: red;" class="gothbutton" name="anuluj" type="submit" value="Anuluj" /></form>'; echo "</center><br/ >';
		ile--;
		if(ile<0)
		{
			clearInterval(intervalHandler);
		}
		if(ile==0-1)
		{
			toggle('div1');
			tak=false;
			window.location='praca.php'
		}
	}
}
</script>";
$stoper = '';
if (isset($_POST['pracuj']))
{
	$check = mysqli_fetch_array(mysqli_query($GLOBALS['db'], 'SELECT `id`,`czas` FROM `prace` WHERE `id`='.$_POST['pracuj']));
	if ($check == true)
	{
		$stoper =  '<script>stoper2();</script>';
	}
}

$praca_aktywna = mysqli_fetch_array(mysqli_query($GLOBALS['db'], 'SELECT `praca_aktywna` FROM `konta` WHERE `id`='.$user -> get['id']));
if ($praca_aktywna['praca_aktywna'] == 1)
{
	$stoper =  '<script>stoper2();</script>';
}
echo $stoper;
?>

<?php
	$a = mysqli_query($GLOBALS['db'], "SELECT * FROM `prace` ORDER BY `czas` ASC");
	echo '<h3 style="text-align: center;">Dostępne dla ciebie prace</h3><br />';
	while($item = mysqli_fetch_array($a))
	{
		if($user -> get['lvl'] >= $item['req_lvl'])
		{
			if($user -> get['zmeczenie']+$item['zmeczenie'] >= $user -> get['max_zmeczenie'])
			{
				$pracuj = '<div style="width: 73px;" class="zablokowane">Pracuj</div>';
			}
			else if ($praca_aktywna['praca_aktywna'] == 1)
			{
				$pracuj = '';
			}
			else
			{
				$pracuj = '<form class="inter" method="post" action="praca.php"><input type="hidden" name="pracuj" value="'.$item['id'].'" /><input id="wskaz" value="Pracuj" style="width: 73px; color: gold;" type="submit" /></form>';
			}
			
			$ik = '<div style="background: url(images/prace/'.$item['ikonka'].'.png); margin: 9px auto auto auto; position: absolute; top: 0; left: 0; bottom: 0; right: 0; max-width: 120px; max-height: 120px; background-size: 120px;"></div>';
			echo '<table class="lista">
				  <tr>
					<th rowspan="5" class="av">'.$ik.'</th>
					<th class="th">'.$item['nazwa'].'</th>
					<th></th>
				  </tr>
				  <tr>
					<td class="one">Kasa</td>
					<td class="two">'.$item['kasa'].'</td>
				  </tr>
				  <tr>
					<td class="one">Zmęczenie</td>
					<td class="two">'.$item['zmeczenie'].'</td>
				  </tr>
				  <tr>
					<td class="one">Czas</td>
					<td class="two">'.$item['czas'].'</td>
				  </tr>
				  <tr>
					<td class="one padd">'.$pracuj.'</td>
					<td></td>
				  </tr>
				  </table><br />';
		}
	}
?>
    </div>
    <div class="postfooter"></div>
</div>
<?php
require_once('bottom.php');
?>	 