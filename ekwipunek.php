<?php
require_once('head.php');
?>

<div class="post">
    <div class="postheader"><h1>Ekwipunek</h1></div>
	<div class="postcontent">
	<div class="postbg" style="background: url(images/tla_strony/ekwipunek.jpg);"></div>
	<div class="postbreak"></div>
<?php
if (isset($_POST['uzyj']))
{
	$uzyj = mysqli_fetch_array(mysqli_query($GLOBALS['db'], 'SELECT `id`,`typ`,`id_inne` FROM `eq_inne` WHERE `id`='.$_POST['uzyj']));
	if ($uzyj == true)
	{
		if($uzyj['typ'] == "potka_hp")
		{
			$dane = mysqli_fetch_array(mysqli_query($GLOBALS['db'], 'SELECT `wartosc`,`nazwa` FROM `klasztor` WHERE `id`='.$uzyj['id_inne']));
			if($dane['wartosc']+$user -> get['hp'] > $user -> get['maxhp']) {$leczenie = $user -> get['maxhp'];}
			else {$leczenie = $dane['wartosc']+$user -> get['hp'];}

			mysqli_query($GLOBALS['db'], "UPDATE `konta` SET `hp`=".$leczenie." WHERE `id`=".$user -> get['id']);
		}
		mysqli_query($GLOBALS['db'], "DELETE FROM `eq_inne` WHERE `id`=".$uzyj['id']);
		echo '<div class="komunikat komgreen">Użyłeś przedmiotu: <b>'.$dane['nazwa'].'</b></div>';
	}
	else echo '<div class="komunikat komred">Nie ma takiego przedmiotu w ekwipunku!</div>';
}

if (isset($_POST['zaloz']))
{
    $eq_dane = mysqli_fetch_array(mysqli_query($GLOBALS['db'], "SELECT * FROM `ekwipunek` WHERE `id`=".$_POST['zaloz']." AND `owner`=".$user -> get['id']));
	$sklep_dane = mysqli_fetch_object(mysqli_query($GLOBALS['db'], "SELECT * FROM `sklep` WHERE `id`=".$eq_dane['id_broni']));
	if ($eq_dane == true)
	{
		if ($eq_dane['stan'] == '0')
		{
			if ($sklep_dane -> req_lvl <= $user -> get['lvl'])
			{
				if ($sklep_dane -> req_sila <= $user -> get['atak'])
				{
					$eq_dane = mysqli_fetch_array(mysqli_query($GLOBALS['db'], "SELECT `id` FROM `ekwipunek` WHERE `stan`=1 AND `owner`=".$user -> get['id']));		
					mysqli_query($GLOBALS['db'], "UPDATE `ekwipunek` SET `stan`=0 WHERE `stan`=1 AND `owner`=".$user -> get['id']);
					mysqli_query($GLOBALS['db'], "UPDATE `ekwipunek` SET `stan`=1 WHERE `owner`=".$user -> get['id']." AND `id`=".$_POST['zaloz']);
					echo '<div class="komunikat komgreen">Broń została założona!</div>';
				}
				else echo '<div class="komunikat komred">Nie spełniasz wymagań dla przedmiotu: <i><b>'.$sklep_dane -> nazwa.'</b></i></div>';
			}
			else echo '<div class="komunikat komred">Nie spełniasz wymagań dla przedmiotu: <i><b>'.$sklep_dane -> nazwa.'</b></i></div>';
		}
		else echo '<div class="komunikat komred">Już założyłeś ten przedmiot!</div>';
    }
	else echo $eq_dane['stan'].'<div class="komunikat komred">Nie posiadasz takiego przedmiotu!</div>';
}

