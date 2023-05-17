<?php
require_once('head.php');

require_once('includes/perm_admin.php');
?>

<div class="post">
	<div class="postheader"><h1>Panel Administracyjny <a href="gracze.php">Zarejestrowanych: <b><?php  $users = mysqli_num_rows(mysqli_query($GLOBALS['db'], 'SELECT `id` FROM `konta`')); echo $users ?></b></a></h1></div>
    <div class="postcontent" style="min-height: 678px">
		<div style="padding-left: 20px;">
			<br />
			
			<script src="zakladki/zakladki.js"></script>
			<link href="zakladki/zakladki2.css" rel="stylesheet" type="text/css" />

		<center>
		<div class="tabs">
			<h3 class="tab-title">Wybierz kategorię</h3><br />
			<a href="#newsy">Newsy</a>
			<a href="#uzytkownicy">Użytkownicy</a>
			<a href="#strony">Strony</a>
		</div>
		</center>

		<div style="display: none;" id="tabs-container" class="tabs-container">
			<article id="newsy" class="tab-content">
				<div class="tab-text">
					<?php
					echo '<br />';
					echo '<h3>NEWSY NA STRONIE GŁÓWNEJ</h3>'; // ------------------ NEWSY
					$lista = array(
					'href="admin.php?step=news">Dodaj news</a>',
					'href="admin.php?step=edit_news">Edytuj news</a>',
					'href="admin.php?step=delete_news">Usuń news</a>',
					);
					$arrlength = count($lista);

					for($x = 0; $x < $arrlength; $x++)
					{
						echo'- <a style="';
						if($x%2 == 0)
						{
							echo 'color: #fff;" ';
						} else echo 'color: #81756d;" ';
						echo $lista[$x];
						echo "<br />";
					}
					?>
				</div>
			</article>
			<article id="uzytkownicy" class="tab-content">
				<div class="tab-text">
					<?php
					echo '<br />';
					echo '<h3>UŻYTKOWNICY</h3>'; // ------------------ UŻYTKOWNICY
					$lista = array(
					'href="admin.php?step=edit">Edytuj użytkownika</a>',
					'href="admin.php?step=">Resetuj użytkownika (do zrobienia)</a>',
					'href="admin.php?step=level">Zmień poziom użytkownika</a>',
					'href="admin.php?step=delete">Usuń użytkownika</a>',
					);
					$arrlength = count($lista);

					for($x = 0; $x < $arrlength; $x++)
					{
						echo'- <a style="';
						if($x%2 == 0)
						{
							echo 'color: #fff;" ';
						} else echo 'color: #81756d;" ';
						echo $lista[$x];
						echo "<br />";
					}
					?>
				</div>
			</article>
			<article id="strony" class="tab-content"> <!--- Opis i obrazek http://marant.tawerna-gothic.pl/index.php?topic=26023.0--->
				<div class="tab-text">
					<?php
					echo '<br />';
					echo '<h3>STRONY</h3>'; // ------------------ STRONY
					$lista = array(
					'href="admin.php?step=item">SKLEP - Dodaj przedmiot</a>',
					'href="admin.php?step=edit_item">SKLEP - Edytuj przedmiot</a>',
					'href="admin.php?step=">SKLEP - Usuń przedmiot(do zrobienia)</a><br />',
					'href="admin.php?step=enemy">ARENA - Dodaj przeciwnika</a>',
					'href="admin.php?step=edit_enemy">ARENA - Edytuj przeciwnika</a>',
					'href="admin.php?step=">ARENA - Usuń przeciwnika(do zrobienia)</a><br />',
					'href="admin.php?step=">KLASZTOR - Dodaj miksturę(do zrobienia)</a>',
					'href="admin.php?step=">KLASZTOR - Edytuj miksturę(do zrobienia)</a>',
					'href="admin.php?step=">KLASZTOR - Usuń miksturę(do zrobienia)</a><br />',
					'href="admin.php?step=reset_karczma">KARCZMA - Zresetuj powiadomienie o nowych wiadomościach</a>',
					);
					$arrlength = count($lista);

					for($x = 0; $x < $arrlength; $x++)
					{
						echo'- <a style="';
						if($x%2 == 0)
						{
							echo 'color: #fff;" ';
						} else echo 'color: #81756d;" ';
						echo $lista[$x];
						echo "<br />";
					}
					?>
				</div>
			</article>
		</div>
		<br /><br />
		</div>
	<center>
<?php

// -------------------------------------------------------- DODAWANIE NEWSA
$news_formul = '<div style="font-style: italic; text-align: center; color: white; font-size: 20px;">NEWSY - DODAWANIE</div>
				<form method="post" action="admin.php?step=news#add">
					<table>
						<tr>
							<td>
								<textarea style="resize: none; width: 340px; min-width: 340px; max-width: 340px; height: 152px; min-height: 152px; max-height: 152px;" type="text" name="text"></textarea>
							</td>
						</tr>
						<tr>
							<td>
								<input class="gothbutton" type="submit" name="add" value="Dodaj">
							</td>
						</tr>
					</table>
				</form>';

