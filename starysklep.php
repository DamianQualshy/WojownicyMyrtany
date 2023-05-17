<?php
require_once('head.php');
?>

<div class="post">
    <div class="postheader"><h1>Sklep</h1></div>
	<div class="postcontent">
	<div class="postbg" style="background: url(images/tla_strony/sklep.jpg);"></div>
	<div class="postbreak"></div>
<?php
if (isset($_GET['kup']))
{
    if (preg_match("/^[0-9]*$/", $_GET['kup']) && !empty($_GET['kup']))
    {
	    $check = mysqli_fetch_array(mysqli_query($GLOBALS['db'], 'SELECT `id`,`cena` FROM `sklep` WHERE `id`='.$_GET['kup']));
	    if ($check == true)
		{
	        if ($user -> get['kasa'] >= $check['cena'])
    		{
                mysqli_query($GLOBALS['db'], "INSERT INTO `ekwipunek` (`owner`, `id_broni`) VALUES (".$user -> get['id'].", ".$check['id'].")");
                mysqli_query($GLOBALS['db'], "UPDATE `konta` SET `kasa`=`kasa`-".$check['cena']." WHERE `id`=".$user -> get['id']);
                echo '<span class="komunikat" style="color:green;">Przedmiot został zakupiony!</span><br /><br />';
            }
	    	else echo '<span class="komunikat" style="color:red;">Nie stać Cię!</span><br /><br />';
		}
		else echo '<span class="komunikat" style="color:red;">Nie ma takiego przedmiotu w sklepie!</span><br /><br />';
	}
	else echo '<span class="komunikat" style="color:red;">Nie ma takiego przedmiotu w sklepie!</span><br /><br />';
}


$a = mysqli_query($GLOBALS['db'], "SELECT * FROM `sklep` ORDER BY `atak` ASC");
while($item = mysqli_fetch_array($a))
{
	$ik = '<div style="background: url(/images/sklep/'.$item['ikonka'].'.png); margin: 19px auto auto auto; position: absolute; top: 0; left: 0; bottom: 0; right: 0; max-width: 100px; max-height: 100px;"></div>';

	if($user -> get['atak'] < $item['req_sila']) {$niski_str = 'color:red;';} else {$niski_str = '';}
	if($user -> get['lvl'] < $item['req_lvl']) {$niski_lvl = 'color:red;';} else {$niski_lvl = '';}
	if($user -> get['kasa'] < $item['cena']) {$malo_kasy = 'color:#6b7272;'; $kup = 'Kup';} else {$malo_kasy = 'color:#c4b61d;'; $kup = '<a style="'.$malo_kasy.' font-size: 25px;" href="sklep.php?kup='.$item['id'].'">Kup</a>';}

	echo '<table style="margin: 0px auto;">
		  <tr>
			<th style="background: url(images/bck.png) no-repeat center 5px; background-size: 130px 130px; position: relative; width: 130px; height: 130px; padding-right: 30px;" rowspan="5">'.$ik.'</th>
			<th style="font-style: italic; padding-bottom: 10px;">'.$item['nazwa'].'</th>
			<th></th>
		  </tr>
		  <tr>
			<td style="width: 275px;">Atak</td>
			<td style="width: 55px;">'.$item['atak'].'</td>
		  </tr>
		  <tr>
			<td style="'.$niski_str.' width: 275px;">Wymagana siła</td>
			<td style="'.$niski_str.' width: 55px;">'.$item['req_sila'].'</td>
		  </tr>
		  <tr>
			<td style="'.$niski_lvl.' width: 275px;">Wymagany poziom</td>
			<td style="'.$niski_lvl.' width: 55px;">'.$item['req_lvl'].'</td>
		  </tr>
		  <tr>
			<td style="'.$malo_kasy.' font-weight: bold; font-size: 25px; font-style: italic; padding-top: 25px;">'.$kup.'</td>
			<td style="padding-top: 25px; width: 55px; '.$malo_kasy.'; font-size: 25px">'.$item['cena'].'</td>
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