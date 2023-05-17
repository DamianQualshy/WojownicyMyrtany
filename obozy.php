<?php
require_once('head.php');

if (isset($_GET['oboz']))
{
	if (isset($_GET['admin']))
	{
		if ($user -> get['skrot_frakcji'] == $_GET['oboz'])
		{
			$wiu2 = mysqli_fetch_object(mysqli_query($GLOBALS['db'], "SELECT `id` FROM `konta` WHERE `skrot_frakcji`='".$_GET['oboz']."' AND `oboz_ranga`=3"));
			$wiu3 = mysqli_fetch_object(mysqli_query($GLOBALS['db'], "SELECT `id` FROM `konta` WHERE `skrot_frakcji`='".$_GET['oboz']."' AND `oboz_ranga`=2"));
			
			if ($wiu2 == true)
			{
				header('Location: obozy.php?oboz='.$_GET['oboz'].''); 
			}
			else
			{
				if ($wiu3 == true)
				{
					if ($user -> get['oboz_ranga'] == '2')
					{
						mysqli_query($GLOBALS['db'], "UPDATE `konta` SET `oboz_ranga`=3 WHERE `skrot_frakcji`='".$_GET['oboz']."' AND `id`='".$user -> get['id']."'");
						header('Location: obozy.php?oboz='.$_GET['oboz'].''); 
					}
					else
					{
						header('Location: obozy.php?oboz='.$_GET['oboz'].''); 
					}
				}
				else
				{
					mysqli_query($GLOBALS['db'], "UPDATE `konta` SET `oboz_ranga`=3 WHERE `skrot_frakcji`='".$_GET['oboz']."' AND `id`='".$user -> get['id']."'");
					header('Location: obozy.php?oboz='.$_GET['oboz'].''); 
				}
			}
		}
		header('Location: obozy.php?oboz='.$_GET['oboz'].'');
	}
}


if (isset($_GET['oboz']) or isset($_GET['opcje']))
{
	$obozy = '';
} else $obozy = 'Obozy';

if (isset($_GET['opcje']))
{
	$view = mysqli_fetch_object(mysqli_query($GLOBALS['db'], "SELECT * FROM `frakcje` WHERE `skrot_frakcji`='".$_GET['opcje']."'"));	
	if ($view == true)
	{
		if (isset($_GET['dodaj_tlo']))
		{
			$max_rozmiar = 3000000;
			if (is_uploaded_file($_FILES['plik']['tmp_name']))
			{
				if ($_FILES['plik']['size'] > $max_rozmiar) {
					$komunikat_tlo = '<span class="komunikat" style="color:red;">Błąd! Plik jest za duży!</span>';
				} else {
					$komunikat_tlo = '<span class="komunikat" style="color:green;">Plik został odebrany pomyślnie!</span>';
					move_uploaded_file($_FILES['plik']['tmp_name'], dirname(__FILE__).'/images/tla_obozow/'.$user -> get['skrot_frakcji'].'.png');
				}
			}
			else $komunikat_tlo = '<span class="komunikat" style="color:red;">Błąd przy przesyłaniu danych!</span>';
		}

		if (isset($_GET['usun_tlo']))
		{
			$file_name = dirname(__FILE__).'/images/tla_obozow/'.$user -> get['skrot_frakcji'].'.png';
			if (file_exists($file_name)) {
				$nazwa_folderu = dirname(__FILE__)."/images/tla_obozow/";
				if($file_name!='.' or $file_name!='..')
				{
				  unlink($file_name);
				  $komunikat_tlo = '<span class="komunikat" style="color:green;">Pomyślnie usunięto tło.</span>';
				}
				else $komunikat_tlo = '<span class="komunikat" style="color:red;">Brak tła!</span>';
			}
			else $komunikat_tlo = '<span class="komunikat" style="color:red;">Brak tła!</span>';
		}
	}
}

?>

<div class="post">
    <div class="postheader"><h1><?php echo $obozy; ?></h1></div>
	<div class="postcontent">