if (isset($_GET['step']) && $_GET['step'] == 'news')
{
    if (isset($_POST['add']))
	{
	    if (!empty($_POST['text']))
		{
			$czas = date('H:i');
			$data = date('d-m-Y');
		    $_POST['text'] = nl2br($_POST['text']);
		    mysqli_query($GLOBALS['db'], "INSERT INTO `newsy` (`data`,`czas`,`text`) VALUES ('".$data."','".$czas."','".htmlspecialchars($_POST['text'])."')");  
		    echo '<div class="komunikat komgreen">Dodano news</div>'.$news_formul;
		}
		else echo '<div class="komunikat komred">Wypełnij wszystkie pola!</div>'.$news_formul;
	}
    else echo $news_formul;
}
// --------------------------------------------------------

// -------------------------------------------------------- EDYCJA NEWSA

$news_edit_formul = '<div style="font-style: italic; text-align: center; color: white; font-size: 20px;">NEWSY - EDYCJA</div>
	<table>
	<tr>
		<td style="padding-right: 10px; height: 35px;"><form method="get" action="">Wpisz ID newsa</td>
		<td style="height: 35px;"><input class="formul" type="text" name="edit_news"></td>
	</tr>
	<tr>
		<td style="padding-right: 10px; height: 35px;"></td>
		<td style="height: 35px;"><input class="gothbutton" type="submit" value="Dalej"></form></td>
	</tr>
	</table>';

if (isset($_GET['step']) && $_GET['step'] == 'edit_news')
{
    echo $news_edit_formul;
}


// Edycja newsa - przekierowanie po wpisaniu ID
if (isset($_GET['edit_news']))
{

	if (isset($_POST['save_post']))
	{
	    echo '<div class="komunikat komred">Zapisano</div>';
		mysqli_query($GLOBALS['db'], "UPDATE `newsy` SET `data`='".$_POST['post_data']."', `czas`='".$_POST['post_czas']."', `text`='".$_POST['post_text']."' WHERE `id`='".$_GET['edit_news']."'");
	}

    $pobierz = mysqli_query($GLOBALS['db'], "SELECT * FROM `newsy` WHERE `id`='".$_GET['edit_news']."'");
	$query = mysqli_fetch_array($pobierz);
	if ($query == true)
	{
        $num_columns = mysqli_num_fields($pobierz);
		echo '<form method="post" action="admin.php?edit_news='.$_GET['edit_news'].'">
		<table>';

		
		$str     = $query['text'];
		$order   = array("<br />");
		$replace = '';
		$newstr = str_replace($order, $replace, $str);
		
		echo '<tr>
		<td style="padding-right: 10px; text-align: right; height: 35px;">Data </td>
		<td style="height: 35px;"><input class="formul" type="text" name="post_data" value="'.$query['data'].'"></td>
		</tr>';
		
		echo '<tr>
		<td style="padding-right: 10px; text-align: right; height: 35px;">Czas </td>
		<td style="height: 35px;"><input class="formul" type="text" name="post_czas" value="'.$query['czas'].'"></td>
		</tr>';
		
		echo '<tr>
		<td style="padding-right: 10px; text-align: right; height: 35px;">Treść </td>
		<td><textarea style="resize: none; width: 340px; min-width: 340px; max-width: 340px; height: 152px; min-height: 152px; max-height: 152px;" type="text" name="post_text">'.$newstr.'</textarea></td>
		</tr>';
			
		echo '<tr>
			<td style="height: 35px;"></td> 
			<td style="height: 35px;"><input class="gothbutton" type="submit" value="Zapisz" name="save_post"></td>
		</tr>
		</table>
		</form>';
	}	
	else
	{
		echo '<div class="komunikat komred">Nie ma newsa z takim ID!</div>';
		echo $news_edit_formul;
	}
}
// --------------------------------------------------------

// -------------------------------------------------------- USUWANIE NEWSA

$delete_news_formul = '<div style="font-style: italic; text-align: center; color: red; font-size: 20px;">NEWSY - USUNIĘCIE</div>
						<table>
						<tr>
							<td style="text-align: right; padding-right: 10px; height: 35px;"><form method="get" action="">Wpisz ID newsa</td>
							<td style="height: 35px;"><input class="formul" type="text" name="delete_news"></td>
						</tr>
						<tr>
							<td style="font-style: italic; text-align: right; color: red; padding-right: 10px; height: 35px;"></td>
							<td style="height: 35px;"><input class="gothbutton" type="submit" value="Dalej"></form></td>
						</tr>
						</table>';

if (isset($_GET['step']) && $_GET['step'] == 'delete_news')
{
    echo $delete_news_formul;
}


// Usuwanie newsa - przekierowanie po wpisaniu ID
if (isset($_GET['delete_news']))
{
    $pobierz = mysqli_query($GLOBALS['db'], "SELECT * FROM `newsy` WHERE `id`='".$_GET['delete_news']."'");
	$query = mysqli_fetch_array($pobierz);
	if ($query == true)
	{
		echo '<div class="komunikat komgreen">News został usunięty</div>';
		mysqli_query($GLOBALS['db'], "DELETE FROM `newsy` WHERE `id`='".$_GET['delete_news']."'");
	}	
	else
	{
		echo '<div class="komunikat komred">Nie ma newsa z takim ID!</div>';
		echo $delete_news_formul;
	}
}
// --------------------------------------------------------



