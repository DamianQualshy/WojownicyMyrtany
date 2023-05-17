<?php
require_once('head.php');
?>

<div class="post" style="font-size: 20px;">
    <div class="postheader"><h1>Ustawienia</h1></div>
	<div class="postcontent">
	<br />
<?php
$ustawienia = 1;

if (isset($_GET['awatar']))
{
	if (isset($_POST['awek']))
	{
		$awek = $_POST['awek'];
		echo '<span style="color:green;">Zmieniono awatara.</span>';
		mysqli_query($GLOBALS['db'], "UPDATE `konta` SET `awatar_domyslny`='".$awek."' WHERE `id`=".$user -> get['id']);	
	}
}	

if (isset($_GET['usun']))
{
	if (isset($_GET['usun']) && $_GET['usun'] == 'usun')
	{
		if ($user -> get['usun_lub_reset'] == 1)
		{
			$kont = 1;
			
			mysqli_query($GLOBALS['db'], "UPDATE `konta` SET `usun_lub_reset`=0 WHERE `id`=".$user -> get['id']);
			
			if (isset($user -> get['skrot_frakcji']))
			{
				$lcf9 = mysqli_query($GLOBALS['db'], "SELECT `id` FROM `konta` WHERE `skrot_frakcji`='".$user -> get['skrot_frakcji']."'");
				$lcf9 = mysqli_num_rows($lcf9);
				
				if($lcf9 == 1)
				{
					mysqli_query($GLOBALS['db'], "DELETE FROM `frakcje` WHERE `skrot_frakcji`='".$user -> get['skrot_frakcji']."'");
					$tlo_frakcji = '/images/tla_obozow/'.$user -> get['skrot_frakcji'].'.png';
					unlink($tlo_frakcji);
				}
				else
				{
					$lcf29 = mysqli_query($GLOBALS['db'], "SELECT `id` FROM `konta` WHERE `skrot_frakcji`='".$user -> get['skrot_frakcji']."' AND `ranga_we_frakcji`='Admin'");
					$lcf29 = mysqli_num_rows($lcf2);
					if($lcf29 == 1)
					{
						echo '<center><font style="color: red">Najpierw przyznaj innemu członkowi obozu Admina lub usuń obóz.</font></center>';
						$kont = 0;
					}
				}
			}
			
			if ($kont == 1)
			{
				$id = $user -> get['id'];
				$login = $user -> get['login'];
				
				$awek = '/images/av_graczy/'.$login.'_av.png';
				unlink($awek);
				
				session_destroy();
				session_unset();
				
				mysqli_query($GLOBALS['db'], "DELETE FROM `ekwipunek` WHERE `owner`='".$id."'");
				mysqli_query($GLOBALS['db'], "DELETE FROM `mail` WHERE `owner`='".$id."'");
				mysqli_query($GLOBALS['db'], "DELETE FROM `konta` WHERE `id`='".$id."'");
				header('Location: index.php');
			}
		}
		if ($user -> get['haslo'] == htmlspecialchars($_POST['haslo2']))
		{
			echo 'Za 5 sekund twoje konto zostanie usunięte... ';
			header("Refresh: 5; URL=opcje.php?usun=usun");
			$ustawienia = 0;
			mysqli_query($GLOBALS['db'], "UPDATE `konta` SET `usun_lub_reset`=1 WHERE `id`=".$user -> get['id']);
		}
		else
		{
			echo '<center><font style="color: red">Wpisano złe hasło! Spróbuj ponownie.</font></center>';
			echo '
			<form action="opcje.php?reset=reset" name="logowanie" method="post" style="margin-left: -20px;">
			<center>
			<p style="font-family: Metamorphous;">Twoje hasło: <input class="formul" style="width: 174px;margin-top: 5px;" type="password" name="haslo2"></p>
			<p><input class="gothbutton" type="submit" value="Reset"><br></p>
			</form>
			';
			$ustawienia = 0;
		}
	}
	else
	{
		echo '<center><font style="color: red">Na pewno chcesz usunąć? konto? Wpisz swoje hasło dla potwierdzenia.</font></center>';
		echo '
		<form action="opcje.php?usun=usun" name="logowanie" method="post" style="margin-left: -20px;">
		<center>
		<p style="font-family: Metamorphous;">Twoje hasło: <input class="formul" style="width: 174px;margin-top: 5px;" type="password" name="haslo2"></p>
		<p><input class="gothbutton" type="submit" value="Usuń konto"><br></p>
		</form>
		';
		$ustawienia = 0;
	}
}