<?php
$frakcje_tlo = '<div class="postbg" style="background: url(images/tla_strony/frakcje.jpg);"></div>';

if (isset($_GET['oboz']))
{
	$view = mysqli_fetch_object(mysqli_query($GLOBALS['db'], "SELECT * FROM `frakcje` WHERE `skrot_frakcji`='".$_GET['oboz']."'"));	
	if ($view == true)
	{
		$file_name = dirname(__FILE__).'/images/tla_obozow/'.$view -> skrot_frakcji.'.png';
		if (file_exists($file_name))
		{
			$av2 = '/images/tla_obozow/'.$view -> skrot_frakcji.'.png';
			$frakcje_tlo = '<div class="postbg" style="background: url('.$av2.'); background-size: 620px 280px;"></div>';
		}
	}
}

if (isset($_GET['opcje']))
{
	$view = mysqli_fetch_object(mysqli_query($GLOBALS['db'], "SELECT * FROM `frakcje` WHERE `skrot_frakcji`='".$_GET['opcje']."'"));	
	if ($view == true)
	{
		if($user -> get['skrot_frakcji'] == $_GET['opcje'])
		{
			$file_name = dirname(__FILE__).'/images/tla_obozow/'.$view -> skrot_frakcji.'.png';
			if (file_exists($file_name))
			{
				$av2 = '/images/tla_obozow/'.$view -> skrot_frakcji.'.png';
				$frakcje_tlo = '<div class="postbg" style="background: url('.$av2.'); background-size: 620px 280px;"></div>';
			}
			else $frakcje_tlo = '<div class="postbg" style="background: url(images/tla_obozow/frakcje_brak.jpg);"></div>';
		}
	}
}

echo $frakcje_tlo;
?>
	<div class="postbreak"></div>
	<?php
