<?php
require_once('head.php');

if (isset($_GET['name']))
{
	$header = $_GET['name'];
}
else $header = 'Szukaj gracza';

?>

<div class="post" style="font-size: 20px;">
    <div class="postheader"><h1><?php echo $header ?></h1></div>
	<div class="postcontent">
<?php
$fontwielkosc = 'font-size: 32px; color: #55a;';
$fontwielkosc1 = 'font-size: 32px;';
$wielkosc = '140px';
$wielkosc_tla = '160px';
?>
<?php
if (isset($_GET['name']))
{
    $view = mysqli_fetch_object(mysqli_query($GLOBALS['db'], "SELECT * FROM `konta` WHERE `login`='".$_GET['name']."'"));	
    $view2 = mysqli_query($GLOBALS['db'], "SELECT * FROM `konta` WHERE `login`='".$_GET['name']."'");	
    if ($view == true)
    {
?>
		 <center>
			<p style="font-size: 26px; margin-left: 20px; margin-top: -140px; color: #000000;">
			<br /><br /><br /><br />
			<div>
			<table>
			  <tr>
				<th>
				<?php
					$file_name = 'images/av_graczy/'.$view -> login.'_av.png';
					if ($view -> awatar_domyslny == 4)
					{
						if (file_exists($file_name))
						{
							echo '
							<div style="background: url(images/bck.png) no-repeat center center; background-size: '.$wielkosc_tla.' '.$wielkosc_tla.'; position: relative; width:'.$wielkosc.'; height:'.$wielkosc.';" >
							<img style="margin: auto; position: absolute; top: 0; left: 0; bottom: 0; right: 0;max-width: '.$wielkosc.'; max-height: '.$wielkosc.';" src="'.$file_name.'" />
							</div>
							<img draggable="false" style="position: relative; margin-top: -'.$wielkosc.'; max-width: '.$wielkosc.'; max-height: '.$wielkosc.';" src="images/awatary/ramka.png" />';
						}
						else
						{
						echo '<img height="'.$wielkosc.'" src="images/awatary/DefAV.png" alt="member" />';
						mysqli_query($GLOBALS['db'], "UPDATE `konta` SET `awatar_domyslny`=0 WHERE `id`=".$view -> id);	
						} 
					}
					else if ($view -> awatar_domyslny == 3)
					{
						echo '<img height="'.$wielkosc.'" src="images/awatary/nowicjusz.png" alt="member" />';
					}
					else if ($view -> awatar_domyslny == 2)
					{
						echo '<img height="'.$wielkosc.'" src="images/awatary/szkodnik.png" alt="member" />';
					}
					else if ($view -> awatar_domyslny == 1)
					{
						echo '<img height="'.$wielkosc.'" src="images/awatary/cien.png" alt="member" />';
					}
					else if ($view -> awatar_domyslny == 0)
					{
						echo '<img height="'.$wielkosc.'" src="images/awatary/DefAV.png" alt="member" />';
					}
			?>
				</th>
				<th style="padding-left: 10px; text-align:left; vertical-align:top;">
			<span><font style="<?php echo $fontwielkosc1 ?>"><?php echo $view -> login; ?></font></span> <br />
			<span><font style="<?php echo $fontwielkosc1 ?>"><?php include('includes/ranga.php'); ?></font></span> <br />
			<span>Poziom: <font style="<?php echo $fontwielkosc ?>"><?php echo $view -> lvl; ?></font></span><br />
			<span>Pochodzenie: <font style="<?php echo $fontwielkosc ?>"><?php echo $view -> pochodzenie; ?></font></span>
				</th>
			  </tr>
			</table>
			</div>
			<br /><img width="340px" src="images/1.png" /><br /><br />
			Atak: <font style="<?php echo $fontwielkosc ?>"><?php echo $view -> atak; ?></font><br>
			Obrona: <font style="<?php echo $fontwielkosc ?>"><?php echo $view -> obrona; ?></font><br>
			Szybkość: <font style="<?php echo $fontwielkosc ?>"><?php echo $view -> szybkosc; ?></font>
			</p>
		 </center>
<?php
	    if ($user -> get['rank'] == 'Admin')
		echo '<center>IP (widoczne tylko dla adminów): '.$view -> ip.'</center><br />';
    }
	else echo '<br />
	<div class="komunikat" style="text-align: center;color:red;margin-top: -20px;margin-bottom: -10px;">Nie ma takiego gracza!</div>
	<br />
	<table style="margin: 0 auto;">
			<tr>
				<td height="35px;">
					<form method="get" action="">Szukaj gracza: 
				</td>
				<td height="35px;">
					<input class="formul" type="text" name="name"> 
				</td>
			<tr>
			<tr>
				<td height="35px;">
				</td>
				<td height="35px;">
					<input class="gothbutton" type="submit" value="Szukaj"></form>
				</td>
			<tr>
			</table>';
}
    else
{
    echo '<br /> 
			<table style="margin: 0 auto;">
			<tr>
				<td height="35px;">
					<form method="get" action="">Szukaj gracza: 
				</td>
				<td height="35px;">
					<input class="formul" type="text" name="name"> 
				</td>
			<tr>
			<tr>
				<td height="35px;">
				</td>
				<td height="35px;">
					<input class="gothbutton" type="submit" value="Szukaj"></form>
				</td>
			<tr>
			</table>';
}
?>
    </div>
    <div class="postfooter"></div>
</div>

<?php
require_once('bottom.php');
?>