// -------------------------------------------------------- EDYCJA UŻYTKOWNIKA

$user_edit_formul = '<div style="font-style: italic; text-align: center; color: white; font-size: 20px;">UŻYTKOWNICY - EDYCJA</div>
	<table>
	<tr>
		<td style="padding-right: 10px; height: 35px;"><form method="get" action="">Wpisz nick</td>
		<td style="height: 35px;"><input class="formul" type="text" name="edit"></td>
	</tr>
	<tr>
		<td style="padding-right: 10px; height: 35px;"></td>
		<td style="height: 35px;"><input class="gothbutton" type="submit" value="Dalej"></form></td>
	</tr>
	</table>';

if (isset($_GET['step']) && $_GET['step'] == 'edit')
{
    echo $user_edit_formul;
}

// Edycja użytkownika - przekierowanie po wpisaniu nazwy
if (isset($_GET['edit']))
{
	function mysqli_field_name($result, $field_offset)
	{
		$properties = mysqli_fetch_field_direct($result, $field_offset);
		return is_object($properties) ? $properties->name : null;
	}
	
    $pobierz = mysqli_query($GLOBALS['db'], "SELECT * FROM `konta` WHERE `login`='".$_GET['edit']."'");
	$query = mysqli_fetch_array($pobierz);
	if ($query == true)
	{
		if (isset($_POST['save']))
		{
		    echo '<div class="komunikat komgreen">Zapisano nowe dane użytkownika <b>'.$_GET['edit'].'</b></div>';
			echo $user_edit_formul;
			
			$num_columns = mysqli_num_fields($pobierz);
			for ($i = 0; $i < $num_columns; $i++)
			{
				$arrusers[$i] = mysqli_field_name($pobierz, $i);
				$arrdane[$i] = $query[$arrusers[$i]];
				
				mysqli_query($GLOBALS['db'], "UPDATE `konta` SET `".$arrusers[$i]."`='".$_POST[$arrusers[$i]]."' WHERE `login`='".$_GET['edit']."'");				 
			}
		}
		else
		{
			$num_columns = mysqli_num_fields($pobierz);
			echo '<form method="post" action="admin.php?edit='.$_GET['edit'].'#edit">
			<table>';
			for ($i = 0; $i < $num_columns; $i++)
			{
				$arrusers[$i] = mysqli_field_name($pobierz, $i);
				$arrdane[$i] = $query[$arrusers[$i]];
				
				if (isset($_POST['save']))
				{
					mysqli_query($GLOBALS['db'], "UPDATE `konta` SET `".$arrusers[$i]."`='".$_POST[$arrusers[$i]]."' WHERE `login`='".$_GET['edit']."'");
				}  					
				echo '<tr><td style="padding-right: 10px; height: 35px; text-align: right;">'.$arrusers[$i].'</td>
					  <td style="height: 35px;"><input class="formul" type="text" name="'.$arrusers[$i].'" value="'.$arrdane[$i].'"></td></tr>';    
			}
			echo '<tr><td style="height: 35px;"></td>
					  <td style="height: 35px;"><input class="gothbutton" type="submit" value="Zapisz" name="save"></td></tr>
				  </table>
				  </form>';
		}
	}	
	else
	{
		echo '<div class="komunikat komred">Nie ma takiego użytkownika!</div>';
		echo $user_edit_formul;
	}
}
// --------------------------------------------------------

// -------------------------------------------------------- ZMIANA POZIOMU UŻYTKOWNIKA

$height = '35px';
$marginleft = '10px';
$user_level_formul = '<div style="font-style: italic; text-align: center; color: white; font-size: 20px;">UŻYTKOWNICY - ZMIANA POZIOMU</div>
			  <table style="margin: 0 auto;">
			  <tr>
				<td style="height: '.$height.'; text-align: right;"><form method="post" action="admin.php?step=level">Podaj login</td>
				<td style="height: '.$height.'; margin-left: '.$marginleft.';"><input style="margin-left: '.$marginleft.';" class="formul" type="text" name="user"></td>
			  </tr>
			  <tr>
				<td style="height: '.$height.'; text-align: right;">Przyznaj poziom</td>
				<td style="height: '.$height.'; margin-left: '.$marginleft.';"><input style="margin-left: '.$marginleft.';" class="formul" type="text" name="poziom"></td>
			  </tr>
			  <tr>
				<td style="height: '.$height.';"></td>
				<td style="height: '.$height.';"><input style="margin-left: '.$marginleft.';" class="gothbutton" name="level" type="submit" value="Dalej"></form></td>
			  </tr>
			</table>';

