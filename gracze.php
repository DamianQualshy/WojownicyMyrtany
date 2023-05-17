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
	$gracze = mysqli_query($GLOBALS['db'], "SELECT `login` FROM `konta`");
	if (mysqli_num_rows($gracze) > 0)
	{
		while ($gracze2 = mysqli_fetch_array($gracze))
		{
			echo '
			<tr>
			<td style="width: 80%;"><font style="margin-left: 20px; color: #F2F5A9;">'.$gracze2['login'].'</font></td>
			<td style="width: 13%;"><a style="margin-left: 20px;" href="view.php?name='.$gracze2['login'].'">Profil</a></td>
			</tr>';
		}
	}
	else echo "Brak graczy!"
	?>
	</table>
    </div>
    <div class="postfooter"></div>
</div>	
	
<?php	
require_once('bottom.php');
?>