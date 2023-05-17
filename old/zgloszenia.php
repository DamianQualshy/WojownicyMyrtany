<?php
require_once('head.php');

require_once('includes/perm_mod.php');
?>

<div class="post">
	<div class="postheader"><h1><?php if (isset($_GET['archiwum'])) { echo 'Zgłoszenia <a style="color: #6b7272" href="zgloszenia.php">Przejdź do Zgłoszeń</a>';} else if (isset($_GET['zgloszenie'])) { echo '<a style="color: #6b7272" href="zgloszenia.php">Przejdź do Zgłoszeń</a> |'; echo ' <a style="color: #6b7272" href="zgloszenia.php?archiwum">Przejdź do Archiwum</a>';} else { echo 'Zgłoszenia <a style="color: #6b7272" href="zgloszenia.php?archiwum">Przejdź do Archiwum</a>';} ?></h1></div>
    <div class="postcontent">
<?php
if (!isset($_GET['zgloszenie']))
{
	if (!isset($_GET['archiwum']))
	{
		$a1 = mysqli_query($GLOBALS['db'], "SELECT * FROM `zgloszenia` WHERE `archiwum`=0 ORDER BY `id` ASC");
		echo '<br />';
		if (mysqli_num_rows($a1) > 0) 
		{
			echo '<table style="width:600px; margin: 0 auto; font-size: 18px;">
					  <tr>
						<td>ID</td>
						<td>Nick</td>
						<td>Temat</td>
						<td>Akcja</td>
					  </tr>';
			while ($zgloszenie = mysqli_fetch_array($a1))
			{
				$view = mysqli_fetch_object(mysqli_query($GLOBALS['db'], "SELECT `id` FROM `konta` WHERE `login`='".$zgloszenie['nick']."'"));
				if ($view == true)
				{
					$login_tlo = '';
				}
				else if($zgloszenie['przeczytane'] == 1)
				{
					$login_tlo = 'background: #5d2828;';
				}
				else $login_tlo = 'background: #6a1b1b;';
				
				if ($zgloszenie['przeczytane'] == 1) $przeczytane = '#424242';
				else $przeczytane = '#0B610B';
				
				echo '
					  <tr style="height: 40px; background: '.$przeczytane.'">
						<th style="width: 1px; padding-left: 5px; padding-right: 5px;">'.$zgloszenie['id'].'</th>
						<th style="'.$login_tlo.' width: 1px; padding-left: 10px; padding-right: 10px;">'.$zgloszenie['nick'].'</th>
						<th style="padding-left: 5px;">'.$zgloszenie['temat'].'</th>
						<th style="width: 140px; padding-left: 5px; padding-right: 5px;">
						<a style="color: #9f9fdb" href="zgloszenia.php?zgloszenie='.$zgloszenie['id'].'">Czytaj</a> <a style="color: #8181f8" href="zgloszenia.php?archiwum='.$zgloszenie['id'].'">Archiwum</a>
						<br />';
						if ($zgloszenie['przeczytane'] == 1) 
						{
							echo '<a style="color: #9f9fdb" href="zgloszenia.php?nieprzeczytane='.$zgloszenie['id'].'">Nieprzeczytane</a>';
						} else echo '<a style="color: #9f9fdb" href="zgloszenia.php?przeczytane='.$zgloszenie['id'].'">Przeczytane</a>';
						echo '
						</th>
					  </tr>';
			}
			echo '</table>';
		}
		else echo '<center>Brak zgłoszeń!</center>';
	}
}

if (isset($_GET['zgloszenie']))
{
	echo '<br />';
	if (preg_match("/^[0-9]*$/", $_GET['zgloszenie']) && !empty($_GET['zgloszenie']))
	{
		$check = mysqli_fetch_array(mysqli_query($GLOBALS['db'], 'SELECT * FROM `zgloszenia` WHERE `id`='.$_GET['zgloszenie']));
	    if ($check == true)
		{
			echo '<table>
			  <tr>
				<td>ID: '.$check['id'].'</td>
			  </tr>
			  <tr>
				<td>Nick: '.$check['nick'].'</td>
			  </tr>
			  <tr>
				<td>Email: '.$check['email'].'</td>
			  </tr>
			  <tr>
				<td>Temat: '.$check['temat'].'</td>
			  </tr>
			  <tr>
				<td>Treść: '.$check['tresc'].'</td>
			  </tr>
			</table>';
			mysqli_query($GLOBALS['db'], 'UPDATE `zgloszenia` SET `przeczytane`=1 WHERE `id`='.$check['id']);
			echo '<br /><br /><a style="color: #0B610B" href="zgloszenia.php?nieprzeczytane='.$check['id'].'">Oznacz jako nieprzeczytane</a><br />';
			if ($check['archiwum'] == 1)
			{
				echo '<a style="color: #6b7272" href="zgloszenia.php?niearchiwum='.$check['id'].'">Przenieś do Zgłoszeń</a><br />';
			} else echo '<a style="color: #6b7272" href="zgloszenia.php?archiwum='.$check['id'].'&arch">Przenieś do Archiwum</a><br />';
			echo '<a style="color: #DF0101" href="zgloszenia.php?usun='.$check['id'].'">Usuń</a><br />';
		}
	}
}

