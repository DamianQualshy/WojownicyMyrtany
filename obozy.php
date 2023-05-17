<?php
require_once('head.php');

if($user -> get['lvl'] < 5)
{
	header('Location: postac.php');
	exit;
}

$id_obozow = mysqli_query($GLOBALS['db'], "SELECT `id` FROM `frakcje`");

while ($obozy_id = mysqli_fetch_array($id_obozow))
{
	if ($user -> get['oboz_id'] == $obozy_id['id'])
	{
		$obozy_id_true = true;
		break;
	}
	else $obozy_id_true = false;
}

/* $id_gracze = mysqli_query($GLOBALS['db'], "SELECT `id`,`oboz_id` FROM `konta`");
while ($czyszczenie_zlych_id = mysqli_fetch_array($id_gracze))
{
	$czyszczenie_zlych_id2 = mysqli_fetch_object(mysqli_query($GLOBALS['db'], "SELECT `id` FROM `frakcje` WHERE `id`=".$czyszczenie_zlych_id['oboz_id']));
	if ($czyszczenie_zlych_id2 == false)
	{
		mysqli_query($GLOBALS['db'], "UPDATE `konta` SET `oboz_id`=0, `oboz_ranga`=1 WHERE `id`=".$czyszczenie_zlych_id['id']);
	}
} */

$oboz = mysqli_fetch_array(mysqli_query($GLOBALS['db'], "SELECT * FROM `frakcje` WHERE `id`='".$user -> get['oboz_id']."'"));

if (isset($_GET['oboz']))
{
	$oboz_id = mysqli_fetch_array(mysqli_query($GLOBALS['db'], "SELECT `id` FROM `frakcje` WHERE `skrot_frakcji`='".$_GET['oboz']."'"));
}

if (isset($_GET['opcje']))
{
	$oboz_id = mysqli_fetch_array(mysqli_query($GLOBALS['db'], "SELECT `id` FROM `frakcje` WHERE `skrot_frakcji`='".$_GET['opcje']."'"));
}

if (isset($_GET['utworz']))
{
	$oboz_id = mysqli_fetch_array(mysqli_query($GLOBALS['db'], "SELECT `id` FROM `frakcje` WHERE `skrot_frakcji`='".$_POST['short_name']."'"));
}

$strona_glowna = 1; // Określenie czy aktualna strona to strona główna

// -------------------------------------------------------- SPRAWDZANIE RANGI - OPCJE OBOZU
	if (isset($_GET['oboz']))
	{
		if (isset($_GET['admin']))
		{
			if ($oboz['skrot_frakcji'] == $_GET['oboz'])
			{
				$wiu2 = mysqli_fetch_object(mysqli_query($GLOBALS['db'], "SELECT `id` FROM `konta` WHERE `oboz_id`=".$oboz_id['id']." AND `oboz_ranga`=3"));
				$wiu3 = mysqli_fetch_object(mysqli_query($GLOBALS['db'], "SELECT `id` FROM `konta` WHERE `oboz_id`=".$oboz_id['id']." AND `oboz_ranga`=2"));
				
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
							mysqli_query($GLOBALS['db'], "UPDATE `konta` SET `oboz_ranga`=3 WHERE `oboz_id`=".$oboz_id['id']." AND `id`='".$user -> get['id']."'");
							header('Location: obozy.php?oboz='.$_GET['oboz'].''); 
						}
						else
						{
							header('Location: obozy.php?oboz='.$_GET['oboz'].''); 
						}
					}
					else
					{
						mysqli_query($GLOBALS['db'], "UPDATE `konta` SET `oboz_ranga`=3 WHERE `oboz_id`=".$oboz_id['id']." AND `id`='".$user -> get['id']."'");
						header('Location: obozy.php?oboz='.$_GET['oboz'].''); 
					}
				}
			}
			else
			{
				$wiu4 = mysqli_fetch_object(mysqli_query($GLOBALS['db'], "SELECT `id` FROM `konta` WHERE `oboz_id`=".$oboz_id['id']));
				if ($wiu4 == false)
				{
					mysqli_query($GLOBALS['db'], "UPDATE `konta` SET `oboz_ranga`=3, `oboz_id`=".$oboz_id['id']." WHERE `id`='".$user -> get['id']."'");
					header('Location: obozy.php?oboz='.$_GET['oboz'].''); 
				}
			}
			header('Location: obozy.php?oboz='.$_GET['oboz'].'');
		}
	}