if (isset($_POST['zaloz_panc']))
{
    $eq_dane = mysqli_fetch_array(mysqli_query($GLOBALS['db'], "SELECT * FROM `eq_zbroje` WHERE `id`=".$_POST['zaloz_panc']." AND `owner`=".$user -> get['id']));
	$sklep_dane = mysqli_fetch_object(mysqli_query($GLOBALS['db'], "SELECT * FROM `zbrojmistrz` WHERE `id`=".$eq_dane['id_zbroi']));
	if ($eq_dane == true)
	{
		if ($eq_dane['stan'] == '0')
		{
			if ($sklep_dane -> req_lvl <= $user -> get['lvl'])
			{
				$eq_dane = mysqli_fetch_array(mysqli_query($GLOBALS['db'], "SELECT `id` FROM `eq_zbroje` WHERE `stan`=1 AND `owner`=".$user -> get['id']));		
				mysqli_query($GLOBALS['db'], "UPDATE `eq_zbroje` SET `stan`=0 WHERE `stan`=1 AND `owner`=".$user -> get['id']);
				mysqli_query($GLOBALS['db'], "UPDATE `eq_zbroje` SET `stan`=1 WHERE `owner`=".$user -> get['id']." AND `id`=".$_POST['zaloz_panc']);
				echo '<div class="komunikat komgreen">Pancerz został założony!</div>';
			}
			else echo '<div class="komunikat komred">Nie spełniasz wymagań dla przedmiotu: <i><b>'.$sklep_dane -> nazwa.'</b></i></div>';
		}
		else echo '<div class="komunikat komred">Już założyłeś ten przedmiot!</div>';
    }
	else echo $eq_dane['stan'].'<div class="komunikat komred">Nie posiadasz takiego przedmiotu!</div>';
}

if (isset($_POST['zdejmij']))
{
    $eq_dane = mysqli_fetch_array(mysqli_query($GLOBALS['db'], "SELECT * FROM `ekwipunek` WHERE `stan`=1 AND `id`=".$_POST['zdejmij']." AND `owner`=".$user -> get['id']));
	if ($eq_dane == true)
	{
        mysqli_query($GLOBALS['db'], "UPDATE `ekwipunek` SET `stan`=0 WHERE `id`=".$_POST['zdejmij']);
        echo '<div class="komunikat komgreen">Przedmiot został schowany do plecaka!</div>';
    }
	else echo '<div class="komunikat komred">Nie posiadasz takiego przedmiotu!</div>';
}

if (isset($_POST['zdejmij_panc']))
{
    $eq_dane = mysqli_fetch_array(mysqli_query($GLOBALS['db'], "SELECT * FROM `eq_zbroje` WHERE `stan`=1 AND `id`=".$_POST['zdejmij_panc']." AND `owner`=".$user -> get['id']));
	if ($eq_dane == true)
	{
        mysqli_query($GLOBALS['db'], "UPDATE `eq_zbroje` SET `stan`=0 WHERE `id`=".$_POST['zdejmij_panc']);
        echo '<div class="komunikat komgreen">Pancerz został schowany do plecaka!</div>';
    }
	else echo '<div class="komunikat komred">Nie posiadasz takiego przedmiotu!</div>';
}

if (isset($_POST['sprzedaj']))
{
    if (preg_match("/^[0-9]*$/", $_POST['sprzedaj']) && !empty($_POST['sprzedaj']))
    {
	    $sprzed2 = mysqli_fetch_array(mysqli_query($GLOBALS['db'], 'SELECT `id_broni`,`id` FROM `ekwipunek` WHERE `id`='.$_POST['sprzedaj']));
	    if ($sprzed2 == true)
		{
			$sprzed = mysqli_fetch_array(mysqli_query($GLOBALS['db'], 'SELECT `sprzedaz`,`nazwa` FROM `sklep` WHERE `id`='.$sprzed2['id_broni']));
			mysqli_query($GLOBALS['db'], "DELETE FROM `ekwipunek` WHERE `id`='".$sprzed2['id']."'");
			if($sprzed['sprzedaz'] == 0)
			{
				echo '<div class="komunikat komgreen">Przedmiot <b>'.$sprzed['nazwa'].'</b> został wyrzucony!</div>';
			}
			else
			{
				mysqli_query($GLOBALS['db'], "UPDATE `konta` SET `kasa`=`kasa`+".$sprzed['sprzedaz']." WHERE `id`=".$user -> get['id']);
				echo '<div class="komunikat komgreen">Przedmiot <b>'.$sprzed['nazwa'].'</b> został sprzedany!</div>';
			}
		}
		else echo '<div class="komunikat komred">Nie ma takiego przedmiotu w ekwipunku!</div>';
	}
	else echo '<div class="komunikat komred">Nie ma takiego przedmiotu w ekwipunku!</div>';
}

