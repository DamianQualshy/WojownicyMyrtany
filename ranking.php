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
				<td height="35px;">
					<form method="get" action="view.php">Szukaj gracza: 
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
			</table>
			<br /><br />
			<b>100 najlepszych graczy</b>
		</div>
		<table style="margin: 0 auto;" width="600">
			<tr>
				<td><p style="width: 5%; color:white;">LP</p></td>
				<td><p style="width: 75%; color:white;">NICK</p></td>
				<td><p style="width: 10%; color:white;">LEVEL</p></td>
				<td><p style="width: 10%; color:white;">PKT</p></td>
			</tr>
		<?php
		mysqli_query($GLOBALS['db'], "UPDATE `konta` SET `suma`=(atak+obrona+szybkosc+lvl)");
		$users = mysqli_query($GLOBALS['db'], "SELECT `login`, `lvl`, `suma` FROM `konta` ORDER BY `suma` DESC LIMIT 100");
		$i = 1;		
		while ($ranking = mysqli_fetch_array($users))
		{
			switch ($i)
			{
				case 1 : $color = '#CA9900'; break;
				case 2 : $color = '#CAC4B1'; break;		 
				case 3 : $color = '#5A3A19'; break;
				default : $color = 'gray'; break; 
			}
			echo '<tr><td><p style="font-size: 27px; color:'.$color.';">'.$i++.'</p></td>
				  <td><a href="view.php?name='.$ranking['login'].'"><p style="font-size: 22px; color:'.$color.';">'.$ranking['login'].'</p></a></td> 
				  <td><p style="font-size: 22px; color:'.$color.';">'.$ranking['lvl'].'</p></td>
				  <td><p style="font-size: 22px; color:'.$color.';">'.$ranking['suma'].'</p></td></tr>';
						
		}
		?>
		</table>
    </div>
    <div class="postfooter"></div>
</div>	
	
<?php	
require_once('bottom.php');
?>