// --------------------------------------------------------


// -------------------------------------------------------- WYSYŁANIE WŁASNEGO TŁA NA STRONĘ
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
						$komunikat_tlo = '<div class="komunikat komred">Błąd! Plik jest za duży!</div>';
					} else {
						move_uploaded_file($_FILES['plik']['tmp_name'], dirname(__FILE__).'/images/tla_obozow/'.$oboz['skrot_frakcji'].'.png');
						$komunikat_tlo = '<div class="komunikat komgreen">Plik został odebrany pomyślnie!</div>';
					}
				}
				else $komunikat_tlo = '<div class="komunikat komred">Błąd przy przesyłaniu danych!</div>';
			}

			if (isset($_GET['usun_tlo']))
			{
				$file_name = dirname(__FILE__).'/images/tla_obozow/'.$oboz['skrot_frakcji'].'.png';
				if (file_exists($file_name)) {
					if($file_name!='.' or $file_name!='..')
					{
					  unlink($file_name);
					  $komunikat_tlo = '<div class="komunikat komgreen">Pomyślnie usunięto tło.</div>';
					}
					else $komunikat_tlo = '<div class="komunikat komred">Brak tła!</div>';
				}
				else $komunikat_tlo = '<div class="komunikat komred">Brak tła!</div>';
			}
		}
		else $komunikat_tlo = '<div class="komunikat komred">Wystąpił błąd, spróbuj ponownie.</div>';
	}
// --------------------------------------------------------

// -------------------------------------------------------- USTAWIENIA DOT. WYŚWIETLANIA NAPISU I TŁA NA STRONIE OBOZU LUB JEGO OPCJI
	if (isset($_GET['oboz']) or isset($_GET['opcje']))
	{
		$obozy = '';
	} else $obozy = 'Obozy';
	
	echo '<div class="post">
	<div class="postheader"><h1>'.$obozy.'</h1></div>
	<div class="postcontent">';
// --------------------------------------------------------

// -------------------------------------------------------- WYŚWIETLANIE WLASNEGO TŁA W OBOZIE ORAZ W OPCJACH JEŚLI ISTNIEJE
	$frakcje_tlo = '<div class="postbg" style="background: url(images/tla_strony/frakcje.jpg);"></div>';

	if (isset($_GET['oboz']))
	{
		$view = mysqli_fetch_object(mysqli_query($GLOBALS['db'], "SELECT `skrot_frakcji` FROM `frakcje` WHERE `skrot_frakcji`='".$_GET['oboz']."'"));	
		if ($view == true)
		{
			$file_name = dirname(__FILE__).'/images/tla_obozow/'.$view -> skrot_frakcji.'.png';
			if (file_exists($file_name))
			{
				$av2 = 'images/tla_obozow/'.$view -> skrot_frakcji.'.png?'.filemtime($file_name);
				$frakcje_tlo = '<div class="postbg" style="background: url('.$av2.'); background-size: 620px 280px;"></div>';
			}
		}
	}

	if (isset($_GET['opcje']))
	{
		$view = mysqli_fetch_object(mysqli_query($GLOBALS['db'], "SELECT `skrot_frakcji` FROM `frakcje` WHERE `skrot_frakcji`='".$_GET['opcje']."'"));	
		if ($view == true)
		{
			if($oboz['skrot_frakcji'] == $_GET['opcje'])
			{
				$file_name = dirname(__FILE__).'/images/tla_obozow/'.$view -> skrot_frakcji.'.png';
				if (file_exists($file_name))
				{
					$av2 = 'images/tla_obozow/'.$view -> skrot_frakcji.'.png?'.filemtime($file_name);
					$frakcje_tlo = '<div class="postbg" style="background: url('.$av2.'); background-size: 620px 280px;"></div>';
				}
				else $frakcje_tlo = '<div class="postbg" style="background: url(images/tla_obozow/frakcje_brak.jpg);"></div>';
			}
		}
	}

	echo $frakcje_tlo;
	echo '<div class="postbreak"></div>';