if (isset($_POST['sprzedaj_panc']))
{
	$sprzed2 = mysqli_fetch_array(mysqli_query($GLOBALS['db'], 'SELECT `id`,`id_zbroi` FROM `eq_zbroje` WHERE `id`='.$_POST['sprzedaj_panc'].' AND `owner`='.$user -> get['id']));
	if ($sprzed2 == true)
	{
		$sprzed = mysqli_fetch_array(mysqli_query($GLOBALS['db'], 'SELECT `sprzedaz`,`nazwa` FROM `zbrojmistrz` WHERE `id`='.$sprzed2['id_zbroi']));
		mysqli_query($GLOBALS['db'], "DELETE FROM `eq_zbroje` WHERE `id`='".$sprzed2['id']."'");
		mysqli_query($GLOBALS['db'], "UPDATE `konta` SET `kasa`=`kasa`+".$sprzed['sprzedaz']." WHERE `id`=".$user -> get['id']);
		echo '<div class="komunikat komgreen">Pancerz <b>'.$sprzed['nazwa'].'</b> został sprzedany!</div>';
	}
	else echo '<div class="komunikat komred">Nie ma takiego przedmiotu w ekwipunku!</div>';
}

if (isset($_POST['sprzedaj_inne']))
{
	$sprzed2 = mysqli_fetch_array(mysqli_query($GLOBALS['db'], 'SELECT `id`,`id_inne`,`dane` FROM `eq_inne` WHERE `id`='.$_POST['sprzedaj_inne'].' AND `owner`='.$user -> get['id']));
	if ($sprzed2 == true)
	{
		$sprzed = mysqli_fetch_array(mysqli_query($GLOBALS['db'], 'SELECT `sprzedaz`,`nazwa` FROM `'.$sprzed2['dane'].'` WHERE `id`='.$sprzed2['id_inne']));
		mysqli_query($GLOBALS['db'], "DELETE FROM `eq_inne` WHERE `id`='".$sprzed2['id']."'");
		mysqli_query($GLOBALS['db'], "UPDATE `konta` SET `kasa`=`kasa`+".$sprzed['sprzedaz']." WHERE `id`=".$user -> get['id']);
		echo '<div class="komunikat komgreen">Przedmiot <b>'.$sprzed['nazwa'].'</b> został sprzedany!</div>';
	}
	else echo '<div class="komunikat komred">Nie ma takiego przedmiotu w ekwipunku!</div>';
}

echo '<center>
		<div class="tabs">
			<a href="#bronie" class="active">Bronie</a>
			<a href="#pancerze">Pancerze</a>
			<a href="#inne">Inne</a>
		</div>
	</center>';

echo '<div style="display: none;" id="tabs-container" class="tabs-container">
			<article id="bronie" class="tab-content active">
				<div class="tab-text">';
$zalozone = mysqli_fetch_object(mysqli_query($GLOBALS['db'], "SELECT * FROM `ekwipunek` WHERE `stan`=1 AND `owner`=".$user -> get['id']));
if ($zalozone == true)
{
		$miecz_dane = mysqli_fetch_object(mysqli_query($GLOBALS['db'], "SELECT * FROM `sklep` WHERE `id`=".$zalozone -> id_broni));
		echo '<br />';
		$ik1 = '<div style="background: url(images/sklep/'.$miecz_dane -> ikonka.'.png); margin: 19px auto auto auto; position: absolute; top: 0; left: 0; bottom: 0; right: 0; max-width: 100px; max-height: 100px;"></div>';
		echo '<table class="lista">
			  <tr>
				<th rowspan="5" class="av">'.$ik1.'</th>
				<th class="th">'.$miecz_dane -> nazwa.' <span style="color: #2d5db7;">[Założony]</span></th>
				<th></th>
			  </tr>
			  <tr>
				<td class="one">Atak</td>
				<td class="two">'.$miecz_dane -> atak.'</td>
			  </tr>
			  <tr>
				<td class="one">Wymagana siła</td>
				<td class="two">'.$miecz_dane -> req_sila.'</td>
			  </tr>
			  <tr>
				<td class="one">Wymagany poziom</td>
				<td class="two">'.$miecz_dane -> req_lvl.'</td>
			  </tr>
			  <tr>
				<td class="one padd"><form class="inter" method="post" action="ekwipunek.php"><input type="hidden" name="zdejmij" value="'.$zalozone -> id.'" /><input id="wskaz" value="Zdejmij" style="width: 82px; color: #3a6ab7;" type="submit" /></form></td>
				<td></td>
			  </tr>
			</table> <br />';
}