if (isset($_GET['step']) && $_GET['step'] == 'level')
{
    if (isset($_POST['level']))
	{
		if (isset($_POST['poziom']))
		{
			if (isset($_POST['user']))
			{
				$pobierz = mysqli_fetch_object(mysqli_query($GLOBALS['db'], "SELECT `lvl`,`atak`,`obrona`,`szybkosc`,`hp`,`maxhp`,`zmeczenie`,`pkt`,`id` FROM `konta` WHERE `login`='".$_POST['user']."'"));
				if ($pobierz == true)
				{
					$mnoznik = $_POST['poziom'];
					
					if($mnoznik >= 2931)
					{
						$mnoznik = 2930;
					}
					
					$level = $mnoznik;
					$levelexp = $level-1;
					
					/* $maxexp2 = pow(2,$level); //Podwojenie max expa z lvl 0
					$maxexp = 500*$maxexp2; //Mnożenie podstawowego Max EXP * Poziom
					
					$exp2 = pow(2,$level-1); //Exp to max EXP z poprzedniego poziomu 
					$exp = 500*$exp2; //Mnożenie EXP * Poziom - 1 */
					
					$maxexp5 = $level+3;
					$maxexp4 = $maxexp5/2;
					$maxexp3 = $maxexp4*500;
					$maxexp2 = $maxexp3*$level;
					$maxexp = $maxexp2+500;
					
					$exp5 = $levelexp+3;
					$exp4 = $exp5/2;
					$exp3 = $exp4*500;
					$exp2 = $exp3*$levelexp;
					$exp = $exp2+500;
					
					
					if($level > $pobierz -> lvl)
					{
						$pkt_nauki3 = $level-$pobierz -> lvl; //Oblicza różnicę podanego poziomu a poziomu gracza
						$pkt_nauki2 = $pkt_nauki3*10; //Mnoży razy 10PN
						$pkt_nauki = $pobierz -> pkt + $pkt_nauki2; //Punkty nauki
						
						$atak = $pobierz -> atak; //Siła niezmienna
						$obrona = $pobierz -> obrona; //Obrona niezmienna
						$szybkosc = $pobierz -> szybkosc; //Szybkość niezmienna
					}
					else if($level == $pobierz -> lvl)
					{
						$pkt_nauki2 = $level*10; //Mnoży razy 10PN
						$pkt_nauki = $pkt_nauki2; //Punkty nauki
						
						$atak = 10; //Reset siły, bo obniżenie poziomu gracza
						$obrona = 10; //Reset obrony, bo obniżenie poziomu gracza
						$szybkosc = 10; //Reset szybkości, bo obniżenie poziomu gracza
					}
					else
					{
						$pkt_nauki2 = $level*10; //Mnoży razy 10PN
						$pkt_nauki = $pkt_nauki2; //Punkty nauki
						
						$atak = 10; //Reset siły, bo obniżenie poziomu gracza
						$obrona = 10; //Reset obrony, bo obniżenie poziomu gracza
						$szybkosc = 10; //Reset szybkości, bo obniżenie poziomu gracza
					}
					
					$maxhp2 = 20*$level;
					$maxhp = 100+$maxhp2;
					if($pobierz -> hp > $maxhp)
					{
						$hp = $maxhp;
					}
					else if($pobierz -> hp == $pobierz -> maxhp)
					{
						$hp = $maxhp;
					}
					else $hp = $pobierz -> hp;
		
					$maxzmeczenie2 = 15*$level;
					$maxzmeczenie = 50+$maxzmeczenie2;
					if($pobierz -> zmeczenie > $maxzmeczenie)
					{
						$zmeczenie = $maxzmeczenie;
					}
					else $zmeczenie = $pobierz -> zmeczenie;
					
					if($level == 0) //Poprawki dot. poziomu 0
					{
						$pkt_nauki = 0; //Poziom 0 = PN 0
						$exp = 0; //Poziom 0 = EXP 0
					}
					
					if($level == 1) //Email o 1 poziomie
					{
						$date = date("Y-m-d H:i:s");
						$wiad2 = 'gratulujemy! Zdobyłeś PIERWSZY poziom! W nagrodę dostajesz Sztylet w twoim ekwipunku. Powodzenia w drodze do szczytu!';
						$wiad = nl2br(strip_tags($wiad2));
						$temat = 'NOWY POZIOM';
						$id_wiad = '0';
						$adminsi = 'ADMIN';
						mysqli_query($GLOBALS['db'], "INSERT INTO `mail` (`owner`, `text`, `title`, `autor_id`, `autor`, `date`, `type`) VALUES (".$pobierz -> id.", '<i><span style=font-size:20px;>".$_POST['user']."</span></i>, ".$wiad."', '".$temat."', ".$id_wiad.", '".$adminsi."', '".$date."', 'odebrane')");
						mysqli_query($GLOBALS['db'], "INSERT INTO `ekwipunek` (`stan`, `owner`, `id_broni`) VALUES (0,".$pobierz -> id.",2)");
					}
					if($level == 2930)
					{
						$date = date("Y-m-d H:i:s");
						$wiad2 = 'gratulujemy! NIESAMOWITE! Osiągnąłeś maksymalny poziom dostępny w tej grze!!';
						$wiad = nl2br(strip_tags($wiad2));
						$temat = 'MAKSYMALNY POZIOM';
						$id_wiad = '0';
						$adminsi = 'ADMIN';
						mysqli_query($GLOBALS['db'], "INSERT INTO `mail` (`owner`, `text`, `title`, `autor_id`, `autor`, `date`, `type`) VALUES (".$user -> get['id'].", '<i><span style=font-size:20px;>".$user -> get['login']."</span></i>, ".$wiad."', '".$temat."', ".$id_wiad.", '".$adminsi."', '".$date."', 'odebrane')");
						
						echo '<div class="komunikat komwhite">Maksymalny poziom to 2930, podany poziom został automatycznie zniżony do maksymalnego.</div>';
					}
					mysqli_query($GLOBALS['db'], "UPDATE `konta` SET `lvl`='".$level."', `exp`='".$exp."', `pkt`='".$pkt_nauki."', `atak`='".$atak."', `obrona`='".$obrona."', `szybkosc`='".$szybkosc."', `maxhp`='".$maxhp."', `hp`='".$hp."', `max_zmeczenie`='".$maxzmeczenie."', `zmeczenie`='".$zmeczenie."' WHERE `login`='".$_POST['user']."'") or die(mysqli_error());
					
					if($level <= 5)
					{
						$q_level = $level;
					}
					else $q_level = 5;
					$id = mysqli_fetch_array(mysqli_query($GLOBALS['db'], "SELECT `id` FROM `konta` WHERE `login`='".$_POST['user']."'"));
					mysqli_query($GLOBALS['db'], 'UPDATE `zadania` SET `piaty_poziom`='.$q_level.' WHERE `id_gracza`='.$id['id']);
					
					echo '<div class="komunikat komgreen">Udało się zmienić poziom użytkownika na <b>'.$level.'</b></div>'.$user_level_formul;
				}
				else echo '<div class="komunikat komred">Nie ma takiego użytkownika!</div>'.$user_level_formul;
			}
			else echo '<div class="komunikat komred">Wypełnij wszystkie pola!</div>'.$user_level_formul;
		}
		else echo '<div class="komunikat komred">Wypełnij wszystkie pola!</div>'.$user_level_formul;
	}
	else
	{
		echo $user_level_formul;
	}
}
// --------------------------------------------------------