// --------------------------------------------------------

// -------------------------------------------------------- TWORZENIE OBOZU
	if (isset($_GET['utworz']))
	{
		if (!empty($_POST['name']) && !empty($_POST['short_name']))
		{
			$nazwa = htmlspecialchars($_POST['name']);
			$krotka_nazwa = htmlspecialchars($_POST['short_name']);
			$check = mysqli_fetch_array(mysqli_query($GLOBALS['db'], "SELECT `nazwa_frakcji` FROM `frakcje` WHERE `nazwa_frakcji`='".$nazwa."'"));
			$short_check = mysqli_fetch_array(mysqli_query($GLOBALS['db'], "SELECT `skrot_frakcji` FROM `frakcje` WHERE `skrot_frakcji`='".$krotka_nazwa."'"));
			$next = 1;

			if (strlen($nazwa) > 18) 
			{
				echo '<div class="komunikat komred">Nazwa frakcji powinien mieć 18 znaków!</div>';
				$next = null;
			}
			if (strlen($krotka_nazwa) > 4) 
			{
				echo '<div class="komunikat komred">Skrót frakcji powinien mieć 4 znaki!</div>';
				$next = null;
			}
			if (isset($check['nazwa_frakcji']) && !empty($nazwa)) 
			{
				echo '<div class="komunikat komred">Istnieje już obóz o takiej nazwie</div>';
				$next = null;
			}
			if (!preg_match('/^[-a-zA-Z0-9 ._]+$/', $nazwa))
			{
				echo '<div class="komunikat komred">Dozwolone znaki dla nazwy: A do Z (małe i duże), cyfry, myślnik, kropka, podkreślnik oraz spacja.</div>';
				$next = null;
			}
			if (ctype_alnum($krotka_nazwa))
			{}
			else
			{
				echo '<div class="komunikat komred">Dozwolone znaki dla skrótu: A do Z (małe oraz duże) oraz cyfry.</div>';
				$next = null;
			}
			if (isset($short_check['skrot_frakcji']) && !empty($krotka_nazwa))
			{
				echo '<div class="komunikat komred">Istnieje już obóz z takim skrótem</div>';
				$next = null;
			}
			
			if($next != null)
			{
				mysqli_query($GLOBALS['db'], "INSERT INTO `frakcje` (`nazwa_frakcji`, `skrot_frakcji`) VALUES ('".$nazwa."', '".$krotka_nazwa."')") or die(mysqli_error());
				$nowy_oboz = mysqli_fetch_array(mysqli_query($GLOBALS['db'], "SELECT `id` FROM `frakcje` WHERE `skrot_frakcji`='".$krotka_nazwa."'"));
				mysqli_query($GLOBALS['db'], 'UPDATE `konta` SET `oboz_id`="'.$nowy_oboz['id'].'", `oboz_ranga`="3" WHERE `id`='.$user -> get['id']) or die(mysqli_error());
				echo '<div class="komunikat_m komgreen">Obóz został założony! Za 5 sekund zostaniesz przekierowany na stronę twojego obozu. Możesz także nacisnąć <a style="font-size: 20px; color: white" href="obozy.php?oboz='.$krotka_nazwa.'">TUTAJ</a>.</div>';
				echo "<script>setTimeout(function() {window.location='obozy.php?oboz=".$krotka_nazwa."'}, 5000);</script>";
				echo '<noscript><meta http-equiv="refresh" content="5;url=obozy.php?oboz='.$krotka_nazwa.'" /></noscript>';
				$strona_glowna = 0;
			}
		}
		else echo '<div class="komunikat komred">Wypełnij wszystkie pola!</div>';
	}
// --------------------------------------------------------

