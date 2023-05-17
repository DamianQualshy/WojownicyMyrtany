<?php
	require_once('../common/session.php');
	require_once('../common/config.php');
	require_once('../common/user.php');
	
	$coinflip = $_POST['coinflip'];
	$tura = $_POST['tura'];
	$enemy_hp = $_POST['enemy_hp'];
	$my_hp = $_POST['my_hp'];
	$my_maxhp = $_POST['my_maxhp'];
	$atak_ogolny = $_POST['atak_ogolny'];
	$atak_ogolny_wroga = $_POST['atak_ogolny_wroga'];
	$szansa_obrona = $_POST['szansa_obrona'];
	$szansa_atak = $_POST['szansa_atak'];
	$przeciwnik = $_POST['przeciwnik'];
	$kasa = $_POST['kasa'];
	$exp = $_POST['exp'];
	$my_zmeczenie = $_POST['my_zmeczenie'];
	$my_maxzmeczenie = $_POST['my_maxzmeczenie'];
	$szansa_na_obrone = $_POST['szansa_na_obrone'];
	$szansa_na_obrone2 = $_POST['szansa_na_obrone2'];
	$szansa_na_atak = $_POST['szansa_na_atak'];
	$niekoniec = $_POST['niekoniec'];

	if($tura == 0)
	{
		if ($coinflip == 1)
		{
			echo '<div class="komunikat komyellow">Wróg rozpoczyna tury</div><br />';
		}
		else
		{
			echo '<div class="komunikat komgreen">Ty rozpoczynasz tury</div><br />';
		}
	}
	
	if($tura == 0)
	{
		echo '<div style="height: 50px;"></div>';
	}
	else
	{
		echo '<div class="komunikat_w komwhite">Tura <b>'.$tura.'</b>, przeciwnik z ID: '.$przeciwnik.'</div>';
	}

	if(isset($_POST['ruch']) && $tura > 0)
	{
		if($_POST['ruch'] == 'atak') // Ruch - ATAK
		{
			if ($coinflip == 1)
			{
				$szansa2 = rand(1,100);
				if ($szansa2 <= $szansa_na_obrone)
				{
					$my_hp = $my_hp-$atak_ogolny_wroga;
					echo '<div class="komunikat_w komred">Otrzymałeś cios, tracisz <b>'.$atak_ogolny_wroga.'</b> zdrowia. (rand '.$szansa2.')</div>';
					mysqli_query($GLOBALS['db'], "UPDATE `konta` SET `hp` = '".$my_hp."' WHERE id=".$user -> get['id']);
					if($my_hp <= 0)
					{
						echo '<div class="komunikat_w komred">Padasz na ziemię, <b>przegrywasz</b>!</div>';
						mysqli_query($GLOBALS['db'], "UPDATE `konta` SET `hp`=1 WHERE id=".$user -> get['id']);
						echo '<script>odswiez();</script>';
						$niekoniec = 0;
					}
				}
				else echo '<div class="komunikat_w komgreen">Unikasz ciosu przeciwnika (rand '.$szansa2.')</div>';
				$szansa_na_obrone = $szansa_na_obrone2;
				
				if($niekoniec == 1)
				{
					$szansa = rand(1,100);
					if ($szansa <= $szansa_na_atak)
					{
						$enemy_hp = $enemy_hp-$atak_ogolny;
						echo '<div class="komunikat_w komgreen">Trafiłeś przeciwnika, zadajesz mu <b>'.$atak_ogolny.'</b> obrażeń. ('.$enemy_hp.') (rand '.$szansa.')</div>';
						if($enemy_hp <= 0)
						{
							echo '<br /> <div class="komunikat_w komgreen">Przeciwnik padł na ziemię, <b>wygrywasz</b>!</div>';
							mysqli_query($GLOBALS['db'], "UPDATE `konta` SET `kasa` = `kasa`+".$kasa.", `exp`=`exp`+".$exp." WHERE id=".$user -> get['id']);
							echo '<script>odswiez();</script>';
							$niekoniec = 0;
						}
					}
					else echo '<div class="komunikat_w komyellow">Przeciwnik uniknął twojego ataku... (rand '.$szansa.')</div>';
				}
			}
			else
			{
				$szansa = rand(1,100);
				if ($szansa <= $szansa_na_atak)
				{
					$enemy_hp = $enemy_hp-$atak_ogolny;
					echo '<div class="komunikat_w komgreen">Trafiłeś przeciwnika, zadajesz mu <b>'.$atak_ogolny.'</b> obrażeń. ('.$enemy_hp.') (rand '.$szansa.')</div>';
					if($enemy_hp <= 0)
					{
						echo '<br /> <div class="komunikat_w komgreen">Przeciwnik padł na ziemię, <b>wygrywasz</b>!</div>';
						mysqli_query($GLOBALS['db'], "UPDATE `konta` SET `kasa` = `kasa`+".$kasa.", `exp`=`exp`+".$exp." WHERE id=".$user -> get['id']);
						echo '<script>odswiez();</script>';
						$niekoniec = 0;
					}
				}
				else echo '<div class="komunikat_w komyellow">Przeciwnik uniknął twojego ataku... (rand '.$szansa.')</div>';
				
				if($niekoniec == 1)
				{
					$szansa2 = rand(1,100);
					if ($szansa2 <= $szansa_na_obrone)
					{
						$my_hp = $my_hp-$atak_ogolny_wroga;
						echo '<div class="komunikat_w komred">Otrzymałeś cios, tracisz <b>'.$atak_ogolny_wroga.'</b> zdrowia. (rand '.$szansa2.')</div>';
						mysqli_query($GLOBALS['db'], "UPDATE `konta` SET `hp` = '".$my_hp."' WHERE id=".$user -> get['id']);
						if($my_hp <= 0)
						{
							echo '<br /><div class="komunikat_w komred">Padasz na ziemię, <b>przegrywasz</b>!</div>';
							mysqli_query($GLOBALS['db'], "UPDATE `konta` SET `hp`=1 WHERE id=".$user -> get['id']);
							echo '<script>odswiez();</script>';
							$niekoniec = 0;
						}
					}
					else echo '<div class="komunikat_w komgreen">Unikasz ciosu przeciwnika (rand '.$szansa2.')</div>';
				}
			}
		}
		
		if($_POST['ruch'] == 'obrona')
		{
			if ($coinflip == 1)
			{
				$szansa2 = rand(1,100);
				if ($szansa2 <= $szansa_na_obrone)
				{
					$my_hp = $my_hp-$atak_ogolny_wroga;
					echo '<div class="komunikat_w komred">Otrzymałeś cios, tracisz <b>'.$atak_ogolny_wroga.'</b> zdrowia. (rand '.$szansa2.')</div>';
					mysqli_query($GLOBALS['db'], "UPDATE `konta` SET `hp` = '".$my_hp."' WHERE id=".$user -> get['id']);
					if($my_hp <= 0)
					{
						echo '<br /><div class="komunikat_w komred">Padasz na ziemię, <b>przegrywasz</b>!</div>';
						mysqli_query($GLOBALS['db'], "UPDATE `konta` SET `hp`=1 WHERE id=".$user -> get['id']);
						echo '<script>odswiez();</script>';
						$niekoniec = 0;
					}
				}
				else echo '<div class="komunikat_w komgreen">Unikasz ciosu przeciwnika (rand '.$szansa2.')</div>';
				$szansa_na_obrone = $szansa_na_obrone2;
				
				if($niekoniec == 1)
				{
					$szansa_na_obrone = round ($szansa_na_obrone/2, 0);
					if ($szansa_na_obrone <= 5)
					{
						$szansa_na_obrone = 5;
					}
					echo '<div class="komunikat_w komgreen">W następnej turze będziesz miał większe szanse na uniknięcie ataku (rand '.$szansa_na_obrone.')</div>';
				}
			}
			else
			{
				$szansa_na_obrone = round ($szansa_na_obrone/2, 0);
				if ($szansa_na_obrone <= 5)
				{
					$szansa_na_obrone = 5;
				}
				echo '<div class="komunikat_w komgreen">Bronisz się i zwiększasz swoje szanse na blok (rand '.$szansa_na_obrone.')</div>';
				
				$szansa2 = rand(1,100);
				if ($szansa2 <= $szansa_na_obrone)
				{
					$my_hp = $my_hp-$atak_ogolny_wroga;
					echo '<div class="komunikat_w komred">Otrzymałeś cios, tracisz <b>'.$atak_ogolny_wroga.'</b> zdrowia. (rand '.$szansa2.')</div>';
					mysqli_query($GLOBALS['db'], "UPDATE `konta` SET `hp` = '".$my_hp."' WHERE id=".$user -> get['id']);
					if($my_hp <= 0)
					{
						echo '<div class="komunikat_w komred">Padasz na ziemię, <b>przegrywasz</b>!</div>';
						mysqli_query($GLOBALS['db'], "UPDATE `konta` SET `hp`=1 WHERE id=".$user -> get['id']);
						echo '<script>odswiez();</script>';
						$niekoniec = 0;
					}
				}
				else echo '<div class="komunikat_w komgreen">Unikasz ciosu przeciwnika (rand '.$szansa2.')</div>';
				$szansa_na_obrone = $szansa_na_obrone2;
			}
		}
		
		if($_POST['ruch'] == 'special')
		{
			echo '<div class="komunikat_w komgreen">Special</div>';
			$my_zmeczenie = $my_zmeczenie+10;
			mysqli_query($GLOBALS['db'], "UPDATE `konta` SET `zmeczenie` = '".$my_zmeczenie."' WHERE id=".$user -> get['id']);
		}
		
		if($_POST['ruch'] == 'ucieczka')
		{
			echo '<div class="komunikat_w komred">Postanawiasz poddać się, <b>przegrywasz</b>!</div>';
			$niekoniec = 0;
		}
	}
	$tura++;
	
	$style = "display: inline-block; width: 130px; background-size: 130px 102px;";
	
