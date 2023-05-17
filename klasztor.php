<?php
require_once('head.php');
?>

<div class="post">
    <div class="postheader"><h1>Klasztor</h1></div>
	<div class="postcontent">
	<div class="postbg" style="background: url(images/tla_strony/klasztor.jpg);"></div>
	<div class="postbreak"></div>
<?php
$postbreak = '<img src="css/images/contentmargin.png" border="0" style="margin-left: -20px;margin-top: -20px;">';

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
	else $postbreak = '';
}


echo '<br />';
echo $postbreak;


if (isset($_GET['kup']))
{
    if (preg_match("/^[0-9]*$/", $_GET['kup']) && !empty($_GET['kup']))
    {
	    $zakupiony = mysqli_fetch_array(mysqli_query($GLOBALS['db'], 'SELECT * FROM `klasztor` WHERE `id`='.$_GET['kup']));
	    if ($zakupiony == true)
		{
	        if ($user -> get['hp'] < $user -> get['maxhp'])
    		{
				if ($user -> get['kasa'] >= $zakupiony['cena'])
				{
					if ($user -> get['hp'] + $zakupiony['leczy'] > $user -> get['maxhp'])
					{
						mysqli_query($GLOBALS['db'], 'UPDATE `konta` SET `hp`='.$user -> get['maxhp'].' WHERE `id`='.$user -> get['id']);
					}
					else
					{
						mysqli_query($GLOBALS['db'], 'UPDATE `konta` SET `hp`='.$user -> get['hp'].'+'.$zakupiony['leczy'].' WHERE `id`='.$user -> get['id']);
					}
					mysqli_query($GLOBALS['db'], "UPDATE `konta` SET `kasa`=`kasa`-".$zakupiony['cena']." WHERE `id`=".$user -> get['id']);
					echo '<p style="color:green;">Przedmiot został zakupiony!</p>';
				}
				else echo '<p style="color:red;">Nie stać Cię!</p>';
            }
	    	else echo '<p style="color:red;">Nie potrzebujesz leczenia.</p>';
		}
		else echo '<p style="color:red;">Nie ma takiego przedmiotu w sklepie!</p>';
	}
	else echo '<p style="color:red;">Nie ma takiego przedmiotu w sklepie!</p>';
}

if ($postbreak == '')
{
	echo '<div style="text-align: center; margin-bottom: 10px;">Nie potrzebujesz leczenia. Wróć kiedy będziesz ranny.</div>';
}
else
{
    $klasztor_sklep = mysqli_query($GLOBALS['db'], "SELECT * FROM `klasztor` ORDER BY `cena` ASC");
    while($item = mysqli_fetch_array($klasztor_sklep))
	{
		$ik = '<img draggable="false" style="margin: 19px auto auto auto; position: absolute; top: 0; left: 0; bottom: 0; right: 0; max-width: 100px; max-height: 100px;" src="/images/sklep/klasztor/'.$item['ikonka'].'.png" />';
		echo '<table style="margin: 0px auto;">
			  <tr>
				<th style="background: url(images/bck.png) no-repeat center 5px; background-size: 130px 130px; position: relative; width: 130px; height: 140px; padding-right: 30px;" rowspan="3">'.$ik.'</th>
				<th style="font-style: italic; padding-bottom: 10px;">'.$item['nazwa'].'</th>
				<th></th>
			  </tr>
			  <tr>
				<td style="width: 215px;">Leczenie</td>
				<td style="width: 85px;">'.$item['leczy'].' HP</td>
			  </tr>
			  <tr>
				<td style="padding-top: 25px; color: whitesmoke; width: 215px;"><a style="color: gold; font-size: 25px" href="klasztor.php?kup='.$item['id'].'">Ulecz się</a></td>
				<td style="padding-top: 25px; width: 85px;"><font style="color: #c4b61d">'.$item['cena'].'</font></td>
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