$equip = mysqli_query($GLOBALS['db'], "SELECT * FROM `ekwipunek` WHERE `stan`=0 AND `owner`=".$user -> get['id']." GROUP BY `id_broni` ORDER BY `id_broni` DESC");
if (mysqli_num_rows($equip) > 0) 
{
	if ($zalozone == true)
	{echo '<br />';}
	echo '<h3 style="text-align: center;">Przedmioty w ekwipunku</h3><br />';
    while ($i = mysqli_fetch_array($equip))
    {
		$count = 'x'.mysqli_num_rows(mysqli_query($GLOBALS['db'], "SELECT `id` FROM `ekwipunek` WHERE (`id_broni`=".$i['id_broni']." AND `stan`=0 AND `owner`=".$user -> get['id'].")"));
		if($count == 'x1') $count = '';

		$miecz_dane = mysqli_fetch_object(mysqli_query($GLOBALS['db'], "SELECT * FROM `sklep` WHERE `id`=".$i['id_broni']));
		$ik = '<div style="background: url(images/sklep/'.$miecz_dane -> ikonka.'.png); margin: 19px auto auto auto; position: absolute; top: 0; left: 0; bottom: 0; right: 0; max-width: 100px; max-height: 100px;"></div>';
		
		if($user -> get['atak'] < $miecz_dane -> req_sila) {$niski_str = 'color:red;';} else {$niski_str = '';}
		if($user -> get['lvl'] < $miecz_dane -> req_lvl) {$niski_lvl = 'color:red;';} else {$niski_lvl = '';}
		
		if($user -> get['atak'] < $miecz_dane -> req_sila || $user -> get['lvl'] < $miecz_dane -> req_lvl)
		{
			$zaloz = '<div class="zablokowane">Załóż</div>';
		}
		else $zaloz = '<form class="inter" method="post" action="ekwipunek.php"><input type="hidden" name="zaloz" value="'.$i['id'].'" /><input id="wskaz" value="Załóż" style="width: 58px; color: #3a6ab7;" type="submit" /></form>';

		if ($miecz_dane -> sprzedaz == 0)
		{
			$sprzedaj = '<form class="inter" method="post" action="ekwipunek.php"><input type="hidden" name="sprzedaj" value="'.$i['id'].'" /><input id="wskaz" value="Wyrzuć" style="width: 94px; color: gold;" type="submit" /></form>';
			$sprzedaj_val = '';
		}
		else
		{
			$sprzedaj = '<form class="inter" method="post" action="ekwipunek.php"><input type="hidden" name="sprzedaj" value="'.$i['id'].'" /><input id="wskaz" value="Sprzedaj" style="width: 94px; color: gold;" type="submit" /></form>';
			$sprzedaj_val = '<div class="odblokowane">'.$miecz_dane -> sprzedaz.'</div>';
		}
		
		echo '<table class="lista">
			  <tr>
				<th rowspan="5" class="av">'.$ik.'<div class="liczba">'.$count.'</div></th>
				<th class="th">'.$miecz_dane -> nazwa.'</th>
				<th></th>
			  </tr>
			  <tr>
				<td class="one">Atak</td>
				<td class="two">'.$miecz_dane -> atak.'</td>
			  </tr>
			  <tr>
				<td class="one" style="'.$niski_str.'">Wymagana siła</td>
				<td class="two" style="'.$niski_str.'">'.$miecz_dane -> req_sila.'</td>
			  </tr>
			  <tr>
				<td class="one" style="'.$niski_lvl.'">Wymagany poziom</td>
				<td class="two" style="'.$niski_lvl.'">'.$miecz_dane -> req_lvl.'</td>
			  </tr>
			  <tr>
				<td class="one padd">'.$zaloz.' lub '.$sprzedaj.'</td>
				<td class="two padd">'.$sprzedaj_val.'</td>
			  </tr>
			</table> <br />';
    }
}
else if ($zalozone == false)
{
	echo '<div class="komunikat_m komred">Nic tu nie ma. Wyrusz przykładowo do <a style="font-weight: bold; color: white; font-size: 20px;" href="sklep.php">Sklepu</a> i zakup coś.</div>';
}
	echo '</table>
				</div>
			</article>';
?>
			<article id="pancerze" class="tab-content">
				<div class="tab-text">