if (isset($_GET['usun']))
{
	if (preg_match("/^[0-9]*$/", $_GET['usun']) && !empty($_GET['usun']))
	{
		$checkq = mysqli_fetch_array(mysqli_query($GLOBALS['db'], 'SELECT * FROM `zgloszenia` WHERE `id`='.$_GET['usun']));
	    if ($checkq == true)
		{
			mysqli_query($GLOBALS['db'], 'DELETE FROM `zgloszenia` WHERE `id`='.$checkq['id']);
			if (isset($_GET['arch']))
			{
				echo "<script>setTimeout(function() {window.location='zgloszenia.php?archiwum'}, 0);</script>";
				echo '<noscript><meta http-equiv="refresh" content="0;url=zgloszenia.php?archiwum" /></noscript>';
			}
			else
			{
				echo "<script>setTimeout(function() {window.location='zgloszenia.php'}, 0);</script>";
				echo '<noscript><meta http-equiv="refresh" content="0;url=zgloszenia.php" /></noscript>';
			}
		}
	}
}

if (isset($_GET['nieprzeczytane']))
{
	if (preg_match("/^[0-9]*$/", $_GET['nieprzeczytane']) && !empty($_GET['nieprzeczytane']))
	{
		$checkw = mysqli_fetch_array(mysqli_query($GLOBALS['db'], 'SELECT * FROM `zgloszenia` WHERE `id`='.$_GET['nieprzeczytane']));
	    if ($checkw == true)
		{
			mysqli_query($GLOBALS['db'], 'UPDATE `zgloszenia` SET `przeczytane`=0 WHERE `id`='.$checkw['id']);
			if (isset($_GET['arch']))
			{
				echo "<script>setTimeout(function() {window.location='zgloszenia.php?archiwum'}, 0);</script>";
				echo '<noscript><meta http-equiv="refresh" content="0;url=zgloszenia.php?archiwum" /></noscript>';
			}
			else
			{
				echo "<script>setTimeout(function() {window.location='zgloszenia.php'}, 0);</script>";
				echo '<noscript><meta http-equiv="refresh" content="0;url=zgloszenia.php" /></noscript>';
			}
		}
	}
}

if (isset($_GET['przeczytane']))
{
	if (preg_match("/^[0-9]*$/", $_GET['przeczytane']) && !empty($_GET['przeczytane']))
	{
		$checkw = mysqli_fetch_array(mysqli_query($GLOBALS['db'], 'SELECT * FROM `zgloszenia` WHERE `id`='.$_GET['przeczytane']));
	    if ($checkw == true)
		{
			mysqli_query($GLOBALS['db'], 'UPDATE `zgloszenia` SET `przeczytane`=1 WHERE `id`='.$checkw['id']);
			if (isset($_GET['arch']))
			{
				echo "<script>setTimeout(function() {window.location='zgloszenia.php?archiwum'}, 0);</script>";
				echo '<noscript><meta http-equiv="refresh" content="0;url=zgloszenia.php?archiwum" /></noscript>';
			}
			else
			{
				echo "<script>setTimeout(function() {window.location='zgloszenia.php'}, 0);</script>";
				echo '<noscript><meta http-equiv="refresh" content="0;url=zgloszenia.php" /></noscript>';
			}
		}
	}
}