// -------------------------------------------------------- OPCJE OBOZU
	if (isset($_GET['opcje']))
	{
		$view = mysqli_fetch_object(mysqli_query($GLOBALS['db'], "SELECT `skrot_frakcji` FROM `frakcje` WHERE `skrot_frakcji`='".$_GET['opcje']."'"));	
		if ($view == true)
		{
			if($oboz['skrot_frakcji'] == $_GET['opcje'])
			{
				$brak_perm = '';
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
								$haslo = password_verify(filtruj($_POST['haslo2']), $check['haslo']);
								
								if ($user -> get['haslo'] == htmlspecialchars($check['haslo']))
								{
									echo '<div class="komunikat_m komgreen">Obóz został usunięty. Za 5 sekund zostaniesz przekierowany na stronę Obozów. Możesz także nacisnąć <a style="font-size: 20px; color: white" href="obozy.php">TUTAJ</a>.</div>';
									mysqli_query($GLOBALS['db'], "UPDATE `konta` SET `oboz_id`=0, `oboz_ranga`=1 WHERE `oboz_id`=".$oboz_id['id']);
									mysqli_query($GLOBALS['db'], "DELETE FROM `frakcje` WHERE `skrot_frakcji`='".$_GET['opcje']."'");
									$file_name = dirname(__FILE__).'/images/tla_obozow/'.$_GET['opcje'].'.png';
									if (file_exists($file_name)) {
										$nazwa_folderu = dirname(__FILE__)."/images/tla_obozow/";
										if($file_name!='.' or $file_name!='..')
										{
										  unlink($file_name);
										}
									}
									echo "<script>setTimeout(function() {window.location='obozy.php'}, 5000);</script>";
									echo '<noscript><meta http-equiv="refresh" content="5;url=obozy.php" /></noscript>';
									echo '';
								}
								else
								{
									echo '<div class="komunikat_s komred">Wpisano złe hasło! Spróbuj ponownie.</div>';
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
								echo '<div class="komunikat_s komred">Na pewno chcesz usunąć? konto? Wpisz swoje hasło dla potwierdzenia.</div>';
								echo '
								<form action="obozy.php?opcje='.$_GET['opcje'].'&usun=tak" name="logowanie" method="post" style="margin-left: -20px;">
								<center>
								<p style="font-family: Metamorphous;">Twoje hasło: <input class="formul" style="width: 174px;margin-top: 5px;" type="password" name="haslo2"></p>
								<p><input class="gothbutton" type="submit" value="Usuń konto"><br></p>
								</form>';
							}
						}
						else echo '<div class="komunikat_m komred">Nie masz uprawnień!</div>';
					}
					else
					{
						echo '<a style="margin-top: -25px; margin-left: 5px; float: left; font-size: 17px; font-weight: normal; color: #E5E4E2;" href="obozy.php?oboz='.$_GET['opcje'].'">Przejdź do obozu</a>';
						echo '<br />';
						
						if (isset($_GET['dodaj']))
						{
							if (!empty($_POST['czlonek']))
							{
								$oboz1 = mysqli_fetch_object(mysqli_query($GLOBALS['db'], "SELECT `id`,`oboz_id` FROM `konta` WHERE `login`='".$_POST['czlonek']."'"));	
								if ($oboz1 == true)
								{
									while ($oboz_id_dodaj = mysqli_fetch_array($id_obozow))
									{
										if ($oboz1 -> oboz_id == $oboz_id_dodaj['id'])
										{
											$obozy_id_tdodaj = true;
											break;
										} else $obozy_id_tdodaj = false;
									}
									
									if ($obozy_id_tdodaj == false)
									{
										mysqli_query($GLOBALS['db'], 'UPDATE `konta` SET `oboz_id`='.$user -> get['oboz_id'].', `oboz_ranga`=1 WHERE `id`='.$oboz1 -> id) or die(mysqli_error());
										echo '<div class="komunikat komgreen">Dodano gracza do frakcji</div>';
									}
									else if ($oboz1 -> oboz_id == $user -> get['oboz_id'])
									{
										echo '<div class="komunikat komred">Gracz już należy do tej frakcji!</div>';
									}
									else echo '<div class="komunikat komred">Gracz już należy do innej frakcji!</div>';
								}
								else echo '<div class="komunikat komred">Nie ma takiego gracza!</div>';
							}
							else echo '<div class="komunikat komred">Nie podano loginu gracza!</div>';	 
							$strona_glowna = 0;
						}

						echo '<form method="post" action="obozy.php?opcje='.$oboz['skrot_frakcji'].'&dodaj">
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
								<form action="obozy.php?opcje='.$oboz['skrot_frakcji'].'&dodaj_tlo" method="POST" ENCTYPE="multipart/form-data">
								<p style="font-family: Metamorphous; margin-left: -12px;"><b>Max. rozmiar tła: 3MB<br />Zalecane wymiary tła: 620 x 280 px.</b></p>
								<input style="font-family: Metamorphous; color: white; margin-left: 8px; margin-bottom: 6px;" type="file" name="plik"/>
								<table><tr><td><input class="gothbutton" style="margin-left: 8px; margin-bottom: 6px;" type="submit" value="Wyślij plik"/></td>
								</form>';
								$file_name = 'images/tla_obozow/'.$oboz['skrot_frakcji'].'.png';
								if (file_exists($file_name))
								{
									echo '<td><form action="obozy.php?opcje='.$oboz['skrot_frakcji'].'&usun_tlo" method="POST" ENCTYPE="multipart/form-data">';
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
				else $brak_perm = '<div class="komunikat_m komred">Nie masz uprawnień!</div>';
				
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
				else $brak_perm = '<div class="komunikat_m komred">Nie masz uprawnień!</div>';
				
				echo $brak_perm;
			}
			else echo '<div class="komunikat_m komred">Nie masz uprawnień!</div>';
		}
		else echo '<div class="komunikat_m komred">Nie ma takiej frakcji!</div>';
		$strona_glowna = 0;
	}