$brak_geta = 1;

	if (isset($_GET['opcje']))
	{
		$view = mysqli_fetch_object(mysqli_query($GLOBALS['db'], "SELECT * FROM `frakcje` WHERE `skrot_frakcji`='".$_GET['opcje']."'"));	
		if ($view == true)
		{
			if($user -> get['skrot_frakcji'] == $_GET['opcje'])
			{
				if($user -> get['oboz_ranga'] == 3 or $user -> get['oboz_ranga'] == 2)
				{
					if (isset($_GET['usun']))
					{
						if($user -> get['oboz_ranga'] == 3)
						{
							if (isset($_GET['usun']) && $_GET['usun'] == 'tak')
							{
								function filtruj($zmienna)
								{
									if(get_magic_quotes_gpc())
										$zmienna = stripslashes($zmienna); // usuwamy slashe
								 
								   // usuwamy spacje, tagi html oraz niebezpieczne znaki
									return mysqli_real_escape_string($GLOBALS['db'], htmlspecialchars(trim($zmienna)));
								}
								
								$check = mysqli_fetch_array(mysqli_query($GLOBALS['db'], "SELECT haslo FROM konta WHERE id='".$user -> get['id']."';"));
								$haslo = password_verify(filtruj($_POST['haslo']), $check['haslo']);
								
								if ($user -> get['haslo'] == htmlspecialchars($check['haslo']))
								{
									echo 'Obóz został usunięty. Za 5 sekund zostaniesz przekierowany na stronę Obozów. Możesz także nacisnąć <a style="font-size: 20px; color: white" href="obozy.php">TUTAJ</a>.';
									mysqli_query($GLOBALS['db'], "UPDATE `konta` SET `skrot_frakcji`='', `frakcja`='', `oboz_ranga`=1 WHERE `skrot_frakcji`='".$_GET['opcje']."'");
									mysqli_query($GLOBALS['db'], "DELETE FROM `frakcje` WHERE `skrot_frakcji`='".$_GET['opcje']."'");
									$file_name = dirname(__FILE__).'/images/tla_obozow/'.$_GET['opcje'].'.png';
									if (file_exists($file_name)) {
										$nazwa_folderu = dirname(__FILE__)."/images/tla_obozow/";
										if($file_name!='.' or $file_name!='..')
										{
										  unlink($file_name);
										}
									}
									header("Refresh: 5; URL=obozy.php");
								}
								else
								{
									echo '<center><font style="color: red">Wpisano złe hasło! Spróbuj ponownie.</font></center>';
									echo '
									<form action="obozy.php?opcje='.$_GET['opcje'].'&usun=tak" name="logowanie" method="post" style="margin-left: -20px;">
									<center>
									<p style="font-family: Metamorphous;">Twoje hasło: <input class="formul" style="width: 174px;margin-top: 5px;" type="password" name="haslo2"></p>
									<p><input class="gothbutton" type="submit" value="Usuń konto"><br></p>
									</form>';
								}
							}
							else
							{
								echo '<center><font style="color: red">Na pewno chcesz usunąć? konto? Wpisz swoje hasło dla potwierdzenia.</font></center>';
								echo '
								<form action="obozy.php?opcje='.$_GET['opcje'].'&usun=tak" name="logowanie" method="post" style="margin-left: -20px;">
								<center>
								<p style="font-family: Metamorphous;">Twoje hasło: <input class="formul" style="width: 174px;margin-top: 5px;" type="password" name="haslo2"></p>
								<p><input class="gothbutton" type="submit" value="Usuń konto"><br></p>
								</form>';
							}
						}
						else echo '<span style="color:red;">Nie masz uprawnień!</span>';
					}
					else
					{
						if (isset($_GET['dodaj']))
						{
							if (!empty($_POST['czlonek']))
							{
								$oboz = mysqli_fetch_object(mysqli_query($GLOBALS['db'], "SELECT `id`,`frakcja`,`skrot_frakcji` FROM `konta` WHERE `login`='".$_POST['czlonek']."'"));	
								if ($oboz == true)
								{
									if (empty($oboz -> frakcja) && empty($oboz -> skrot_frakcji))
									{
										mysqli_query($GLOBALS['db'], 'UPDATE `konta` SET `frakcja`="'.$user -> get['frakcja'].'", `skrot_frakcji`="'.$user -> get['skrot_frakcji'].'", `oboz_ranga`="1" WHERE `id`='.$oboz -> id) or die(mysqli_error());
										echo '<span class="komunikat" style="color:green;">Dodano gracza do frakcji</span><br /><br />';
									}
									else if ($oboz -> skrot_frakcji == $user -> get['skrot_frakcji'])
									{
										echo '<span class="komunikat" style="color:red;">Gracz już należy do tej frakcji!</span><br /><br />';
									}
									else echo '<span class="komunikat" style="color:red;">Gracz już należy do innej frakcji!</span><br /><br />';
								}
								else echo '<span class="komunikat" style="color:red;">Nie ma takiego gracza!</span><br /><br />';
							}
							else echo '<span class="komunikat" style="color:red;">Nie podano loginu gracza!</span><br /><br />';	 
							$brak_geta = 0;
						}

						echo '<form method="post" action="obozy.php?opcje='.$user -> get['skrot_frakcji'].'&dodaj">
							  <table style="margin: 0 auto;">
							  <tr>
								<td style="height: 35px;">Dodaj członka: </td>
								<td style="height: 35px;"><input class="formul" type="text" name="czlonek"></td>
							  </tr>
							  <tr>
								<td style="height: 35px;"></td>
								<td style="height: 35px;"><input class="gothbutton" type="submit" name="dodaj" value="Dodaj"></td>
							  </tr>
							  </table>
							  </form><br />';

						if (isset($komunikat_tlo)) {echo $komunikat_tlo;}
						
						echo '<table style="margin: 0 auto;">
						<tr>
							<td>
								<form action="obozy.php?opcje='.$user -> get['skrot_frakcji'].'&dodaj_tlo" method="POST" ENCTYPE="multipart/form-data">
								<p style="font-family: Metamorphous; margin-left: -12px;"><b>Max. rozmiar tła: 3MB<br />Zalecane wymiary tła: 620 x 280 px.</b></p>
								<input style="font-family: Metamorphous; color: white; margin-left: 8px; margin-bottom: 6px;" type="file" name="plik"/>
								<table><tr><td><input class="gothbutton" style="margin-left: 8px; margin-bottom: 6px;" type="submit" value="Wyślij plik"/></td>
								</form>';
								$file_name = 'images/tla_obozow/'.$user -> get['skrot_frakcji'].'.png';
								if (file_exists($file_name))
								{
									echo '<td><form action="obozy.php?opcje='.$user -> get['skrot_frakcji'].'&usun_tlo" method="POST" ENCTYPE="multipart/form-data">';
									echo '<input class="gothbutton" style="margin-top: -5px; margin-left: 8px;" type="submit" value="Usuń tło"/>';
									echo '</form></td>';
								}
								echo '</tr></table>
							</td>
						</tr>
						</table>';
						
						$brak_perm = '';
					}
				}
				else $brak_perm = '<span style="color:red;">Nie masz uprawnień!</span>';
				
				if($user -> get['oboz_ranga'] == 3)
				{
					if (isset($_GET['usun']))
					{
					}
					else
					{
						echo '<table style="margin: 0 auto -30px;">
							  <tr>
								<th>
									<form action="obozy.php?opcje='.$_GET['opcje'].'&usun" method="post" style="margin-left: 0px;">
									<p><input class="gothbutton" type="submit" value="Usuń obóz"></p>
									</form>
								</th>
							  </tr>
							</table>';
						$brak_perm = '';
					}
				}
				else if($user -> get['oboz_ranga'] == 2)
				{
					$brak_perm = '';
				}
				else $brak_perm = '<span style="color:red;">Nie masz uprawnień!</span>';
				
				echo $brak_perm;
			}
			else echo '<span style="color:red;">Nie masz uprawnień!</span>';
		}
		else echo '<span style="color:red;">Nie ma takiej frakcji!</span>';
		$brak_geta = 0;
	}