if (isset($_GET['niearchiwum']))
{
	if (preg_match("/^[0-9]*$/", $_GET['niearchiwum']) && !empty($_GET['niearchiwum']))
	{
		$checkw = mysqli_fetch_array(mysqli_query($GLOBALS['db'], 'SELECT * FROM `zgloszenia` WHERE `id`='.$_GET['niearchiwum']));
	    if ($checkw == true)
		{
			mysqli_query($GLOBALS['db'], 'UPDATE `zgloszenia` SET `archiwum`=0 WHERE `id`='.$checkw['id']);
			if (isset($_GET['arch']))
			{
				echo "<script>setTimeout(function() {window.location='zgloszenia.php?archiwum'}, 0);</script>";
				echo '<noscript><meta http-equiv="refresh" content="0;url=zgloszenia.php?archiwum" /></noscript>';
			}
			else
			{
				echo "<script>setTimeout(function() {window.location='zgloszenia.php'}, 0);</script>";
				echo '<noscript><meta http-equiv="refresh" content="0;url=zgloszenia.php" /></noscript>';
			}
		}
	}
}

if (isset($_GET['archiwum']))
{
	if (preg_match("/^[0-9]*$/", $_GET['archiwum']) && !empty($_GET['archiwum']))
	{
		$checkw = mysqli_fetch_array(mysqli_query($GLOBALS['db'], 'SELECT * FROM `zgloszenia` WHERE `id`='.$_GET['archiwum']));
	    if ($checkw == true)
		{
			mysqli_query($GLOBALS['db'], 'UPDATE `zgloszenia` SET `archiwum`=1 WHERE `id`='.$checkw['id']);
			if (isset($_GET['arch']))
			{
				echo "<script>setTimeout(function() {window.location='zgloszenia.php?archiwum'}, 0);</script>";
				echo '<noscript><meta http-equiv="refresh" content="0;url=zgloszenia.php?archiwum" /></noscript>';
			}
			else
			{
				echo "<script>setTimeout(function() {window.location='zgloszenia.php'}, 0);</script>";
				echo '<noscript><meta http-equiv="refresh" content="0;url=zgloszenia.php" /></noscript>';
			}
			
		}
	}
	else
	{
		$a1 = mysqli_query($GLOBALS['db'], "SELECT * FROM `zgloszenia` WHERE `archiwum`=1 ORDER BY `id` ASC");
		echo '<br />';
		if (mysqli_num_rows($a1) > 0) 
		{
			echo '<table style="width:600px; margin: 0 auto; font-size: 18px;">
					  <tr>
						<td>ID</td>
						<td>Nick</td>
						<td>Temat</td>
						<td>Akcja</td>
					  </tr>';
			while ($zgloszenie = mysqli_fetch_array($a1))
			{
				$view = mysqli_fetch_object(mysqli_query($GLOBALS['db'], "SELECT `id` FROM `konta` WHERE `login`='".$zgloszenie['nick']."'"));
				if ($view == true)
				{
					$login_tlo = '';
				}
				else if($zgloszenie['przeczytane'] == 1)
				{
					$login_tlo = 'background: #5d2828;';
				}
				else $login_tlo = 'background: #6a1b1b;';
				
				if ($zgloszenie['przeczytane'] == 1) $przeczytane = '#424242';
				else $przeczytane = '#0B610B';
				
				echo '
					  <tr style="height: 40px; background: '.$przeczytane.'">
						<th style="width: 1px; padding-left: 5px; padding-right: 5px;">'.$zgloszenie['id'].'</th>
						<th style="'.$login_tlo.' width: 1px; padding-left: 10px; padding-right: 10px;">'.$zgloszenie['nick'].'</th>
						<th style="padding-left: 5px;">'.$zgloszenie['temat'].'</th>
						<th style="width: 160px; padding-left: 5px;">
							<a style="color: #9f9fdb" href="zgloszenia.php?zgloszenie='.$zgloszenie['id'].'">Czytaj</a> <a style="color: #8181f8" href="zgloszenia.php?niearchiwum='.$zgloszenie['id'].'&arch">Zgłoszenia</a>
							<br />';
							if ($zgloszenie['przeczytane'] == 1) 
							{
								echo '<a style="color: #9f9fdb" href="zgloszenia.php?nieprzeczytane='.$zgloszenie['id'].'&arch">Nieprzeczytane</a>';
							} else echo '<a style="color: #9f9fdb" href="zgloszenia.php?przeczytane='.$zgloszenie['id'].'&arch">Przeczytane</a>';
							echo ' <a style="color: #8181f8" href="zgloszenia.php?usun='.$zgloszenie['id'].'&arch">Usuń</a>
						</th>
					  </tr>';
			}
			echo '</table>';
		}
		else echo '<center>Brak zgłoszeń!</center>';
	}
}

?>
    </div>
    <div class="postfooter"></div>
</div>

<?php
require_once('bottom.php');
?>