if($niekoniec == 1)
{
?>
<br />
<center>
<input name="walka" style="<?php echo $style; ?>" value="Atakuj" class="gothbutton" type="button" onClick="arena2('atak');" />
<input name="walka" style="<?php echo $style; ?>" value="Broń się" class="gothbutton" type="button" onClick="arena2('obrona');" />
<input name="walka" style="<?php echo $style; ?>" value="Specjalne" class="gothbutton" type="button" onClick="arena2('special');" />
<input name="walka" style="<?php echo $style; ?> color: red;" value="Poddaj się" class="gothbutton" type="button" onClick="arena2('ucieczka');" />
</center>

<?php
echo '<div class="komunikat_s komwhite">Życie: <b>'.$my_hp.'/'.$my_maxhp.'</b>, Zmęczenie: <b>'.$my_zmeczenie.'/'.$my_maxzmeczenie.'</b></div>';
}

echo '<script>
var ruch = "";
function arena2(wybor)
{
	var ruch = wybor;
	$.ajax
	({
		async: true,
		type: "POST",
		url: "includes/arena.php",
		data: {niekoniec: "'.$niekoniec.'",  szansa_na_obrone: "'.$szansa_na_obrone.'", szansa_na_obrone2: "'.$szansa_na_obrone2.'", szansa_na_atak: "'.$szansa_na_atak.'", coinflip: "'.$coinflip.'",tura: "'.$tura.'", enemy_hp: "'.$enemy_hp.'", my_hp: "'.$my_hp.'", my_maxhp : "'.$my_maxhp.'", my_zmeczenie: "'.$my_zmeczenie.'", my_maxzmeczenie: "'.$my_maxzmeczenie.'", atak_ogolny: "'.$atak_ogolny.'", atak_ogolny_wroga: "'.$atak_ogolny_wroga.'", szansa_obrona: "'.$szansa_obrona.'", szansa_atak: "'.$szansa_atak.'", przeciwnik: "'.$przeciwnik.'", kasa: "'.$kasa.'", exp: "'.$exp.'", ruch: ruch},
		success: function (html)
		{$("#arena").html(html);}  
	});
}
</script>';
?>