// --------------------------------------------------------

// -------------------------------------------------------- STRONA OBOZU
	if (isset($_GET['oboz']))
	{
		$view = mysqli_fetch_object(mysqli_query($GLOBALS['db'], "SELECT * FROM `frakcje` WHERE `skrot_frakcji`='".$_GET['oboz']."'"));
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
			else $title = 'error_ ';
			
			echo '<a style="margin-top: -25px; margin-left: 5px; float: left; font-size: 17px; font-weight: normal; color: #E5E4E2;" href="obozy.php">Przejdź do listy obozów</a>';
			echo '<br />';
			
			if ($oboz['skrot_frakcji'] == $_GET['oboz'])
			{
				$wiu2 = mysqli_fetch_object(mysqli_query($GLOBALS['db'], "SELECT `id` FROM `konta` WHERE `oboz_id`='".$oboz_id['id']."' AND `oboz_ranga`=3"));
				$wiu3 = mysqli_fetch_object(mysqli_query($GLOBALS['db'], "SELECT `id` FROM `konta` WHERE `oboz_id`='".$oboz_id['id']."' AND `oboz_ranga`=2"));
				
				if ($wiu2 == true)
				{
				}
				else
				{
					if ($wiu3 == true)
					{
						if ($user -> get['oboz_ranga'] == '2')
						{
							echo '<div class="komunikat_s komred">Nie ma administratorów w obozie! <a style="font-size: 20px; color: red" href="obozy.php?oboz='.$_GET['oboz'].'&admin">Zostań administratorem obozu teraz!</a></div>';
						}
					}
					else
					{
						echo '<div class="komunikat_s komred">Nie ma moderatorów ani administratorów w obozie! <a style="font-size: 20px; color: red" href="obozy.php?oboz='.$_GET['oboz'].'&admin">Zostań administratorem obozu teraz!</a></div>';
					}
				}
			}
			else
			{
				$wiu4 = mysqli_fetch_object(mysqli_query($GLOBALS['db'], "SELECT `id` FROM `konta` WHERE `oboz_id`='".$oboz_id['id']."'"));
				if ($wiu4 == false)
				{
					if ($obozy_id_true == false)
					{
						echo '<div class="komunikat_s komred">Nie ma graczy w tym obozie! <a style="font-size: 20px; color: red" href="obozy.php?oboz='.$_GET['oboz'].'&admin">Zostań administratorem obozu teraz!</a></div>';
					}
				}
			}

			echo '<br />';
			echo '<div style="margin-left: 25px;">';
			echo 'Nazwa Obozu: '.$view -> nazwa_frakcji.'<br />';
			echo 'Skrót Obozu: '.$view -> skrot_frakcji.'<br />';
			
			if ($oboz['skrot_frakcji'] == $_GET['oboz'])
			{
				echo 'ID Obozu: '.$view -> id.'<br />';
				echo 'Twoja ranga: '.$title.'<br />';
				if($user -> get['oboz_ranga'] == 3 or $user -> get['oboz_ranga'] == 2) {echo '<a style="font-size: 20px; color: gold" href="obozy.php?opcje='.$view -> skrot_frakcji.'">OPCJE</a><br />';}
			}
			
			echo '<br />Lista członków:<br />';
			$wobozie = mysqli_query($GLOBALS['db'], "SELECT `login`,`oboz_ranga` FROM `konta` WHERE `oboz_id`='".$oboz_id['id']."' ORDER BY oboz_ranga DESC");
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
					else $title = 'error_ ';
					
					echo $title.''.$lista['login'].'</font><br />';
				}
			}
			else echo "Brak graczy!";
			echo '</div>';
			
		}
		else echo '<div class="komunikat_m komred">Nie ma takiej frakcji!</div>';
		$strona_glowna = 0;
	}
