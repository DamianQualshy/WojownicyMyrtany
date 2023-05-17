<?php
require_once('head.php');
?>

<div class="post">
    <div class="postheader"><h1>Klasztor</h1></div>
	<div class="postcontent">
	<div class="postbg" style="background: url(images/tla_strony/klasztor.jpg);"></div>
	<div class="postbreak"></div>
<?php
$douleczenia = $user -> get['maxhp'] - $user -> get['hp'];
$douleczenia2 = $douleczenia/2;
$douleczenia3 = round($douleczenia2, 0);

 
$data_dzisiaj = date("Ymd"); 
$jeden_dzien = strtotime(date("Ymd", strtotime($data_dzisiaj)) . " +1 day"); 
$za_jeden_dzien = date('Ymd', $jeden_dzien);

if (isset($_GET['akcja']) && $_GET['akcja'] == 'ulecz')
{
	if ($user -> get['ostatnie_leczenie'] != 0)
	{
		if ($user -> get['ostatnie_leczenie'] <= $data_dzisiaj)
		{
			mysqli_query($GLOBALS['db'], 'UPDATE `konta` SET `hp`='.$user -> get['hp'].'+'.$douleczenia3.' WHERE `id`='.$user -> get['id']);
			mysqli_query($GLOBALS['db'], 'UPDATE `konta` SET `ostatnie_leczenie`='.$za_jeden_dzien.' WHERE `id`='.$user -> get['id']);
			echo '<div style="text-align: center; margin-bottom: 10px;">Tutejsi magowie modlili się o zdrowie dla Ciebie.</div>';
		}
		else echo '<div style="text-align: center; margin-bottom: 10px;">Możesz prosić magów o leczenie raz na dzień.</div>';
	}
	else if ($user -> get['ostatnie_leczenie'] == 0)
	{
			mysqli_query($GLOBALS['db'], 'UPDATE `konta` SET `hp`='.$user -> get['hp'].'+'.$douleczenia3.' WHERE `id`='.$user -> get['id']);
			mysqli_query($GLOBALS['db'], 'UPDATE `konta` SET `ostatnie_leczenie`='.$za_jeden_dzien.' WHERE `id`='.$user -> get['id']);
			echo '<div style="text-align: center; margin-bottom: 10px;">Tutejsi magowie modlili się o zdrowie dla Ciebie.</div>';

	}
}
else
{

	if ($user -> get['hp'] != $user -> get['maxhp'])
	{
		if ($user -> get['ostatnie_leczenie'] != 0)
		{
			if ($user -> get['ostatnie_leczenie'] <= $data_dzisiaj)
			{
				echo '<table style="margin: 0 auto;"><tr><td><p style="padding: 0px 10px 10px 0px;">Możesz poprosić magów o modlitwę raz na dzień.<br />Ich modlitwa przywróci połowę utraconego zdrowia.<br></p><td><div id="hst0" style="display: ;"><a href="klasztor.php?akcja=ulecz"><input class="gothbutton" type="button" value="Ulecz mnie" /></a></div></tr></table>';
			}
			else echo '<div style="text-align: center; margin-bottom: 10px;">Magowie już dziś się o Ciebie modlili.</div>';
		}
		else if ($user -> get['ostatnie_leczenie'] == 0)
		{
			echo '<table style="margin: 0 auto;"><tr><td><p style="padding: 0px 10px 10px 0px;">Możesz poprosić magów o modlitwę raz na dzień.<br />Ich modlitwa przywróci połowę utraconego zdrowia.<br></p><td><div id="hst0" style="display: ;"><a href="klasztor.php?akcja=ulecz"><input class="gothbutton" type="button" value="Ulecz mnie" /></a></div></tr></table>';
		}
	}
	else echo '<div style="text-align: center; margin-bottom: 10px;">Jeśli będziesz ranny, możesz tutaj wrócić by otrzymać darmowe leczenie dzięki modlitwie tutejszych magów.</div>';
}

echo '<br /><div class="postbreak"></div>';

if (isset($_POST['kup']))
{
	$zakupiony = mysqli_fetch_array(mysqli_query($GLOBALS['db'], 'SELECT `cena` FROM `klasztor` WHERE `id`='.$_POST['kup']));
	if ($zakupiony == true)
	{
		if ($user -> get['kasa'] >= $zakupiony['cena'])
		{
			mysqli_query($GLOBALS['db'], 'INSERT INTO `eq_inne` (`owner`, `id_inne`, `dane`, `typ`) VALUES ('.$user -> get['id'].', '.$_POST['kup'].', "klasztor", "potka_hp")');
			mysqli_query($GLOBALS['db'], "UPDATE `konta` SET `kasa`=`kasa`-".$zakupiony['cena']." WHERE `id`=".$user -> get['id']);
			echo '<div class="komunikat komgreen">Przedmiot został zakupiony!</div>';
		}
		else echo '<div class="komunikat komred">Nie stać Cię!</div>';
	}
	else echo '<div class="komunikat komred">Nie ma takiego przedmiotu w sklepie!</div>';
}

    $klasztor_sklep = mysqli_query($GLOBALS['db'], "SELECT * FROM `klasztor` ORDER BY `cena` ASC");
    while($item = mysqli_fetch_array($klasztor_sklep))
	{
		$ik = '<img draggable="false" style="margin: 19px auto auto auto; position: absolute; top: 0; left: 0; bottom: 0; right: 0; max-width: 100px; max-height: 100px;" src="images/sklep/klasztor/'.$item['ikonka'].'.png" />';
		
		if($user -> get['kasa'] < $item['cena']) {$cena = '<div class="zablokowane">'.$item['cena'].'</div>'; $kup = '<div class="zablokowane">Kup</div>';} else {$cena = '<div class="odblokowane">'.$item['cena'].'</div>'; $kup = '
		<form class="inter" method="post" action="klasztor.php">
		<input type="hidden" name="kup" value="'.$item['id'].'" />
		<input id="wskaz" value="Kup" style="width: 50px; color: gold;" type="submit" />
		</form>';}
		
		echo '<table class="lista">
			  <tr>
				<th rowspan="3" class="av">'.$ik.'</th>
				<th class="th">'.$item['nazwa'].'</th>
				<th></th>
			  </tr>
			  <tr>
				<td class="one">Leczenie</td>
				<td class="two">'.$item['wartosc'].' HP</td>
			  </tr>
			  <tr>
				<td class="one padd" style="padding-top: 45px;">'.$kup.'</td>
				<td class="two padd" style="padding-top: 45px;">'.$cena.'</td>
			  </tr>
			  </table><br />';
    }
?>
    </div>
    <div class="postfooter"></div>
</div>
<?php
require_once('bottom.php');
?>	 