if (isset($_GET['oboz']))
{	
    if ($view == true)
    {

		if ($user -> get['oboz_ranga'] == '3')
		{
			$title = '<font style="color: gold">Admin</font> ';
		}
		else if ($user -> get['oboz_ranga'] == '2')
		{
			$title = '<font style="color: red">Moderator</font> ';
		}
		else if ($user -> get['oboz_ranga'] == '1')
		{
			$title = '';
		}
		else $title = 'lol_co_on_tu_robi ';
		
		if ($user -> get['skrot_frakcji'] == $_GET['oboz'])
		{
			$wiu2 = mysqli_fetch_object(mysqli_query($GLOBALS['db'], "SELECT `id` FROM `konta` WHERE `skrot_frakcji`='".$_GET['oboz']."' AND `oboz_ranga`=3"));
			$wiu3 = mysqli_fetch_object(mysqli_query($GLOBALS['db'], "SELECT `id` FROM `konta` WHERE `skrot_frakcji`='".$_GET['oboz']."' AND `oboz_ranga`=2"));
			
			if ($wiu2 == true)
			{
			}
			else
			{
				if ($wiu3 == true)
				{
					if ($user -> get['oboz_ranga'] == '2')
					{
						echo '<div style="text-align: center; color: red;">Nie ma administratorów w obozie! <a style="font-size: 20px; color: red" href="obozy.php?oboz='.$_GET['oboz'].'&admin">Zostań administratorem obozu teraz!</a></div>';
					}
				}
				else
				{
					echo '<div style="text-align: center; color:red;">Nie ma moderatorów ani administratorów w obozie! <a style="font-size: 20px; color: red" href="obozy.php?oboz='.$_GET['oboz'].'&admin">Zostań administratorem obozu teraz!</a></div>';
				}
			}
		}

		echo '<br />';
		echo '<div style="margin-left: 25px;">';
		echo 'Nazwa Obozu: '.$view -> nazwa_frakcji.'<br />';
		echo 'Skrót Obozu: '.$view -> skrot_frakcji.'<br />';
		
		if ($user -> get['skrot_frakcji'] == $_GET['oboz'])
		{
			echo 'ID Obozu: '.$view -> id.'<br />';
			echo 'Twoja ranga: '.$title.'<br />';
			if($user -> get['oboz_ranga'] == 3 or $user -> get['oboz_ranga'] == 2) {echo '<a style="font-size: 20px; color: gold" href="obozy.php?opcje='.$view -> skrot_frakcji.'">OPCJE</a><br />';}
		}
		
		echo '<br />Lista członków:<br />';
		$wobozie = mysqli_query($GLOBALS['db'], "SELECT `login`,`oboz_ranga` FROM `konta` WHERE `skrot_frakcji`='".$view -> skrot_frakcji."' ORDER BY oboz_ranga DESC");
		if (mysqli_num_rows($wobozie) > 0)
		{
			while ($lista = mysqli_fetch_array($wobozie))
			{
				if ($lista['oboz_ranga'] == '3')
				{
					$title = '<font style="color: gold">[Admin]</font> ';
				}
				else if ($lista['oboz_ranga'] == '2')
				{
					$title = '<font style="color: red">[Moderator]</font> ';
				}
				else if ($lista['oboz_ranga'] == '1')
				{
					$title = '';
				}
				else $title = '[lol_co_on_tu_robi] ';
				
				echo $title.''.$lista['login'].'</font><br />';
			}
		}
		else echo "Brak graczy!";
		echo '</div>';
		
	}
	else echo '<span style="color:red;">Nie ma takiej frakcji!</span>';
	$brak_geta = 0;
}