// -------------------------------------------------------- USUNIĘCIE UŻYTKOWNIKA
// Skasuję gnojka ~Cipher
$delete_formul = '<div style="font-style: italic; text-align: center; color: red; font-size: 20px;">UŻYTKOWNICY - USUNIĘCIE</div>
				<table>
				<tr>
					<td style="text-align: right; padding-right: 10px; height: 35px;"><form method="post" action="admin.php?step=delete#delete">Wpisz login</td>
					<td style="height: 35px;"><input class="formul" type="text" name="user"></td>
				</tr>
				<tr>
					<td style="font-style: italic; text-align: right; color: red; padding-right: 10px; height: 35px;"></td>
					<td style="height: 35px;"><input class="gothbutton" name="delete" type="submit" value="Dalej"></form></td>
				</tr>
				</table>';

if (isset($_GET['step']) && $_GET['step'] == 'delete')
{
    if (isset($_POST['delete']))
	{
	    if ($_POST['user'] != $user -> get['login'])
		{
	        $pobierz = mysqli_fetch_object(mysqli_query($GLOBALS['db'], "SELECT `login` FROM `konta` WHERE `login`='".$_POST['user']."'"));
		    if ($pobierz == true)
	    	{
		        mysqli_query($GLOBALS['db'], "DELETE FROM `konta` WHERE `login`='".$_POST['user']."'");
				echo '<div class="komunikat komgreen">Gracz został usunięty</div>'.$delete_formul;;
		    }
			else echo '<div class="komunikat komred">Nie ma takiego użytkownika!</div>'.$delete_formul;
	    }
		else echo '<div class="komunikat komred">Nie możesz usunąć sam siebie!</div>'.$delete_formul;
	}
	else echo $delete_formul;
}
// --------------------------------------------------------



// -------------------------------------------------------- SKLEP - DODAWANIE PRZEDMIOTU
$item_formul = '<div style="font-style: italic; text-align: center; color: white; font-size: 20px;">SKLEP - DODAWANIE PRZEDMIOTU</div>
			   <form method="post" action="admin.php?step=item#add">
			   <table>
				<tr>
				   <td style="height: 35px; text-align: right; padding-right: 10px;">Nazwa</td>
				   <td style="height: 35px;"><input class="formul" type="text" name="name"></td>
			   </tr>
			   <tr>
				   <td style="height: 35px; text-align: right; padding-right: 10px;">Atak</td>
				   <td style="height: 35px;"><input class="formul" type="text" name="attack"></td>
			   </tr>
			   <tr>
				   <td style="height: 35px; text-align: right; padding-right: 10px;">Cena</td>
				   <td style="height: 35px;"><input class="formul" type="text" name="cost"></td>
			   </tr>
			   <tr>
				   <td style="height: 35px; text-align: right; padding-right: 10px;">Cena sprzedaży</td>
				   <td style="height: 35px;"><input class="formul" type="text" name="sellcost"></td>
			   </tr>
			   <tr>
				   <td style="height: 35px; text-align: right; padding-right: 10px;">Wymagana siła</td>
				   <td style="height: 35px;"><input class="formul" type="text" name="req_str"></td>
			   </tr>
			   <tr>
				   <td style="height: 35px; text-align: right; padding-right: 10px;">Wymagany poziom</td>
				   <td style="height: 35px;"><input class="formul" type="text" name="req_lvl"></td>
			   </tr>
			   <tr>
				   <td style="height: 35px; text-align: right; padding-right: 10px;">Nazwa ikonki</td>
				   <td style="height: 35px;"><input class="formul" type="text" name="ikon"></td>
			   </tr>
			   <tr>
				   <td style="height: 35px; text-align: right; padding-right: 10px;"></td>
				   <td style="height: 35px;"><input class="gothbutton" type="submit" name="add" value="Dodaj"></td>
			   </tr>
			   </table>';

