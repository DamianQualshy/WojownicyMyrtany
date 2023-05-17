<?php
	require_once('../common/session.php');
	require_once('../common/config.php');
	require_once('../common/user.php');

	$coinflip = $_POST['coinflip'];
	$tura = $_POST['tura'];
	$enemy_hp = $_POST['enemy_hp'];
	$my_hp = $_POST['my_hp'];
	$atak_ogolny = $_POST['atak_ogolny'];
	$atak_ogolny_wroga = $_POST['atak_ogolny_wroga'];
	$szansa_obrona = $_POST['szansa_obrona'];
	$szansa_atak = $_POST['szansa_atak'];
	
			while ($tura > 0) /* Tury */
			{
				echo '<br /><div class="komunikat_w komwhite">Tura <b>'.$tura.'</b></div>';
				$rand1 = rand(1, 100);
				$rand2 = rand(1, 100);

				if ($coinflip == 1)
				{
					if ($rand1 <= $szansa_obrona)
					{
						echo '<div class="komunikat_w komwhite">Uniknąłeś ciosu przeciwnika</div>';
					}
					else
					{
						$my_hp = $my_hp - $atak_ogolny_wroga;
						echo '<div class="komunikat_w komwhite">Przeciwnik atakuje i zadaje Ci obrażenia: '.$atak_ogolny_wroga.'.</div>';
						mysqli_query($GLOBALS['db'], "UPDATE `konta` SET `hp` = `hp`  - '".$atak_ogolny_wroga."' WHERE id=".$user -> get['id']);	
					}
					
					if ($my_hp <= 0)
					{
						echo '<div class="komunikat_w komred">Nie jesteś w stanie walczyć. <b>Przegrywasz</b>...</div>';
						$tura = 1;
					}
					else
					{
						if ($rand2 <= $szansa_atak)
						{
							$enemy_hp = $enemy_hp - $atak_ogolny;
							echo '<div class="komunikat_w komwhite">Wykorzystujesz szansę i zadajesz przeciwnikowi obrażenia: '.$atak_ogolny.'.</div>';
						}
						else
						{
							echo '<div class="komunikat_w komwhite">Nie udało Ci się wykonać kontrataku.</div>';
						}
					}
					
					if ($enemy_hp <= 0) 
					{
						echo '<div class="komunikat_w komgreen">Przeciwnik padł na ziemię. <b>Wygrywasz</b>!</div>';
						$tura = 1;
					}

					$coinflip = 0;
					
				}
				else
				{
					if ($rand1 <= $szansa_atak)
					{
						$enemy_hp = $enemy_hp - $atak_ogolny;
						echo '<div class="komunikat_w komwhite">Atakujesz i zadajesz przeciwnikowi obrażenia: '.$atak_ogolny.'.</div>';
					}
					else
					{
						echo '<div class="komunikat_w komwhite">Przeciwnik uniknął twojego ataku.</div>';
					}
					
					if ($enemy_hp <= 0) 
					{
						echo '<div class="komunikat_w komgreen">Przeciwnik padł na ziemię. <b>Wygrywasz</b>!</div>';
						$tura = 1;
					}
					else
					{
						if ($rand2 <= $szansa_obrona)
						{
							echo '<div class="komunikat_w komwhite">Przeciwnikowi nie udało się wykonać kontrataku.</div>';
						}
						else
						{
							$my_hp = $my_hp - $atak_ogolny_wroga;
							echo '<div class="komunikat_w komwhite">Przeciwnik kontratakuje i zadaje Ci obrażenia: '.$atak_ogolny_wroga.'.</div>';
							mysqli_query($GLOBALS['db'], "UPDATE `konta` SET `hp` = `hp`  - '".$atak_ogolny_wroga."' WHERE id=".$user -> get['id']);
						}
					}

					if ($my_hp <= 0)
					{
						echo '<div class="komunikat_w komred">Nie jesteś w stanie walczyć. <b>Przegrywasz</b>...</div>';
						$tura = 1;
					}

					$coinflip = 1;
					
				}
				
				echo '<br />';
				$tura++;

				if ($tura == 21)    
				{ 
					$tura = 0;
					echo '<div class="komunikat_w komyellow">Walka nierozstrzygnięta. Czas na walkę minął.</div>'; 
				}
				else if ($my_hp <= 0)
				{
					$tura = 0;
					if ($user -> get['kasa'] <= $_POST['kasa'])
					{
						mysqli_query($GLOBALS['db'], "UPDATE `konta` SET `kasa`=0 WHERE `id`=".$user -> get['id']);  
						$kasa = 'cały swój majątek';                    
					}
					else
					{
						mysqli_query($GLOBALS['db'], "UPDATE `konta` SET `kasa`=`kasa`-".$_POST['kasa']." WHERE `id`=".$user -> get['id']);
						$kasa = $_POST['kasa'].' $';
					}
					echo '<div class="komunikat_w komred">Przegrywasz pojedynek. Tracisz '.$kasa.'</div>';
					mysqli_query($GLOBALS['db'], "UPDATE `konta` SET `hp`=1 WHERE id=".$user -> get['id']);
				}
				else if ($enemy_hp <= 0) 
				{
					$tura = 0;
					mysqli_query($GLOBALS['db'], "UPDATE `konta` SET `kasa`=`kasa`+".$_POST['kasa']." WHERE `id`=".$user -> get['id']);
					echo '<div class="komunikat_w komgreen">Ludzie głosowali na Ciebie, zdobywasz '.$_POST['kasa'].' $</div>';

					mysqli_query($GLOBALS['db'], "UPDATE `konta` SET `exp`=`exp`+".$_POST['exp']." WHERE `id`=".$user -> get['id']);
					echo '<div class="komunikat_w komgreen">Zyskałeś nowe doświadczenie, otrzymujesz '.$_POST['exp'].' EXP</div>';
				}
			}
?>