if (isset($_GET['akcja']) && $_GET['akcja'] == 'utworz')
{
		    if (!empty($_POST['name']))
			{
				$nazwa = ''.htmlspecialchars($_POST['name']).'';
				$krotka_nazwa = ''.htmlspecialchars($_POST['short_name']).'';
				$check = mysqli_fetch_array(mysqli_query($GLOBALS['db'], "SELECT `nazwa_frakcji` FROM `frakcje` WHERE `nazwa_frakcji`='".$nazwa."'"));
				$short_check = mysqli_fetch_array(mysqli_query($GLOBALS['db'], "SELECT `skrot_frakcji` FROM `frakcje` WHERE `skrot_frakcji`='".$krotka_nazwa."'"));
				$next = 1;

				if (isset($check['nazwa_frakcji']) && !empty($nazwa)) 
				{
					echo '<p><span style="color:red;">Istnieje już obóz o takiej nazwie</span></p>';
					$next = null;
				}
				if (!preg_match("/^[a-zA-Z]*$/", $short_check['skrot_frakcji']))
				{
					echo '<p><span style="color:red;">Dozwolone są tylko znaki od A do Z (małe oraz duże)</span></p>';
					$next = null;
				}
				if (isset($short_check['skrot_frakcji']) && !empty($krotka_nazwa))
				{
					echo '<p><span style="color:red;">Istnieje już obóz z takim skrótem</span></p>';
					$next = null;
				}
				if($next != null)
				{
					mysqli_query($GLOBALS['db'], "INSERT INTO `frakcje` (`nazwa_frakcji`, `skrot_frakcji`) VALUES ('".$nazwa."', '".$krotka_nazwa."')") or die(mysqli_error());
					mysqli_query($GLOBALS['db'], 'UPDATE `konta` SET `frakcja`="'.$nazwa.'", `skrot_frakcji`="'.$krotka_nazwa.'", `oboz_ranga`="3" WHERE `id`='.$user -> get['id']) or die(mysqli_error());
					echo '<span style="color:green;">Dodano frakcję</span>';
					echo '<br><span><a href="obozy.php">Cofnij</a></span>';
				}
				else echo '<br><span><a href="obozy.php">Cofnij</a></span>';


			}
			else echo '<span style="color:red;">Wypełnij wszystkie pola!</span>';
			$brak_geta = 0;
}