<?php
$zalozone = mysqli_fetch_object(mysqli_query($GLOBALS['db'], "SELECT * FROM `eq_zbroje` WHERE `stan`=1 AND `owner`=".$user -> get['id']));
if ($zalozone == true)
{
		$panc_dane = mysqli_fetch_object(mysqli_query($GLOBALS['db'], "SELECT * FROM `zbrojmistrz` WHERE `id`=".$zalozone -> id_zbroi));
		echo '<br />';
		$ik1 = '<div style="background: url(images/sklep/zbroje/'.$panc_dane -> ikonka.'.jpg); margin: 9px auto auto auto; position: absolute; top: 0; left: 0; bottom: 0; right: 0; width: 120px; height: 120px; background-size: 120px;"></div>';
		echo '<table class="lista">
			  <tr>
				<th rowspan="4" class="av">'.$ik1.'</th>
				<th class="th">'.$panc_dane -> nazwa.' <span style="color: #2d5db7;">[Założony]</span></th>
				<th></th>
			  </tr>
			  <tr>
				<td class="one">Obrona</td>
				<td class="two">'.$panc_dane -> obrona.'</td>
			  </tr>
			  <tr>
				<td class="one">Wymagany poziom</td>
				<td class="two">'.$panc_dane -> req_lvl.'</td>
			  </tr>
			  <tr>
				<td class="one padd"><form class="inter" method="post" action="ekwipunek.php"><input type="hidden" name="zdejmij_panc" value="'.$zalozone -> id.'" /><input id="wskaz" value="Zdejmij" style="width: 82px; color: #3a6ab7;" type="submit" /></form></td>
				<td></td>
			  </tr>
			</table><br />';
}

$panc = mysqli_query($GLOBALS['db'], "SELECT * FROM `eq_zbroje` WHERE `stan`=0 AND `owner`=".$user -> get['id']." GROUP BY `id_zbroi` ORDER BY `id_zbroi` DESC");
if (mysqli_num_rows($panc) > 0) 
{
	echo '<br />';
    while ($i = mysqli_fetch_array($panc))
    {
		$count = 'x'.mysqli_num_rows(mysqli_query($GLOBALS['db'], "SELECT `id` FROM `eq_zbroje` WHERE (`id_zbroi`=".$i['id_zbroi']." AND `stan`=0 AND `owner`=".$user -> get['id'].")"));
		if($count == 'x1') $count = '';

		$eq_inne = mysqli_fetch_object(mysqli_query($GLOBALS['db'], "SELECT * FROM `zbrojmistrz` WHERE `id`=".$i['id_zbroi']));
		$iko = '<img draggable="false" style="margin: 9px auto auto auto; position: absolute; top: 0; left: 0; bottom: 0; right: 0; max-width: 120px; max-height: 120px;" src="images/sklep/zbroje/'.$eq_inne -> ikonka.'.jpg" />';
		
		if ($eq_inne -> sprzedaz == 0)
		{
			$sprzedaj = 'Wyrzuć';
			$sprzedaj_val = '';
		}
		else
		{
			$sprzedaj = 'Sprzedaj';
			$sprzedaj_val = '<div class="odblokowane">'.$eq_inne -> sprzedaz.'</div>';
		}	
		
		if($user -> get['lvl'] < $eq_inne -> req_lvl) {$niski_lvl = 'color:red;';} else {$niski_lvl = '';}
		
		echo '<table class="lista">
			  <tr>
				<th rowspan="4" class="av">'.$iko.'<div class="liczba">'.$count.'</div></th>
				<th class="th">'.$eq_inne -> nazwa.'</th>
				<th></th>
			  </tr>
			  <tr>
				<td class="one">Obrona</td>
				<td class="two">'.$eq_inne -> obrona.'</td>
			  </tr>
			  <tr>
				<td class="one" style="'.$niski_lvl.'">Wymagany poziom</td>
				<td class="two" style="'.$niski_lvl.'">'.$eq_inne -> req_lvl.'</td>
			  </tr>
			  <tr>
				<td class="one padd">
					<form class="inter" method="post" action="ekwipunek.php">
						<input type="hidden" name="zaloz_panc" value="'.$i['id'].'" />
						<input id="wskaz" value="Załóż" style="width: 58px; color: #3a6ab7;" type="submit" />
					</form>
					lub
					<form class="inter" method="post" action="ekwipunek.php">
						<input type="hidden" name="sprzedaj_panc" value="'.$i['id'].'" />
						<input id="wskaz" value="Sprzedaj" style="width: 94px; color: gold;" type="submit" />
					</form></td>
				<td class="two padd">'.$sprzedaj_val.'</td>
			  </tr>
			</table>
			<br />';
    }
}
else if ($zalozone == false)
{
	echo '<div class="komunikat_m komred">Nic tu nie ma. Wyrusz przykładowo do <a style="font-weight: bold; color: white; font-size: 20px;" href="klasztor.php">Klasztoru</a> i zakup coś.</div>';
}
?>
				</div>
			</article>
			<article id="inne" class="tab-content">
				<div class="tab-text">
