<?php
require_once('head.php');

if (isset($_GET['name']))
{
	$header = $_GET['name'];
}
else $header = 'Szukaj gracza';


echo '<div class="post" style="font-size: 20px;">
    <div class="postheader"><h1>'.$header.'</h1></div>
	<div class="postcontent">';

$fontwielkosc = 'font-size: 32px; color: #55a;';
$fontwielkosc1 = '32px';
$wielkosc = '140px';
$wielkosc_tla = '160px';

$szukanie_form = '<table style="margin: 0 auto;">
			<tr>
				<td height="35px;"><form method="get" action="">Szukaj gracza: </td>
				<td height="35px;"><input class="formul" type="text" name="name"> </td>
			<tr>
			<tr>
				<td height="35px;"></td>
				<td height="35px;"><input class="gothbutton" type="submit" value="Szukaj"></form></td>
			<tr>
			</table>';

if (isset($_GET['name']))
{
    $szukanie_gracz = mysqli_fetch_object(mysqli_query($GLOBALS['db'], "SELECT * FROM `konta` WHERE `login`='".$_GET['name']."'"));	
    if ($szukanie_gracz == true)
    {
?>
	<br />
	<table style="margin: 0 auto;">
		<tr>
			<?php
			$file_name = 'images/av_graczy/'.$szukanie_gracz -> login.'_av.png';
			if ($szukanie_gracz -> awatar_domyslny == 1)
			{
				if (file_exists($file_name))
				{
					echo '<th style="padding-bottom: 5px;" rowspan="3">
					<div style="background: url(images/bck.png) no-repeat center center; background-size: '.$wielkosc_tla.' '.$wielkosc_tla.'; position: relative; width:'.$wielkosc.'; height:'.$wielkosc.';" >
					<img style="margin: auto; position: absolute; top: 0; left: 0; bottom: 0; right: 0;max-width: '.$wielkosc.'; max-height: '.$wielkosc.';" src="'.$file_name.'?'.filemtime($file_name).'" />
					<img draggable="false" style="position: relative; max-width: '.$wielkosc.'; max-height: '.$wielkosc.';" src="images/awatary/ramka.png" />
					</div>';
				}
				else
				{
				echo '<img height="'.$wielkosc.'" src="images/awatary/DefAV.png" alt="member" />';
				mysqli_query($GLOBALS['db'], "UPDATE `konta` SET `awatar_domyslny`=0 WHERE `id`=".$szukanie_gracz -> id);	
				} 
			}
			else
			{
				echo '<th rowspan="3">';
				switch ($szukanie_gracz -> awatar_domyslny)
				{
					case 0: $awatar = 'DefAV.png'; break;
					case 2: $awatar = 'cien.png'; break;
					case 3: $awatar = 'szkodnik.png'; break;
					case 4: $awatar = 'nowicjusz.png'; break;
					default: $awatar = 'DefAV.png'; break;
				}
				echo '<img style="width: '.$wielkosc.'; height: '.$wielkosc.';" src="images/awatary/'.$awatar.'" alt="member" />';
			}
			?>
			</th>
			<th style="padding-left: 10px; text-align:left; vertical-align:top;">
				<span>
				<font style="font-size: <?php echo $fontwielkosc1 ?>;">
				<?php $oboz = mysqli_fetch_array(mysqli_query($GLOBALS['db'], "SELECT * FROM `frakcje` WHERE `id`='".$szukanie_gracz -> oboz_id."'")); if($oboz == true) {echo '['.$oboz['skrot_frakcji'].'] ';} echo $szukanie_gracz -> login; ?>
				</font>
				</span>
			</th>
		</tr>
		<tr>
			<td style="padding-left: 10px; text-align:left; vertical-align:top;">
				<span><font style="font-style: italic; font-size: <?php echo $fontwielkosc1 ?>;"><?php include('includes/ranga.php'); ?></font></span>
			</td>
		</tr>
		<tr>
			<td style="padding-left: 10px; text-align:left; vertical-align:top;">
				<span><font style="font-size: <?php echo $fontwielkosc1 ?>;">Poziom: </font><font style="<?php echo $fontwielkosc ?>"><?php echo $szukanie_gracz -> lvl; ?></font></span>
			</td>
		</tr>
		<tr>
			<td colspan="2" style="text-align:center; vertical-align:top;">
			Atak: <font style="<?php echo $fontwielkosc ?>"><?php echo $szukanie_gracz -> atak; ?></font> Obrona: <font style="<?php echo $fontwielkosc ?>"><?php echo $szukanie_gracz -> obrona; ?></font> Szybkość: <font style="<?php echo $fontwielkosc ?>"><?php echo $szukanie_gracz -> szybkosc; ?></font>
			</td>
		</tr>
	</table>
		<img style="display: block; width: 340px; margin: 0 auto;" src="images/1.png" /><br /><br />
<?php
		if ($user -> get['rank'] == 'Admin') echo '<center>IP (widoczne tylko dla adminów): '.$szukanie_gracz -> ip.'</center><br />';
    }
	else
	{
		echo '<br /><div class="komunikat komred">Nie ma takiego gracza!</div>';
		echo $szukanie_form;
	}
}
else echo '<br />'.$szukanie_form;
?>
    </div>
    <div class="postfooter"></div>
</div>

<?php
require_once('bottom.php');
?>