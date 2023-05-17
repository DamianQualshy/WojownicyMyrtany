<?php
require_once('head.php');
?>

<div class="post">
    <div class="postheader"><h1>Targowisko</h1></div>
	<div class="postcontent">
	<div class="postbg" style="background: url(images/tla_strony/sklep.jpg);"></div>
	<div class="postbreak"></div>
		<center>
		<div class="tabs">
			<a href="#kowal" class="active">Kowal</a>
			<a href="#zbrojmistrz">Zbrojmistrz</a>
			<a href="#zielarz">Zielarz</a>
		</div>
		</center>
		<br />
<?php
if (isset($_POST['kup']))
{
    if (preg_match("/^[0-9]*$/", $_POST['kup']) && !empty($_POST['kup']))
    {
	    $check = mysqli_fetch_array(mysqli_query($GLOBALS['db'], 'SELECT `id`,`cena` FROM `sklep` WHERE `id`='.$_POST['kup']));
	    if ($check == true)
		{
	        if ($user -> get['kasa'] >= $check['cena'])
    		{
                mysqli_query($GLOBALS['db'], "INSERT INTO `ekwipunek` (`owner`, `id_broni`) VALUES (".$user -> get['id'].", ".$check['id'].")");
                mysqli_query($GLOBALS['db'], "UPDATE `konta` SET `kasa`=`kasa`-".$check['cena']." WHERE `id`=".$user -> get['id']);
                echo '<div class="komunikat komgreen">Przedmiot został zakupiony!</div>';
            }
	    	else echo '<div class="komunikat komred">Nie stać Cię!</div>';
		}
		else echo '<div class="komunikat komred">Nie ma takiego przedmiotu w sklepie!</div>';
	}
	else echo '<div class="komunikat komred">Nie ma takiego przedmiotu w sklepie!</div>';
}

if (isset($_POST['kup_panc']))
{
    if (preg_match("/^[0-9]*$/", $_POST['kup_panc']) && !empty($_POST['kup_panc']))
    {
	    $check = mysqli_fetch_array(mysqli_query($GLOBALS['db'], 'SELECT `id`,`cena` FROM `zbrojmistrz` WHERE `id`='.$_POST['kup_panc']));
	    if ($check == true)
		{
	        if ($user -> get['kasa'] >= $check['cena'])
    		{
                mysqli_query($GLOBALS['db'], "INSERT INTO `eq_zbroje` (`owner`, `id_zbroi`) VALUES (".$user -> get['id'].", ".$check['id'].")");
                mysqli_query($GLOBALS['db'], "UPDATE `konta` SET `kasa`=`kasa`-".$check['cena']." WHERE `id`=".$user -> get['id']);
                echo '<div class="komunikat komgreen">Przedmiot został zakupiony!</div>';
            }
	    	else echo '<div class="komunikat komred">Nie stać Cię!</div>';
		}
		else echo '<div class="komunikat komred">Nie ma takiego przedmiotu w sklepie!</div>';
	}
	else echo '<div class="komunikat komred">Nie ma takiego przedmiotu w sklepie!</div>';
}

echo '<div style="display: none;" id="tabs-container" class="tabs-container">
			<article id="kowal" class="tab-content active">
				<div class="tab-text">';