if (isset($_GET['step']) && $_GET['step'] == 'item')
{
    if (isset($_POST['add']))
	{
	    if (preg_match("/^[0-9]*$/", $_POST['cost']) && preg_match("/^[0-9]*$/", $_POST['attack']))
		{
		    if (!empty($_POST['cost']) && !empty($_POST['attack']) && !empty($_POST['name']))
			{
			    mysqli_query($GLOBALS['db'], "INSERT INTO `sklep` (`nazwa`, `atak`, `req_sila`, `req_lvl`, `cena`, `sprzedaz`, `ikonka`) VALUES ('".htmlspecialchars($_POST['name'])."', ".$_POST['attack'].", ".$_POST['req_str'].", ".$_POST['req_lvl'].", ".$_POST['cost'].", ".$_POST['sellcost'].", '".htmlspecialchars($_POST['ikon'])."')");  
			    echo '<div class="komunikat komgreen">Dodano przedmiot</div>'.$item_formul;
			}
		else echo '<div class="komunikat komred">Wypełnij wszystkie pola!</div>'.$item_formul;
		}
		else echo '<div class="komunikat komred">>Atak i cena muszą być liczbą!</div>'.$item_formul;
	}
    else echo $item_formul;
}
// --------------------------------------------------------

// -------------------------------------------------------- SKLEP - EDYCJA PRZEDMIOTU 

$item_edit_formul = '<div style="font-style: italic; text-align: center; color: white; font-size: 20px;">SKLEP - EDYCJA PRZEDMIOTU</div>
	<table>
	<tr>
		<td style="padding-right: 10px; height: 35px;"><form method="get" action="">Wpisz ID przedmiotu</td>
		<td style="height: 35px;"><input class="formul" type="text" name="edit_item"></td>
	</tr>
	<tr>
		<td style="padding-right: 10px; height: 35px;"></td>
		<td style="height: 35px;"><input class="gothbutton" type="submit" value="Dalej"></form></td>
	</tr>
	</table>';

if (isset($_GET['step']) && $_GET['step'] == 'edit_item')
{
    echo $item_edit_formul;
}

// Edycja przedmiotu - przekierowanie po wpisaniu nazwy
if (isset($_GET['edit_item']))
{
    $pobierz = mysqli_query($GLOBALS['db'], "SELECT * FROM `sklep` WHERE `id`='".$_GET['edit_item']."'");
	$query = mysqli_fetch_array($pobierz);
	if ($query == true)
	{
		if (isset($_POST['save']))
		{
			mysqli_query($GLOBALS['db'], "UPDATE `sklep` SET `nazwa`='".htmlspecialchars($_POST['name'])."', `atak`=".$_POST['attack'].", `req_sila`=".$_POST['req_str'].", `req_lvl`=".$_POST['req_lvl'].", `cena`=".$_POST['cost'].", `sprzedaz`=".$_POST['sellcost'].", `ikonka`='".htmlspecialchars($_POST['ikon'])."' WHERE `id`='".$_GET['edit_item']."'");  
		    echo '<div class="komunikat komgreen">Zapisano</div>';
			echo $item_edit_formul;
		}
		else echo '<div style="font-style: italic; text-align: center; color: white; font-size: 20px;">SKLEP - EDYCJA PRZEDMIOTU</div>
			   <form method="post" action="admin.php?edit_item='.$_GET['edit_item'].'">
			   <table>
				<tr>
				   <td style="height: 35px; text-align: right; padding-right: 10px;">Nazwa</td>
				   <td style="height: 35px;"><input class="formul" type="text" name="name" value="'.$query['nazwa'].'"></td>
			   </tr>
			   <tr>
				   <td style="height: 35px; text-align: right; padding-right: 10px;">Atak</td>
				   <td style="height: 35px;"><input class="formul" type="text" name="attack" value="'.$query['atak'].'"></td>
			   </tr>
			   <tr>
				   <td style="height: 35px; text-align: right; padding-right: 10px;">Cena</td>
				   <td style="height: 35px;"><input class="formul" type="text" name="cost" value="'.$query['cena'].'"></td>
			   </tr>
			   <tr>
				   <td style="height: 35px; text-align: right; padding-right: 10px;">Cena sprzedaży</td>
				   <td style="height: 35px;"><input class="formul" type="text" name="sellcost" value="'.$query['sprzedaz'].'"></td>
			   </tr>
			   <tr>
				   <td style="height: 35px; text-align: right; padding-right: 10px;">Wymagana siła</td>
				   <td style="height: 35px;"><input class="formul" type="text" name="req_str" value="'.$query['req_sila'].'"></td>
			   </tr>
			   <tr>
				   <td style="height: 35px; text-align: right; padding-right: 10px;">Wymagany poziom</td>
				   <td style="height: 35px;"><input class="formul" type="text" name="req_lvl" value="'.$query['req_lvl'].'"></td>
			   </tr>
			   <tr>
				   <td style="height: 35px; text-align: right; padding-right: 10px;">Nazwa ikonki</td>
				   <td style="height: 35px;"><input class="formul" type="text" name="ikon" value="'.$query['ikonka'].'"></td>
			   </tr>
			   <tr>
				   <td style="height: 35px; text-align: right; padding-right: 10px;"></td>
				   <td style="height: 35px;"><input class="gothbutton" type="submit" name="save" value="Dodaj"></td>
			   </tr>
			   </table>';
	}	
	else
	{
		echo '<div class="komunikat komred">Nie ma przedmiotu z takim ID!</div>';
		echo $item_edit_formul;
	}
}
// --------------------------------------------------------