// --------------------------------------------------------

// -------------------------------------------------------- STRONA GŁÓWNA OBOZÓW
	if ($strona_glowna == 1)
	{

		if ($obozy_id_true == false)
		{
			$height = '35px';
			echo '<form method="post" action="obozy.php?utworz">
				  <table style="margin: 0 auto;">
				  <tr>
					  <td style="height: '.$height.';">Załóż własną frakcję:</td>
					  <td style="height: '.$height.';"></td>
				  </tr>
				  <tr>
					  <td style="height: '.$height.';">Nazwa (18 znaków)</td>
					  <td style="height: '.$height.';"><input class="formul" maxlength="18" type="text" name="name"></td></tr>
				  <tr>
					  <td style="height: '.$height.';">Skrót (4 znaki)</td>
					  <td style="height: '.$height.';"><input class="formul" maxlength="4" type="text" name="short_name"></td>
				  </tr>
				  <tr>
					  <td style="height: '.$height.';"></td>
					  <td style="height: '.$height.';"><input class="gothbutton" type="submit" name="utworz" value="Dodaj"></td>
				  </tr>
				  </table></form>';	
		}

		if ($obozy_id_true == true)
		{
			$oboz_nazwa = mysqli_fetch_object(mysqli_query($GLOBALS['db'], "SELECT `nazwa_frakcji` FROM `frakcje` WHERE `skrot_frakcji`='".$oboz['skrot_frakcji']."'"));
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
			echo 'Należysz do Obozu: '.$oboz_nazwa -> nazwa_frakcji.'<br />';
			echo 'Twoja ranga: '.$title.'<br /><br />';
			echo '<a style="font-size: 20px; color: #c18c11" href="obozy.php?oboz='.$oboz['skrot_frakcji'].'">ODWIEDŹ</a><br />';
			if($user -> get['oboz_ranga'] == 3 or $user -> get['oboz_ranga'] == 2) {echo '<a style="margin-right: 10px; font-size: 20px; color: gold" href="obozy.php?opcje='.$oboz['skrot_frakcji'].'">OPCJE</a><br />';}
			echo '<br />';
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
			$gracze = mysqli_fetch_object(mysqli_query($GLOBALS['db'], "SELECT `id` FROM `konta` WHERE `oboz_id`='".$lista['id']."'"));
			
			if($gracze == false)
			{
				$color = "#575266;; font-style: italic;";
			}
			else if($lista['skrot_frakcji'] == $oboz['skrot_frakcji'])
			{
				$color = "gold; font-style: italic;";
			}
			else $color = "white;";
			
			echo '<tr><td><p style="font-size: 27px; color:'.$color.'">'.$lista['id'].'</p></td>
				  <td><p style="font-size: 22px; color:'.$color.'">'.$lista['nazwa_frakcji'].'</p></td> 
				  <td><p style="font-size: 22px; color:'.$color.'">'.$lista['skrot_frakcji'].'</p></td>
				  <td><p style="font-size: 22px; color:'.$color.'"><a href="obozy.php?oboz='.$lista['skrot_frakcji'].'">Odwiedź</a></p></td></tr>';
						
		}
		echo '</table>';
	}
// --------------------------------------------------------
	?>
	</div>
	<div class="postfooter"></div>
</div>
<?php
require_once('bottom.php');
?>	 