<?php
$inne = mysqli_query($GLOBALS['db'], "SELECT * FROM `eq_inne` WHERE `owner`=".$user -> get['id']." GROUP BY `id_inne`,`dane` ORDER BY `id` DESC");
if (mysqli_num_rows($inne) > 0) 
{
	echo '<br />';
    while ($i = mysqli_fetch_array($inne))
    {
		$count = 'x'.mysqli_num_rows(mysqli_query($GLOBALS['db'], "SELECT `id` FROM `eq_inne` WHERE (`id_inne`=".$i['id_inne']." AND `typ`='".$i['typ']."' AND `owner`=".$user -> get['id'].")"));
		if($count == 'x1') $count = '';

		$eq_inne = mysqli_fetch_object(mysqli_query($GLOBALS['db'], "SELECT * FROM `".$i['dane']."` WHERE `id`=".$i['id_inne']));
		$iko = '<img draggable="false" style="margin: 19px auto auto auto; position: absolute; top: 0; left: 0; bottom: 0; right: 0; max-width: 100px; max-height: 100px;" src="images/sklep/'.$i['dane'].'/'.$eq_inne -> ikonka.'.png" />';
		
		if ($eq_inne -> sprzedaz == 0)
		{
			$sprzedaj = 'Wyrzuć';
			$sprzedaj_val = '';
		}
		else
		{
			$sprzedaj = 'Sprzedaj';
			$sprzedaj_val = '<div class="odblokowane">'.$eq_inne -> sprzedaz.'</div>';
		}
		
		if($i['typ'] == 'potka_hp')
		{
			if($user -> get['hp'] == $user -> get['maxhp'])
			{
				$uzyj = '<div class="zablokowane" style="width: 51px;">Użyj</div> lub';
			}
			else
			{
				$uzyj = '<form class="inter" method="post" action="ekwipunek.php"><input type="hidden" name="uzyj" value="'.$i['id'].'" /><input id="wskaz" value="Użyj" style="width: 51px; color: #3a6ab7;" type="submit" /></form> lub';
			}
		}
		else if($i['typ'] == 'rupiec')
		{
			$uzyj = '';
		}
		else
		{
			$uzyj = '<form class="inter" method="post" action="ekwipunek.php"><input type="hidden" name="uzyj" value="'.$i['id'].'" /><input id="wskaz" value="Użyj" style="width: 51px; color: #3a6ab7;" type="submit" /></form> lub';
		}
		
		if($i['typ'] == 'potka_hp')
		{
			$wartosc = 'Leczenie';
			$war_suff = ' HP';
		}
		else
		{
			$wartosc = 'Wartość';
			$war_suff = '';
		}
		
		if($eq_inne -> wartosc == 0)
		{
			$wartosc = '<div style="height: 25px;"></div>';
			$war = '';
		}
		else $war = $eq_inne -> wartosc;
		
		echo '<table class="lista">
			  <tr>
				<th rowspan="4" class="av">'.$iko.'<div class="liczba">'.$count.'</div></th>
				<th class="th_inne">'.$eq_inne -> nazwa.'</th>
				<th></th>
			  </tr>
			  <tr>
				<td class="mone">'.$i['typ_nazwa'].'</td>
				<td class="mtwo"></td>
			  </tr>
			  <tr>
				<td class="one">'.$wartosc.'</td>
				<td class="two">'.$war.''.$war_suff.'</td>
			  </tr>
			  <tr>
				<td class="one padd">'.$uzyj.' <form class="inter" method="post" action="ekwipunek.php"><input type="hidden" name="sprzedaj_inne" value="'.$i['id'].'" /><input id="wskaz" value="Sprzedaj" style="width: 94px; color: gold;" type="submit" /></form></td>
				<td class="two padd">'.$sprzedaj_val.'</td>
			  </tr>
			</table> <br />';
    }
}
else
{
	echo '<div class="komunikat_m komred">Nic tu nie ma. Wyrusz przykładowo do <a style="font-weight: bold; color: white; font-size: 20px;" href="klasztor.php">Klasztoru</a> i zakup coś.</div>';
}
?>
				</div>
			</article>
		</div>
		<script src="zakladki/zakladki2.js"></script>
		<link href="zakladki/zakladki2.css" rel="stylesheet" />
    </div>
    <div class="postfooter"></div>
</div>

<?php
require_once('bottom.php');
?>