// -------------------------------------------------------- ARENA - DODAWANIE PRZECIWNIKA
$enemy_formul = '<div style="font-style: italic; text-align: center; color: white; font-size: 20px;">ARENA - DODAWANIE PRZECIWNIKA</div>
			   <form method="post" action="admin.php?step=enemy#add">
			   <table
			   <tr><td style="height: 35px; text-align: right; padding-right: 10px;">Nazwa</td> <td style="height: 35px;"><input class="formul" type="text" name="name"></td></tr>
			   <tr><td style="height: 35px; text-align: right; padding-right: 10px;">Atak</td> <td style="height: 35px;"><input class="formul" type="text" name="attack"></td></tr>
			   <tr><td style="height: 35px; text-align: right; padding-right: 10px;">Obrona</td> <td style="height: 35px;"><input class="formul" type="text" name="shield"></td></tr>
			   <tr><td style="height: 35px; text-align: right; padding-right: 10px;">Szybkość</td> <td style="height: 35px;"><input class="formul" type="text" name="speed"></td></tr>
			   <tr><td style="height: 35px; text-align: right; padding-right: 10px;">Kasa</td> <td style="height: 35px;"><input class="formul" type="text" name="money"></td></tr>
			   <tr><td style="height: 35px; text-align: right; padding-right: 10px;">Życie</td> <td style="height: 35px;"><input class="formul" type="text" name="hp"></td></tr>
			   <tr><td style="height: 35px; text-align: right; padding-right: 10px;">Exp</td> <td style="height: 35px;"><input class="formul" type="text" name="exp"></td></tr>
			   <tr><td style="height: 35px; text-align: right; padding-right: 10px;">Wymagany poziom</td> <td style="height: 35px;"><input class="formul" type="text" name="req_lvl"></td></tr>
			   <tr><td style="height: 35px; text-align: right; padding-right: 10px;">Nazwa awatara</td> <td style="height: 35px;"><input class="formul" type="text" name="awatar"></td></tr>
			   <tr><td style="height: 35px; text-align: right; padding-right: 10px;"></td> <td style="height: 35px;"><input class="gothbutton" type="submit" name="add" value="Dodaj"></td></tr>
			   </table>';

if (isset($_GET['step']) && $_GET['step'] == 'enemy')
{
    if (isset($_POST['add']))
	{
	    if (preg_match("/^[0-9]*$/", $_POST['attack']) && preg_match("/^[0-9]*$/", $_POST['shield']) && preg_match("/^[0-9]*$/", $_POST['speed']) && preg_match("/^[0-9]*$/", $_POST['money']) && preg_match("/^[0-9]*$/", $_POST['hp']) && preg_match("/^[0-9]*$/", $_POST['exp']))
		{
		    if (!empty($_POST['attack']) && !empty($_POST['speed']) && !empty($_POST['shield']) && !empty($_POST['money']) && !empty($_POST['hp']) && !empty($_POST['name']) && !empty($_POST['awatar']))
			{
			    mysqli_query($GLOBALS['db'], "INSERT INTO `enemy` (`name`, `atak`, `obrona`, `szybkosc`, `kasa`, `hp`, `exp`, `req_lvl`, `awatar`) VALUES ('".htmlspecialchars($_POST['name'])."', ".$_POST['attack'].", ".$_POST['shield'].", ".$_POST['speed'].", ".$_POST['money'].", ".$_POST['hp'].", ".$_POST['exp'].", ".$_POST['req_lvl'].", '".htmlspecialchars($_POST['awatar'])."')") or die(mysqli_error());  
			    echo '<div class="komunikat komgreen">Dodano wroga</div>'.$enemy_formul;
			}
			else echo '<div class="komunikat komred">Wypełnij wszystkie pola!</div>'.$enemy_formul;
		}
		else echo '<div class="komunikat komred">Wszystkie pola poza nazwą przeciwnika muszą być liczbą!</div>'.$enemy_formul;
	}
    else echo $enemy_formul;
}
// --------------------------------------------------------

