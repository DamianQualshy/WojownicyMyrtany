<?php
require_once('head.php');
?>

<div class="post">
    <div class="postheader"><h1>Ranking</h1></div>
	<div class="postcontent">
		<div class="postbg" style="background: url(images/tla_strony/ranking.jpg);"></div>
		<div class="postbreak"></div>
		<br />
		<div style="text-align: center;">
			<table style="margin: 0 auto;">
			<tr>
				<td height="35px;"><form method="get" action="view.php">Szukaj gracza:</td>
				<td height="35px;"><input class="formul" type="text" name="name" /></td>
			</tr>
			<tr>
				<td height="35px;"></td>
				<td height="35px;"><input class="gothbutton" type="submit" value="Szukaj" /></form></td>
			</tr>
			</table>
			<br /><br />
			<b>10 najlepszych graczy</b>
		</div>
		<table style="width: 600px; margin: 0 auto;">
			<tr>
				<td><p style="width: 5%; color:white;">LP</p></td>
				<td><p style="width: 45%; color:white;">NICK</p></td>
				<td><p style="width: 10%; color:white;">LVL</p></td>
				<td><p style="width: 10%; color:white;">SIŁA</p></td>
				<td><p style="width: 10%; color:white;">OBRONA</p></td>
				<td><p style="width: 10%; color:white;">ZRĘCZNOŚĆ</p></td>
				<td><p style="width: 10%; color:white;">PKT</p></td>
			</tr>
		<?php
		$users = mysqli_query($GLOBALS['db'], "SELECT `login`, `lvl`, `atak`, `obrona`, `szybkosc` FROM `konta` ORDER BY `atak`+`obrona`+`szybkosc`+`lvl` DESC LIMIT 10");
		$i = 1;		
		while ($ranking = mysqli_fetch_array($users))
		{
			$suma = $ranking['atak']+$ranking['obrona']+$ranking['szybkosc']+$ranking['lvl'];
			switch ($i)
			{
				case 1 : $color = '#CA9900'; break;
				case 2 : $color = '#b7b8b8'; break;		 
				case 3 : $color = '#694632;'; break;
				default : $color = 'white'; break; 
			}
			echo '<tr>
				  <td><p style="font-size: 26px; color:'.$color.';">'.$i++.'</p></td>
				  <td><a href="view.php?name='.$ranking['login'].'"><p style="color:'.$color.';">'.$ranking['login'].'</p></a></td> 
				  <td><p style="color:'.$color.';">'.$ranking['lvl'].'</p></td>
				  <td><p style="color:'.$color.';">'.$ranking['atak'].'</p></td>
				  <td><p style="color:'.$color.';">'.$ranking['obrona'].'</p></td>
				  <td><p style="color:'.$color.';">'.$ranking['szybkosc'].'</p></td>
				  <td><p style="color:'.$color.';">'.$suma.'</p></td>
				  </tr>';
		}
		?>
		</table>
    </div>
    <div class="postfooter"></div>
</div>	
	
<?php	
require_once('bottom.php');
?>