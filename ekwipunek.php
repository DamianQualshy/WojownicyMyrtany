<?php
require_once('head.php');
?>

<div class="post">
    <div class="postheader"><h1>Ekwipunek</h1></div>
	<div class="postcontent">
	<div class="postbg" style="background: url(images/tla_strony/ekwipunek.jpg);"></div>
	<div class="postbreak"></div>
<?php
if (isset($_GET['zaloz']))
{
    $item = mysqli_fetch_array(mysqli_query($GLOBALS['db'], "SELECT * FROM `ekwipunek` WHERE `id`=".$_GET['zaloz']." AND `owner`=".$user -> get['id']));
	if ($item == true)
	{
		if ($item['stan'] == '0')
		{
			if ($item['req_poz'] <= $user -> get['lvl'])
			{
				if ($item['req_str'] <= $user -> get['atak'])
				{
					$item = mysqli_fetch_array(mysqli_query($GLOBALS['db'], "SELECT `id` FROM `ekwipunek` WHERE `stan`=1 AND `owner`=".$user -> get['id']));		
					mysqli_query($GLOBALS['db'], "UPDATE `ekwipunek` SET `stan`=1 WHERE `id`=".$_GET['zaloz']);
					mysqli_query($GLOBALS['db'], "UPDATE `ekwipunek` SET `stan`=0 WHERE `id`=".$item['id']);
					echo '<span class="komunikat" style="color:green;">Przedmiot został założony!</span><br /><br />';
				}
				else echo '<div class="komunikat" style="color:red;">Nie spełniasz wymagań dla przedmiotu: <i><b>'.$item['nazwa'].'</b></i></div><br /><br />';
			}
			else echo '<div class="komunikat" style="color:red;">Nie spełniasz wymagań dla przedmiotu: <i><b>'.$item['nazwa'].'</b></i></div><br /><br />';
		}
		else echo '<span class="komunikat" style="color:red;">Już założyłeś ten przedmiot!</span><br /><br />';
    }
	else echo $item['stan'].'<span class="komunikat" style="color:red;">Nie posiadasz takiego przedmiotu!</span><br /><br />';
}

if (isset($_GET['zdejmij']))
{
    $item = mysqli_fetch_array(mysqli_query($GLOBALS['db'], "SELECT * FROM `ekwipunek` WHERE `stan`=1 AND `id`=".$_GET['zdejmij']." AND `owner`=".$user -> get['id']));
	if ($item == true)
	{
        mysqli_query($GLOBALS['db'], "UPDATE `ekwipunek` SET `stan`=0 WHERE `id`=".$_GET['zdejmij']);
        echo '<span class="komunikat" style="color:green;">Przedmiot został schowany do plecaka!</span><br /><br />';
    }
	else echo '<span class="komunikat" style="color:red;">Nie posiadasz takiego przedmiotu!</span><br /><br />';
}

if (isset($_GET['sprzedaj']))
{
    if (preg_match("/^[0-9]*$/", $_GET['sprzedaj']) && !empty($_GET['sprzedaj']))
    {
	    $sprzed2 = mysqli_fetch_array(mysqli_query($GLOBALS['db'], 'SELECT `id_broni`,`id` FROM `ekwipunek` WHERE `id`='.$_GET['sprzedaj']));
	    $sprzed = mysqli_fetch_array(mysqli_query($GLOBALS['db'], 'SELECT `sprzedaz` FROM `sklep` WHERE `id`='.$sprzed2['id_broni']));
	    if ($sprzed == true)
		{
			mysqli_query($GLOBALS['db'], "DELETE FROM `ekwipunek` WHERE `id`='".$sprzed2['id']."'");
			mysqli_query($GLOBALS['db'], "UPDATE `konta` SET `kasa`=`kasa`+".$sprzed['sprzedaz']." WHERE `id`=".$user -> get['id']);
			echo '<p class="komunikat" style="color:green;">Przedmiot został sprzedany!</p>';
		}
		else echo '<p class="komunikat" style="color:red;">Nie ma takiego przedmiotu w ekwipunku!</p>';
	}
	else echo '<p class="komunikat" style="color:red;">Nie ma takiego przedmiotu w ekwipunku!</p>';
}

$equip = mysqli_query($GLOBALS['db'], "SELECT * FROM `ekwipunek` WHERE `stan`=0 AND `owner`=".$user -> get['id']." ORDER BY `id` DESC");