// -------------------------------------------------------- SKLEP - EDYCJA PRZECIWNIKA 

$enemy_edit_formul = '<div style="font-style: italic; text-align: center; color: white; font-size: 20px;">SKLEP - EDYCJA PRZEDMIOTU</div>
	<table>
	<tr>
		<td style="padding-right: 10px; height: 35px;"><form method="get" action="">Wpisz ID przeciwnika</td>
		<td style="height: 35px;"><input class="formul" type="text" name="edit_enemy"></td>
	</tr>
	<tr>
		<td style="padding-right: 10px; height: 35px;"></td>
		<td style="height: 35px;"><input class="gothbutton" type="submit" value="Dalej"></form></td>
	</tr>
	</table>';

if (isset($_GET['step']) && $_GET['step'] == 'edit_enemy')
{
    echo $enemy_edit_formul;
}

// Edycja przedmiotu - przekierowanie po wpisaniu nazwy
if (isset($_GET['edit_enemy']))
{
    $pobierz = mysqli_query($GLOBALS['db'], "SELECT * FROM `enemy` WHERE `id`='".$_GET['edit_enemy']."'");
	$query = mysqli_fetch_array($pobierz);
	if ($query == true)
	{
		if (isset($_POST['save']))
		{
			mysqli_query($GLOBALS['db'], "UPDATE `enemy` SET `name`='".htmlspecialchars($_POST['name'])."', `atak`=".$_POST['attack'].", `obrona`=".$_POST['shield'].", `szybkosc`=".$_POST['speed'].", `kasa`=".$_POST['money'].", `hp`=".$_POST['hp'].", `exp`=".$_POST['exp'].", `awatar`='".htmlspecialchars($_POST['awatar'])."' WHERE `id`='".$_GET['edit_enemy']."'") or die(mysqli_error());  
			echo '<div class="komunikat komgreen">Zapisano</div>';
			echo $enemy_edit_formul;
		}
		else echo '<div style="font-style: italic; text-align: center; color: white; font-size: 20px;">ARENA - DODAWANIE PRZECIWNIKA</div>
			   <form method="post" action="admin.php?edit_enemy='.$_GET['edit_enemy'].'">
			   <table
			   <tr><td style="height: 35px; text-align: right; padding-right: 10px;">Nazwa</td> <td style="height: 35px;"><input class="formul" type="text" name="name" value="'.$query['name'].'"></td></tr>
			   <tr><td style="height: 35px; text-align: right; padding-right: 10px;">Atak</td> <td style="height: 35px;"><input class="formul" type="text" name="attack" value="'.$query['atak'].'"></td></tr>
			   <tr><td style="height: 35px; text-align: right; padding-right: 10px;">Obrona</td> <td style="height: 35px;"><input class="formul" type="text" name="shield" value="'.$query['obrona'].'"></td></tr>
			   <tr><td style="height: 35px; text-align: right; padding-right: 10px;">Szybkość</td> <td style="height: 35px;"><input class="formul" type="text" name="speed" value="'.$query['szybkosc'].'"></td></tr>
			   <tr><td style="height: 35px; text-align: right; padding-right: 10px;">Kasa</td> <td style="height: 35px;"><input class="formul" type="text" name="money" value="'.$query['kasa'].'"></td></tr>
			   <tr><td style="height: 35px; text-align: right; padding-right: 10px;">Życie</td> <td style="height: 35px;"><input class="formul" type="text" name="hp" value="'.$query['hp'].'"></td></tr>
			   <tr><td style="height: 35px; text-align: right; padding-right: 10px;">Exp</td> <td style="height: 35px;"><input class="formul" type="text" name="exp" value="'.$query['exp'].'"></td></tr>
			   <tr><td style="height: 35px; text-align: right; padding-right: 10px;">Nazwa awatara</td> <td style="height: 35px;"><input class="formul" type="text" name="awatar" value="'.$query['awatar'].'"></td></tr>
			   <tr><td style="height: 35px; text-align: right; padding-right: 10px;"></td> <td style="height: 35px;"><input class="gothbutton" type="submit" name="save" value="Dodaj"></td></tr>
			   </table>';
	}	
	else
	{
		echo '<div class="komunikat komred">Nie ma przeciwnika z takim ID!</div>';
		echo $enemy_edit_formul;
	}
}
// --------------------------------------------------------

// -------------------------------------------------------- KARCZMA - RESET POWIADOMIENIA O WIADOMOŚCIACH
if (isset($_GET['step']) && $_GET['step'] == 'reset_karczma')
{
    mysqli_query($GLOBALS['db'], "UPDATE `konta` SET `czat_przeczytane`=0");  
	echo '<div class="komunikat komgreen">Zresetowano powiadomienie o nowych wiadomościach każdemu graczowi</div>';
}
// --------------------------------------------------------
?>
	</center>
    </div>
    <div class="postfooter"></div>
</div>

<?php
require_once('bottom.php');
?>