if (isset($_GET['reset']))
{
	if (isset($_GET['reset']) && $_GET['reset'] == 'reset')
	{
		if ($user -> get['usun_lub_reset'] == 1)
		{
			$kont = 1;
			
			$id = $user -> get['id'];
			$login = $user -> get['login'];
			$haslo = $user -> get['haslo'];
			$email = $user -> get['email'];
			$rank = $user -> get['rank'];
			mysqli_query($GLOBALS['db'], "UPDATE `konta` SET `usun_lub_reset`=0 WHERE `id`=".$user -> get['id']);
			
			if (isset($user -> get['skrot_frakcji']))
			{
				$lcf = mysqli_query($GLOBALS['db'], "SELECT `id` FROM `konta` WHERE `skrot_frakcji`='".$user -> get['skrot_frakcji']."'");
				$lcf = mysqli_num_rows($lcf);
				
				if($lcf == 1)
				{
					mysqli_query($GLOBALS['db'], "DELETE FROM `frakcje` WHERE `skrot_frakcji`='".$user -> get['skrot_frakcji']."'");
					$tlo_frakcji = '/images/tla_obozow/'.$user -> get['skrot_frakcji'].'.png';
					unlink($tlo_frakcji);
				}
				else
				{
					$lcf2 = mysqli_query($GLOBALS['db'], "SELECT `id` FROM `konta` WHERE `skrot_frakcji`='".$user -> get['skrot_frakcji']."' AND `ranga_we_frakcji`='Admin'");
					$lcf2 = mysqli_num_rows($lcf2);
					if($lcf2 == 1)
					{
						echo '<center><font style="color: red">Najpierw przyznaj innemu członkowi obozu Admina lub usuń obóz.</font></center>';
						$kont = 0;
					}
				}
			}
			
			if ($kont == 1)
			{
				$awek = '/images/av_graczy/'.$login.'_av.png';
				unlink($awek);
				
				mysqli_query($GLOBALS['db'], "DELETE FROM `ekwipunek` WHERE `owner`='".$id."'");
				mysqli_query($GLOBALS['db'], "DELETE FROM `mail` WHERE `owner`='".$id."'");
				mysqli_query($GLOBALS['db'], "DELETE FROM `konta` WHERE `id`='".$id."'");
				mysqli_query($GLOBALS['db'], "INSERT INTO `konta` (`id`, `login`, `haslo`, `email`, `atak`, `obrona`, `szybkosc`) VALUES ('".$id."', '".$login."', '".$haslo."', '".$email."', 10, 10, 10)");
				if ($rank == 'Admin')
				{
					mysqli_query($GLOBALS['db'], "UPDATE `konta` SET `rank`='Admin' WHERE `id`='".$id."'");
				}
				header('Location: poradnik.php');
			}
		}
		if ($user -> get['haslo'] == htmlspecialchars($_POST['haslo2']))
		{
			echo 'Za 5 sekund twoje konto zostanie zresetowane... ';
			header("Refresh: 5; URL=opcje.php?reset=reset");
			$ustawienia = 0;
			mysqli_query($GLOBALS['db'], "UPDATE `konta` SET `usun_lub_reset`=1 WHERE `id`=".$user -> get['id']);
		}
		else
		{
			echo '<center><font style="color: red">Wpisano złe hasło! Spróbuj ponownie.</font></center>';
			echo '<form action="opcje.php?reset=reset" name="logowanie" method="post" style="margin-left: -20px;">
			<center>
			<p style="font-family: Metamorphous;">Twoje hasło: <input class="formul" style="width: 174px; margin-top: 5px;" type="password" name="haslo2"></p>
			<p><input class="gothbutton" type="submit" value="Reset"><br></p>
			</form>
			';
			$ustawienia = 0;
		}
	}
	else
	{
		echo '<center><font style="color: red">Na pewno chcesz zresetować konto? Wpisz swoje hasło dla potwierdzenia.</font></center>';
		echo '<form action="opcje.php?reset=reset" name="logowanie" method="post" style="margin-left: -20px;">
		<center>
		<p style="font-family: Metamorphous;">Twoje hasło: <input class="formul" style="width: 174px; margin-top: 5px;" type="password" name="haslo2"></p>
		<p><input class="gothbutton" type="submit" value="Reset"><br></p>
		</form>
		';
		$ustawienia = 0;
	}
}