$zalozone = mysqli_fetch_object(mysqli_query($GLOBALS['db'], "SELECT * FROM `ekwipunek` WHERE `stan`=1 AND `owner`=".$user -> get['id']));
if ($zalozone == true)
{
		$miecz_dane = mysqli_fetch_object(mysqli_query($GLOBALS['db'], "SELECT * FROM `sklep` WHERE `id`=".$zalozone -> id_broni));
		echo '<h3 style="text-align: center;">Przedmioty założone</h3><br />';
		$ik1 = '<div style="background: url(/images/sklep/'.$miecz_dane -> ikonka.'.png); margin: 19px auto auto auto; position: absolute; top: 0; left: 0; bottom: 0; right: 0; max-width: 100px; max-height: 100px;"></div>';
		echo '<table style="margin: 0px auto;">
			  <tr>
				<th style="background: url(images/bck.png) no-repeat center 5px; background-size: 130px 130px; position: relative; width: 130px; height: 130px; padding-right: 30px;" rowspan="5">'.$ik1.'</th>
				<th style="font-style: italic; padding-bottom: 10px; width: 275px;">'.$miecz_dane -> nazwa.'</th>
				<th></th>
			  </tr>
			  <tr>
				<td style="width: 275px;">Atak</td>
				<td style="width: 35px;">'.$miecz_dane -> atak.'</td>
			  </tr>
			  <tr>
				<td style="width: 275px;">Wymagana siła</td>
				<td style="width: 35px;">'.$miecz_dane -> req_sila.'</td>
			  </tr>
			  <tr>
				<td style="width: 275px;">Wymagany poziom</td>
				<td style="width: 35px;">'.$miecz_dane -> req_lvl.'</td>
			  </tr>
			  <tr>
				<td style="padding-top: 25px; width: 275px; color: whitesmoke;"><a style="color: #3a6ab7; font-size: 22px" href="ekwipunek.php?zdejmij='.$zalozone -> id.'">Zdejmij</a></td>
				<td style="width: 35px;"></td>
			  </tr>
			</table> <br />';
}


if (mysqli_num_rows($equip) > 0) 
{
	echo '<br /><h3 style="text-align: center;">Przedmioty w ekwipunku</h3><br />';
    while ($i = mysqli_fetch_array($equip))
    {
		$miecz_dane = mysqli_fetch_object(mysqli_query($GLOBALS['db'], "SELECT * FROM `sklep` WHERE `id`=".$i['id_broni']));
		$ik = '<div style="background: url(/images/sklep/'.$miecz_dane -> ikonka.'.png); margin: 19px auto auto auto; position: absolute; top: 0; left: 0; bottom: 0; right: 0; max-width: 100px; max-height: 100px;"></div>';
		if($user -> get['atak'] < $miecz_dane -> req_sila) {$niski_str = 'color:red;';} else {$niski_str = '';}
		if($user -> get['lvl'] < $miecz_dane -> req_lvl) {$niski_lvl = 'color:red;';} else {$niski_lvl = '';}
		echo '<table style="margin: 0px auto;">
			  <tr>
				<th rowspan="5" style="background: url(images/bck.png) no-repeat center 5px; background-size: 130px 130px; position: relative; width: 130px; height: 130px; padding-right: 30px;">'.$ik.'</th>
				<th style="font-style: italic; padding-bottom: 10px; width: 275px;">'.$miecz_dane -> nazwa.'</th>
				<th></th>
			  </tr>
			  <tr>
				<td style="width: 275px;">Atak</td>
				<td style="width: 35px;">'.$miecz_dane -> atak.'</td>
			  </tr>
			  <tr>
				<td style="'.$niski_str.' width: 275px;">Wymagana siła</td>
				<td style="'.$niski_str.' width: 35px;">'.$miecz_dane -> req_sila.'</td>
			  </tr>
			  <tr>
				<td style="'.$niski_lvl.' width: 275px;">Wymagany poziom</td>
				<td style="'.$niski_lvl.' width: 35px;">'.$miecz_dane -> req_lvl.'</td>
			  </tr>
			  <tr>
	<td style="padding-top: 25px; color: whitesmoke; width: 275px;"><a style="color: #3a6ab7; font-size: 22px" href="ekwipunek.php?zaloz='.$i['id'].'">Załóż</a> <span>lub</span> <a style="color: gold; font-size: 20px" href="ekwipunek.php?sprzedaj='.$i['id'].'">Sprzedaj</a></td>
				<td style="padding-top: 25px; width: 35px;"><b><font style=" color: #c4b61d">'.$miecz_dane -> sprzedaz.'</font></b></td>
			  </tr>
			</table> <br />';
    }
}
else if ($zalozone == false) { echo '<div style="text-align: center; color: red;">Plecak jest pusty</div>';}
?>

    </div>
    <div class="postfooter"></div>
</div>

<?php
require_once('bottom.php');
?>