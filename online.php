<?php

require_once('head.php');
?>

<div class="post">
    <div class="postheader"><h1>Lista graczy Online</h1></div>
	<div class="postcontent">
	<table>
	<tr>
	<td style="width: 80%;"><p style="color:white;">Aktualnie Online:</p></td>
	<td style="width: 13%;"><p style="color:white;">Akcja</p></td>
	</tr>
	<?php
	$span = (time() - 400);
	$online = mysqli_query($GLOBALS['db'], "SELECT `login` FROM `konta` WHERE `online`>=".$span);
	if (mysqli_num_rows($online) > 0)
	{
		while ($gracze = mysqli_fetch_array($online))
		{
			echo '
			<tr>
			<td style="width: 80%;"><font style="margin-left: 20px; color: #F2F5A9;">'.$gracze['login'].'</font></td>
			<td style="width: 13%;"><a style="margin-left: 20px;" href="view.php?name='.$gracze['login'].'">Profil</a></td>
			</tr>';
		}
	}
	else echo '<div class="komunikat_s komwhite">Brak graczy online</div>!';
	?>
	</table>
    </div>
    <div class="postfooter"></div>
</div>	
	
<?php	
require_once('bottom.php');
?>