if ($brak_geta == 1)
{

	if (empty($user -> get['frakcja']))
	{
		$height = '35px';
		echo '<form method="post" action="obozy.php?akcja=utworz">
			  <table style="margin: 0 auto;">
			  <tr>
				  <td style="height: '.$height.';">Załóż własną frakcję:</td>
				  <td style="height: '.$height.';"></td>
			  </tr>
			  <tr>
				  <td style="height: '.$height.';">Nazwa</td>
				  <td style="height: '.$height.';"><input class="formul" type="text" name="name"></td></tr>
			  <tr>
				  <td style="height: '.$height.';">Skrót (5 znaków)</td>
				  <td style="height: '.$height.';"><input class="formul" maxlength="5" type="text" name="short_name"></td>
			  </tr>
			  <tr>
				  <td style="height: '.$height.';"></td>
				  <td style="height: '.$height.';"><input class="gothbutton" type="submit" name="utworz" value="Dodaj"></td>
			  </tr>
			  </table></form>';	
	}

	if (!empty($user -> get['frakcja']))
	{
		if ($user -> get['oboz_ranga'] == '3')
		{
			$title = '<font style="color: gold">Admin</font>';
		}
		else if ($user -> get['oboz_ranga'] == '2')
		{
			$title = '<font style="color: red">Moderator</font>';
		}
		else if ($user -> get['oboz_ranga'] == '1')
		{
			$title = '';
		}
		else $title = 'lol_co_on_tu_robi';
			
		echo '<br />';
		echo '<div style="margin-left: 25px;">';
		echo 'Należysz do Obozu '.$user -> get['frakcja'].'<br />';
		echo 'Twoja ranga: '.$title.'<br />';
		if($user -> get['oboz_ranga'] == 3 or $user -> get['oboz_ranga'] == 2) {echo '<a style="margin-right: 10px; font-size: 20px; color: gold" href="obozy.php?opcje='.$user -> get['skrot_frakcji'].'">OPCJE</a>';}
		if($user -> get['oboz_ranga'] == 3 or $user -> get['oboz_ranga'] == 2) {echo '<a style="font-size: 20px; color: #c18c11" href="obozy.php?oboz='.$user -> get['skrot_frakcji'].'">ODWIEDŹ</a>';}
		echo '<br /><br />';
		echo '</div>';
	}

	echo '<br />
	<table style="margin: 0 auto;" width="600">
		<tr>
			<td><p style="width: 10%; color:white;">ID</p></td>
			<td><p style="width: 70%; color:white;">OBÓZ</p></td>
			<td><p style="width: 10%; color:white;">SKRÓT</p></td>
			<td><p style="width: 10%; color:white;">AKCJA</p></td>
		</tr>';
	$obozy = mysqli_query($GLOBALS['db'], "SELECT * FROM `frakcje` ORDER BY `id` ASC");
	while ($lista = mysqli_fetch_array($obozy))
	{
		if($lista['skrot_frakcji'] == $user -> get['skrot_frakcji'])
		{
			$color = "gold; font-style: italic;";
		} else $color = "white;";
		echo '<tr><td><p style="font-size: 27px; color:'.$color.'">'.$lista['id'].'</p></td>
			  <td><p style="font-size: 22px; color:'.$color.'">'.$lista['nazwa_frakcji'].'</p></td> 
	          <td><p style="font-size: 22px; color:'.$color.'">'.$lista['skrot_frakcji'].'</p></td>
			  <td><p style="font-size: 22px; color:'.$color.'"><a href="obozy.php?oboz='.$lista['skrot_frakcji'].'">Odwiedź</a></p></td></tr>';
					
    }
	echo '</table>';
}
?>
	</div>
	<div class="postfooter"></div>
</div>
<?php
require_once('bottom.php');
?>	 