$a = mysqli_query($GLOBALS['db'], "SELECT * FROM `sklep` ORDER BY `atak` ASC");
while($item = mysqli_fetch_array($a))
{
	$ik = '<div style="background: url(images/sklep/'.$item['ikonka'].'.png); margin: 19px auto auto auto; position: absolute; top: 0; left: 0; bottom: 0; right: 0; max-width: 100px; max-height: 100px;"></div>';

	if($user -> get['atak'] < $item['req_sila']) {$niski_str = 'color:red;';} else {$niski_str = '';}
	if($user -> get['lvl'] < $item['req_lvl']) {$niski_lvl = 'color:red;';} else {$niski_lvl = '';}
	if($user -> get['kasa'] < $item['cena']) {$cena = '<div class="zablokowane">'.$item['cena'].'</div>'; $kup = '<div class="zablokowane">Kup</div>';} else {$cena = '<div class="odblokowane">'.$item['cena'].'</div>'; $kup = '<form class="inter" method="post" action="sklep.php"><input type="hidden" name="kup" value="'.$item['id'].'" /><input id="wskaz" value="Kup" style="width: 50px; color: gold;" type="submit" /></form>';}

	if($item['niedostepne'] == 0)
	{
		echo '<table class="lista">
			  <tr>
				<th rowspan="5" class="av">'.$ik.'</th>
				<th class="th">'.$item['nazwa'].'</th>
				<th></th>
			  </tr>
			  <tr>
				<td class="one">Atak</td>
				<td class="two">'.$item['atak'].'</td>
			  </tr>
			  <tr>
				<td class="one" style="'.$niski_str.'">Wymagana siła</td>
				<td class="two" style="'.$niski_str.'">'.$item['req_sila'].'</td>
			  </tr>
			  <tr>
				<td class="one" style="'.$niski_lvl.'">Wymagany poziom</td>
				<td class="two" style="'.$niski_lvl.'">'.$item['req_lvl'].'</td>
			  </tr>
			  <tr>
				<td class="one padd">'.$kup.'</td>
				<td class="two padd">'.$cena.'</td>
			  </tr>
			  </table><br />';
	}
}

		echo '</table>
				</div>
			</article>';
?>
			<article id="zbrojmistrz" class="tab-content">
				<div class="tab-text">
<?php
$a = mysqli_query($GLOBALS['db'], "SELECT * FROM `zbrojmistrz` ORDER BY `obrona` ASC");
while($item = mysqli_fetch_array($a))
{
	$ik = '<div style="background: url(images/sklep/zbroje/'.$item['ikonka'].'.jpg); margin: 9px auto auto auto; position: absolute; top: 0; left: 0; bottom: 0; right: 0; max-width: 120px; max-height: 120px; background-size: 120px;"></div>';

	if($user -> get['lvl'] < $item['req_lvl']) {$niski_lvl = 'color:red;';} else {$niski_lvl = '';}
	if($user -> get['kasa'] < $item['cena']) {$cena = '<div class="zablokowane">'.$item['cena'].'</div>'; $kup = '<div class="zablokowane">Kup</div>';} else {$cena = '<div class="odblokowane">'.$item['cena'].'</div>'; $kup = '<form class="inter" method="post" action="sklep.php"><input type="hidden" name="kup_panc" value="'.$item['id'].'" /><input id="wskaz" value="Kup" style="width: 50px; color: gold;" type="submit" /></form>';}

	if($item['niedostepne'] == 0)
	{
		echo '<table class="lista">
			  <tr>
				<th rowspan="5" class="av">'.$ik.'</th>
				<th class="th">'.$item['nazwa'].'</th>
				<th></th>
			  </tr>
			  <tr>
				<td class="one">Obrona</td>
				<td class="two">'.$item['obrona'].'</td>
			  </tr>
			  <tr>
				<td class="one" style="'.$niski_lvl.'">Wymagany poziom</td>
				<td class="two" style="'.$niski_lvl.'">'.$item['req_lvl'].'</td>
			  </tr>
			  <tr>
				<td class="one padd">'.$kup.'</td>
				<td class="two padd">'.$cena.'</td>
			  </tr>
			  </table><br />';
	}
}
?>
				</div>
			</article>
			<article id="zielarz" class="tab-content">
				<div class="tab-text">
				</div>
			</article>
		</div>
		<script src="zakladki/zakladki2.js"></script>
		<link href="zakladki/zakladki.css" rel="stylesheet" />
     </div>
     <div class="postfooter"></div>
</div>

<?php
require_once('bottom.php');
?>