if ($ustawienia == 1)
{
	
if (isset($_GET['save']) && $_GET['save'] == 'pass')
{
    if (!empty($_POST['old_pass']) && !empty($_POST['new_pass'])) 
    {
	    $pobierz = mysqli_fetch_object(mysqli_query($GLOBALS['db'], "SELECT `haslo` FROM `konta` WHERE `haslo`='".$_POST['old_pass']."'"));
        if ($pobierz == true)
        {
            mysqli_query($GLOBALS['db'], "UPDATE `konta` SET `haslo`='".htmlspecialchars($_POST['new_pass'])."' WHERE `id`=".$user -> get['id']);
			$_SESSION['pass'] = htmlspecialchars($_POST['new_pass']);
			echo '<span style="color:green;">Zapisano nowe hasło</span>';
        }	
        else echo '<span style="color:red;">Złe stare hasło!</span>';		
	}
	else echo '<span style="color:red;">Nic nie wpisano!</span>';
}

if (isset($_GET['save']) && $_GET['save'] == 'mail')
{
    if (!empty($_POST['mail'])) 
    {
        require_once('common/verify_mail.php');
        if (!MailVal($_POST['mail'], 2))
        {	
            mysqli_query($GLOBALS['db'], "UPDATE `konta` SET `email`='".htmlspecialchars($_POST['mail'])."' WHERE `id`=".$user -> get['id']);		
		    echo '<span style="color:green;">Zapisano nowy e-mail</span>';
        }
		else echo '<span style="color:red;">Taki adres e-mail nie istnieje!</span>';
	}	
	else echo '<span style="color:red;">Nic nie wpisano!</span>';
}

if (isset($_GET['save']) && $_GET['save'] == 'char')
{
        mysqli_query($GLOBALS['db'], "UPDATE `konta` SET `hobby`='".htmlspecialchars($_POST['opis'])."', 
                                        `wiek`='".htmlspecialchars($_POST['wiek'])."',
							    	    `opis`='".htmlspecialchars($_POST['opis'])."'
										WHERE `id`=".$user -> get['id']);				 
	    echo '<span style="color:green;">Zapisano nową charakterystykę</span>';
}

		echo '<table style="margin: 0 auto;">
	            <tr style="height: 35px;">
					<form action="opcje.php?save=pass" method="post">
						<td style="width: 130px;">Stare hasło:</td>
						<td><input class="formul" style="width:174px;" type="password" name="old_pass"></td>
						<td></td>
				</tr><tr style="height: 35px;">
						<td style="width: 130px;">Nowe hasło:</td>
						<td><input class="formul" style="width:174px;" type="password" name="new_pass"></td>
						<td><input style="margin-left: 8px;" class="gothbutton" type="submit" value="Zmień hasło"></td>
					</form>
				</tr>
			  </table><br />';
		echo '<table style="margin: 0 auto;">
	            <tr style="height: 35px;">
					<form action="opcje.php?save=mail" method="post">
					<td style="width: 130px;">Nowy e-mail:</td>
					<td><input class="formul" style="width:174px;" type="text" name="mail"></td>
					<td><input style="margin-left: 8px;" class="gothbutton" type="submit" value="Zmień e-mail"></td>
					</form>
				</tr>
			  </table><br /><br />';
				/* <tr>
					<form action="opcje.php?save=char" method="post">
						<td>Opis:</td> <td><textarea style="margin-right: 8px; margin-left: 8px; resize:none; width: 194px; min-width: 194px; max-width: 194px; height: 152px; min-height: 152px; max-height: 152px;" name="opis"></textarea></td>
					<td><input class="gothbutton" type="submit" value="Zmień opis"></td>
					</form>
				</tr> */

if (isset($_GET['save']) && $_GET['save'] == 'av')
{
	$max_rozmiar = 1000000;
	if (is_uploaded_file($_FILES['plik']['tmp_name']))
	{
		if ($_FILES['plik']['size'] > $max_rozmiar) {
			echo '<font style="margin-left: 36px; color:red;">Błąd! Plik jest za duży!</font>';
		} else {
			echo '<font style="margin-left: 36px; color:green;">Plik został odebrany pomyślnie!</font>';
			move_uploaded_file($_FILES['plik']['tmp_name'], 'images/av_graczy/'.$user -> get['login'].'_av.png');
			mysqli_query($GLOBALS['db'], "UPDATE `konta` SET `awatar_domyslny`=4 WHERE `id`=".$user -> get['id']);
		}
	}
	 else echo '<font style="margin-left: 36px; color:red;">Błąd przy przesyłaniu danych!</font>';
}

if (isset($_GET['save']) && $_GET['save'] == 'del_av')
{
	$file_name = 'images/av_graczy/'.$user -> get['login'].'_av.png';
	if (file_exists($file_name)) {
		$nazwa_folderu = "images/av_graczy/";
		if($file_name!='.' or $file_name!='..')
		{
		  unlink($file_name);
		  echo '<font style="margin-left: 36px; color:green;">Pomyślnie usunięto awatara.</font>';
		}
		else echo '<font style="margin-left: 36px; color:red;">Brak awatara!</font>';
	}
	else echo '<font style="margin-left: 36px; color:red;">Brak awatara!</font>';
}
?>
		<table style="margin: 0 auto;">
		<tr>
		<td>
		<form action="opcje.php?save=av" method="POST" ENCTYPE="multipart/form-data">
		<p style="font-family: Metamorphous; margin-left: -18px;"><b>Max. rozmiar obrazka to 1MB<br/>Zalecane wymiary 140 x 140 px</b></p>
		<input style="font-family: Metamorphous; color: white; margin-left: 2px; margin-bottom: 6px;" type="file" name="plik"/>
		<table>
			<tr>
				<td>
					<input class="gothbutton" style="margin-bottom: 6px;" type="submit" value="Wyślij plik"/>
				</td>
				</form>
				<?php
				$file_name = 'images/av_graczy/'.$user -> get['login'].'_av.png';
				if (file_exists($file_name)) {
					echo '<td><form action="opcje.php?save=del_av" method="POST" ENCTYPE="multipart/form-data">';
					echo '<input class="gothbutton" style="margin-top: -5px; margin-left: 10px; margin-right: 10px;" type="submit" value="Usuń awatara"/>';
					echo '</form></td>';
				}
				?>
			</tr>
		</table>
		</td>
		<td>
		<?php
		$wielkosc = '120px';
		$wielkosc_tla = '140px';

		$file_name = 'images/av_graczy/'.$user -> get['login'].'_av.png';
		if (file_exists($file_name))
		{
			$av = 'images/av_graczy/'.$user -> get['login'].'_av.png';
			list($width, $height) = getimagesize($file_name);
			/*echo '<br /><img style="margin-left: 20px; margin-right: 32px;" src="'.$av.'?'.time().'" ';*/
			echo '
				<div>
					<div style="background: url(images/bck.png) no-repeat center center; background-size: '.$wielkosc_tla.' '.$wielkosc_tla.'; position: relative; width:'.$wielkosc.'; height:'.$wielkosc.';" >
						<img style="margin: auto; position: absolute; top: 0; left: 0; bottom: 0; right: 0;max-width: '.$wielkosc.'; max-height: '.$wielkosc.';" src="'.$file_name.'" />
					</div>
					<img draggable="false" style="position: relative; margin-top: -'.$wielkosc.'; max-width: '.$wielkosc.'; max-height: '.$wielkosc.';" src="images/awatary/ramka.png" />
				</div>';
		}
		else echo '<br /><img height="120px" width="120px" src="images/brak_avatara.jpg" alt="member" />';
		?>
		</td>
		</tr>
		</table>
		<br />
		<br />
				<center>
				<form action="opcje.php?awatar" method="post">
				<h3>Wybierz jeden z naszych awatarów lub wybierz własny!</h3>
				<label>
				<input value="0" name="awek" type="radio"><img height="110px" src="/images/awatary/DefAV.png">
				</label>
				<label>
				<input value="1" name="awek" type="radio"><img height="110px" src="/images/awatary/cien.png">
				</label>
				<label>
				<input value="2" name="awek" type="radio"><img height="110px" src="/images/awatary/szkodnik.png">
				</label>
				<label>
				<input value="3" name="awek" type="radio"><img height="110px" src="/images/awatary/nowicjusz.png">
				</label>
				<?php
				if (file_exists($file_name))
				{
				echo '<label><input value="4" name="awek" type="radio">';
				list($width, $height) = getimagesize($file_name);
				echo '<img src="'.$av.'" ';
				if ($width > $height)
				{
					echo 'width="110px" />';
				}
				else if ($height > $width)
				{
					echo 'height="110px" />';
				}
				else if ($height == $width)
				{
					echo 'height="110px" width="110px" />';
				}
				echo '</label>';
				}
				?>
				<input class="gothbutton" type="submit" value="Akceptuj">
				</form>
				</center>
				
				
				<br /><br /><br />				
				<table style="margin: 0 auto -30px;">
				  <tr>
					<th>
						<form action="opcje.php?reset" method="post" style="margin-left: 0px;">
						<p><input class="gothbutton" type="submit" value="Resetuj konto"></p>
						</form>
					</th>
					<th>
						<form action="opcje.php?usun" method="post" style="margin-left: 0px;">
						<p><input class="gothbutton" type="submit" value="Usuń konto"></p>
						</form>
					</th>
				  </tr>
				</table>
<?php
}
?>
	</div>
    <div class="postfooter">
</div>

<?php
require_once('bottom.php');
?>