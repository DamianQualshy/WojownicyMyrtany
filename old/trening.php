<?php
require_once('head.php');
?>
<style>
.trening {
	border: none;
	background: none;
	font-family: Englebert;
	font-size: 20px;
}

.trening:hover {
    cursor: pointer;
    text-decoration:underline;
}
</style>

<div class="post">
	<div class="postheader"><h1>Trening</h1></div>
	<div class="postcontent">
	<div class="postbg" style="background: url(images/tla_strony/trening.jpg);"></div>
	<div class="postbreak"></div>
		<?php
		
		if (isset($_POST['trening']))
		{
			switch ($_POST['trening'])
			{
				case 1: $zmienna1 = 'Twoja zręczność wzrosła'; $zmienna2 = 'szybkosc'; $zmienna3 = 2; $zmienna4 = 1; break;
				case 11: $zmienna1 = 'Twoja zręczność wzrosła'; $zmienna2 = 'szybkosc'; $zmienna3 = 10; $zmienna4 = 5; break;
				case 111: $zmienna1 = 'Twoja zręczność wzrosła'; $zmienna2 = 'szybkosc'; $zmienna3 = 20; $zmienna4 = 10; break;

				case 2: $zmienna1 = 'Twój siła wzrósł'; $zmienna2 = 'atak'; $zmienna3 = 2; $zmienna4 = 1; break;
				case 22: $zmienna1 = 'Twój siła wzrósł'; $zmienna2 = 'atak'; $zmienna3 = 10; $zmienna4 = 5; break;
				case 222: $zmienna1 = 'Twój siła wzrósł'; $zmienna2 = 'atak'; $zmienna3 = 20; $zmienna4 = 10; break;

				case 3: $zmienna1 = 'Twoja obrona wzrosła'; $zmienna2 = 'obrona'; $zmienna3 = 2; $zmienna4 = 1; break;
				case 33: $zmienna1 = 'Twoja obrona wzrosła'; $zmienna2 = 'obrona'; $zmienna3 = 10; $zmienna4 = 5; break;
				case 333: $zmienna1 = 'Twoja obrona wzrosła'; $zmienna2 = 'obrona'; $zmienna3 = 20; $zmienna4 = 10; break;

				default: $zmienna1 = 'Twoja zręczność wzrosła'; $zmienna2 = 'szybkosc'; $zmienna3 = 0; $zmienna4 = 0; break;
			}
			if ($user -> get['pkt'] >= $zmienna4)
			{
				echo '<div class="komunikat komgreen">'.$zmienna1.' o <b>'.$zmienna3.'</b> za <b>'.$zmienna4.' PN</b>.</div>';
				mysqli_query($GLOBALS['db'], 'UPDATE `konta` SET `'.$zmienna2.'`=`'.$zmienna2.'`+'.$zmienna3.', `pkt`=`pkt`-'.$zmienna4.' WHERE `id`='.$user -> get['id']);
			}
			else echo '<div class="komunikat komred">Wróć, kiedy nabierzesz więcej doświadczenia.</div>';
		}

		echo '<div style="text-align: center;">Siła: '.$user -> get['atak'].' Obrona: '.$user -> get['obrona'].' Zręczność: '.$user -> get['szybkosc'].'</div><br />';
		
		for ($x = 1; $x <= 3; $x++)
		{
			if($x == 1)
			{
				$stat_1 = 'zręczność';
				$stat_2 = 'Zręczność';
			}
			else if($x == 2)
			{
				$stat_1 = 'siłę';
				$stat_2 = 'Siła';
			}
			else if($x == 3)
			{
				$stat_1 = 'obronę';
				$stat_2 = 'Obrona';
			}
			else 
			{
				$stat_1 = 'nieznane';
				$stat_2 = 'nieznane';
			}

			$ik = '<img draggable="false" style="margin: 15px auto auto auto; position: absolute; top: 0; left: 0; bottom: 0; right: 0; max-width: 120px; max-height: 120px;" src="images/ikonki/'.$x.'.png" />';  
			echo '<table style="margin: 0px auto;">
				  <tr>
					<th style="background: url(images/bck.png) no-repeat center 10px; background-size: 130px 130px; position: relative; width: 130px; height: 140px; padding-right: 30px;" rowspan="4">'.$ik.'</th>
					<th>Trenuj '.$stat_1.'</th>
				  </tr>
				  <tr>
					<td style="width: 215px;">
						<form action="trening.php" method="post">
							<input type="hidden" name="trening" value="'.$x.'">
							<input class="trening" style="color: #ffd700;" type="submit" value="+2 '.$stat_2.' | -1 PN"><br />
						</form>
					</td>
				  </tr>
				  <tr>
					<td style="width: 215px;">
						<form action="trening.php" method="post">
							<input type="hidden" name="trening" value="'.$x.''.$x.'">
							<input class="trening" style="color: #FFF7CF;" type="submit" value="+10 '.$stat_2.' | -5 PN"><br />
						</form>
					</td>
				  </tr>
				  <tr>
					<td style="width: 215px;">
						<form action="trening.php" method="post">
							<input type="hidden" name="trening" value="'.$x.''.$x.''.$x.'">
							<input class="trening" style="color: #ffd700;" type="submit" value="+20 '.$stat_2.' | -10 PN"><br />
						</form>
					</td>
				  </tr>
				</table><br />';
		} 
		?>
	</div>
	<div class="postfooter"></div>
</div>

<?php
include('bottom.php');
?>