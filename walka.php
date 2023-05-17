<?php
require_once('head.php');
?>

<div class="post">
    <div class="postheader"><h1>Arena</h1></div>
	<div class="postcontent">
	<div class="postbg" style="background: url(images/tla_strony/arena.jpg);"></div>
	<div class="postbreak"></div>
<?php
if (!isset($_GET['enemy'])) /*Panel wyboru przeciwnika */
{
    $enemys = mysqli_query($GLOBALS['db'], "SELECT * FROM `enemy` ORDER BY `atak` ASC");
    if(mysqli_num_rows($enemys) > 0) 
    {
        while($i = mysqli_fetch_object($enemys)) 
        {
			$bron2 = mysqli_fetch_array(mysqli_query($GLOBALS['db'], 'SELECT `id_broni`,`id` FROM `ekwipunek` WHERE `owner`='.$user -> get['id'].' AND `stan`=1'));
			$bron = mysqli_fetch_array(mysqli_query($GLOBALS['db'], 'SELECT `atak` FROM `sklep` WHERE `id`='.$bron2['id_broni']));

			$atak_gracz1 = round(0.6 * ($user -> get['szybkosc']), 0);
			$atak_gracz2 = $user -> get['atak'] + $bron['atak'];
			$atak_gracz3 = $atak_gracz1 * $atak_gracz2;
			$atak_gracz4 = $atak_gracz3 * 100;
			$obrona_wrog1 = round(1.15 * ($i -> szybkosc), 0);
			$obrona_wrog2 = $i -> obrona;
			$obrona_wrog3 = $obrona_wrog1 * $obrona_wrog2;
			$szansa_na_atak = $atak_gracz4 / $obrona_wrog3;
			
			/* echo $atak_gracz1.' - 6/10 szybkość gracza, zaokrąglona <br />';
			echo $atak_gracz2.' - siła i broń, czyli broń "'.$bron['atak'].'" i siła '.$user -> get['atak'].'<br />';
			echo $atak_gracz3.' - mnożenie ataku i szybkości<br />';
			echo $atak_gracz4.' - mnożenie razy 100%<br />';
			echo $obrona_wrog1.' - 115% szybkości wroga, zaokrąglona <br />';
			echo $obrona_wrog2.' - obrona wroga<br />';
			echo $obrona_wrog3.' - mnożenie szybkości i obrony wroga<br /><br />'; */
			
			// $szansa_na_atak = round(0.6 * ($bron['atak']), 0) + round(0.7 * ($user -> get['atak']), 0) + round(0.15 * ($user -> get['szybkosc']), 0) - round(0.15 * ($i -> szybkosc), 0) - round(0.8 * ($i -> obrona), 0);
			if ($szansa_na_atak <= 0)
			{
				$wygrana = 0;
			}
			else if ($szansa_na_atak >= 100)
			{
				$wygrana = 100;
			} 
			else $wygrana = round($szansa_na_atak, 0);
			
			$atak_wrog1 = round(0.6 * ($i -> szybkosc), 0);
			$atak_wrog2 = $i -> atak;
			$atak_wrog3 = $atak_wrog1 * $atak_wrog2;
			$atak_wrog4 = $atak_wrog3 * 100;
			$obrona_gracz1 = round(1.15 * ($user -> get['szybkosc']), 0);
			$obrona_gracz2 = $user -> get['obrona'];
			$obrona_gracz3 = $obrona_gracz1 * $obrona_gracz2;
			$szansa_na_obrone = $atak_wrog4 / $obrona_gracz3;
			
			/* echo $atak_wrog1.' - 6/10 szybkość wroga, zaokrąglona <br />';
			echo $atak_wrog2.' - siła wroga <br />';
			echo $atak_wrog3.' - mnożenie ataku i szybkości <br />';
			echo $atak_wrog4.' - mnożenie razy 100%<br />';
			echo $obrona_gracz1.' - 115% szybkości gracza, zaokrąglona <br />';
			echo $obrona_gracz2.' - obrona gracza<br />';
			echo $obrona_gracz3.' - mnożenie szybkości i obrony gracza<br />'; */
			
			// $szansa_na_obrone = round(0.15 * ($user -> get['szybkosc']), 0) + round(0.8 * ($user -> get['obrona']), 0) - round(0.7 * ($i -> atak), 0) - round(0.15 * ($i -> szybkosc), 0);
			if ($szansa_na_obrone <= 0)
			{
				$szansa_wygrana = 0;
			}
			else if ($szansa_na_obrone >= 100)
			{
				$szansa_wygrana = 100;
			}
			else $szansa_wygrana =  round($szansa_na_obrone, 0);

			echo '<table style="margin: 0px auto;">
				  <tr>
					<th style="padding-right: 20px;" rowspan="5">';

					$fontwielkosc = 'font-size: 32px; color: #55a;';
					$fontwielkosc1 = 'font-size: 32px;';
					$wielkosc = '140px';
					$wielkosc2 = '135px';
					$wielkosc_tla = '140px';
				
					$file_name = 'images/awatary/walka/'.$i -> awatar.'.jpg';
					if (file_exists($file_name))
					{
						echo '
						<div style="background: url(images/bck.png) no-repeat center 5px; background-size: '.$wielkosc_tla.' '.$wielkosc_tla.'; position: relative; width:'.$wielkosc.'; height:'.$wielkosc.';" >
						<img style="margin: auto; position: absolute; top: 10px; left: 0; bottom: 0; right: 0;max-width: '.$wielkosc.'; max-height: '.$wielkosc.';" src="'.$file_name.'" />
						</div>
						<img draggable="false" style="position: relative; margin-top: -'.$wielkosc2.'; max-width: '.$wielkosc.'; max-height: '.$wielkosc.';" src="images/awatary/ramka.png" />';
					}
					else
					{
					echo '<img height="'.$wielkosc.'" src="images/awatary/DefAV.png" alt="member" />';
					}
			echo '</th>
					<th style="font-style: italic; padding-bottom: 10px;">'.$i -> name.'</th>
					<th></th>
				  </tr>
				  <tr>
					<td style="width: 275px;">Atak</td>
					<td>'.$i -> atak.'</td>
				  </tr>
				  <tr>
					<td style="width: 275px;">Szybkość</td>
					<td>'.$i -> szybkosc.'</td>
				  </tr>
				  <tr>
					<td style="width: 275px;">Obrona</td>
					<td>'.$i -> obrona.'</td>
				  </tr>
				  <tr>
					<td style="width: 275px;">Szansa na atak</td>
					<td>'.$wygrana.'%</td>
				  </tr>
				  <tr>
					<td></td>
					<td style="width: 275px;">Szansa na atak wroga</td>
					<td>'.$szansa_wygrana.'%</td>
				  </tr>
				  <tr>
					<td></td>
					<td style="color: whitesmoke;"><a style="color: gold; font-size: 25px" href="walka.php?enemy='.$i -> id.'">Atakuj</a></td>
					<td></td>
				  </tr>
				</table> <br />';
        }
    }
}

if (isset($_GET['enemy'])) /*Panel walki z przeciwnikiem */
{
    if (!preg_match("/^[0-9]*$/", $_GET['enemy']))
    {
        echo '<span style="color:red;">Nie ma takiego potwora.</span>';
    }
    else if ($user -> get['hp'] == 1) 
    {
        echo '<span style"color:red;">Nie jesteś w stanie walczyć!</span>';
    }
    else if ($user -> get['zmeczenie'] == $user -> get['max_zmeczenie'])
    {
        echo '<span style="color:red;">Jesteś zbyt zmęczony, aby walczyć.</span>';
    }
        else
    { /* Skrypt walki */
		$coinflip = rand(1, 2);
		$tura = 1;
		$bron2 = mysqli_fetch_array(mysqli_query($GLOBALS['db'], 'SELECT `id_broni`,`id` FROM `ekwipunek` WHERE `owner`='.$user -> get['id'].' AND `stan`=1'));
		$bron = mysqli_fetch_array(mysqli_query($GLOBALS['db'], 'SELECT `atak` FROM `sklep` WHERE `id`='.$bron2['id_broni']));
        $enemy = mysqli_fetch_object(mysqli_query($GLOBALS['db'], "SELECT * FROM `enemy` WHERE `id`=".$_GET['enemy']));

        $enemy_hp = $enemy -> hp;
        $my_hp = $user -> get['hp'];

		$atak_ogolny = $user -> get['atak'] + $bron['atak'];
		$atak_ogolny_wroga = $enemy -> atak;
		
		$szansa_atak1 = round(0.6 * ($bron['atak']), 0) + round(0.7 * ($user -> get['atak']), 0) + round(0.15 * ($user -> get['szybkosc']), 0) - round(0.15 * ($enemy -> szybkosc), 0) - round(0.8 * ($enemy -> obrona), 0);
		if ($szansa_atak1 <= 5) {
			$szansa_atak = 5;
		}
		else if ($szansa_atak1 >= 95)
		{
			$szansa_atak = 95;
		}
		else $szansa_atak = $szansa_atak1;

		$szansa_obrona1 = round(0.15 * ($user -> get['szybkosc']), 0) + round(0.8 * ($user -> get['obrona']), 0) - round(0.7 * ($enemy -> atak), 0) - round(0.15 * ($enemy -> szybkosc), 0);
		if ($szansa_obrona1 <= 5) {
			$szansa_obrona = 5;
		}
		else if ($szansa_obrona1 >= 95)
		{
			$szansa_obrona = 95;
		}
		else $szansa_obrona = $szansa_obrona1;

		if ($coinflip == 1) /* Coinflip */
		{
			echo '<span style="color:yellow;">Wróg zaczyna walkę</span><br />';
		}
		else echo '<span style="color:green;">Rozpoczynasz walkę</span><br />';
		
		while ($tura > 0) /* Tury */
        {
			echo '<br />Tura '.$tura.'<br />';
			$rand1 = rand(1, 100);
			$rand2 = rand(1, 100);

			if ($coinflip == 1)
			{
				if ($rand1 <= $szansa_obrona)
				{
					echo 'Uniknąłeś ciosu przeciwnika<br />';
				}
				else
				{
					$my_hp = $my_hp - $atak_ogolny_wroga;
					echo 'Przeciwnik atakuje i zadaje Ci obrażenia: '.$atak_ogolny_wroga.'.<br />';
					mysqli_query($GLOBALS['db'], "UPDATE `konta` SET `hp` = `hp`  - '".$atak_ogolny_wroga."' WHERE id=".$user -> get['id']);	
				}
				
				if ($my_hp <= 0)
				{
					echo '<span style="color:red;">Nie jesteś w stanie walczyć. Przegrywasz...</span><br />';
				}
				else
				{
					if ($rand2 <= $szansa_atak)
					{
						$enemy_hp = $enemy_hp - $atak_ogolny;
						echo 'Wykorzystujesz szansę i zadajesz przeciwnikowi obrażenia: '.$atak_ogolny.'.<br />';
					}
					else
					{
						echo 'Nie udało Ci się wykonać kontrataku.<br />';
					}
				}
				
				if ($enemy_hp <= 0) 
				{
					echo '<span style="color:green;">Przeciwnik padł na ziemię. Wygrywasz!</span><br />';
				}

				$coinflip = 0;
				
			}
			else
			{
				if ($rand1 <= $szansa_atak)
				{
					$enemy_hp = $enemy_hp - $atak_ogolny;
					echo 'Atakujesz i zadajesz przeciwnikowi obrażenia: '.$atak_ogolny.'.<br />';
				}
				else
				{
					echo 'Przeciwnik uniknął twojego ataku.<br />';
				}
				
				if ($enemy_hp <= 0) 
				{
					echo '<span style="color:green;">Przeciwnik padł na ziemię. Wygrywasz!</span><br />';
				}
				else
				{
					if ($rand2 <= $szansa_obrona)
					{
						echo 'Przeciwnikowi nie udało się wykonać kontrataku.<br />';
					}
					else
					{
						$my_hp = $my_hp - $atak_ogolny_wroga;
						echo 'Przeciwnik kontratakuje i zadaje Ci obrażenia: '.$atak_ogolny_wroga.'.<br />';
						mysqli_query($GLOBALS['db'], "UPDATE `konta` SET `hp` = `hp`  - '".$atak_ogolny_wroga."' WHERE id=".$user -> get['id']);
					}
				}

				if ($my_hp <= 0)
				{
					echo '<span style="color:red;">Nie jesteś w stanie walczyć. Przegrywasz...</span><br />';
				}

				$coinflip = 1;
				
			}
			
			echo '<br />';
			$tura++;

			if ($tura == 21)    
			{ 
				$tura = 0;
				echo '<span style="color:yellow;">Walka nierozstrzygnięta. Czas na walkę minął.</span>'; 
			}
            else if ($my_hp <= 0)
            {
                $tura = 0;
                if ($user -> get['kasa'] <= $enemy -> kasa)
                {
                    mysqli_query($GLOBALS['db'], "UPDATE `konta` SET `kasa`=0 WHERE `id`=".$user -> get['id']);  
                    $kasa = 'cały swój majątek';                    
                }
				else
                {
                    mysqli_query($GLOBALS['db'], "UPDATE `konta` SET `kasa`=`kasa`-".$enemy -> kasa." WHERE `id`=".$user -> get['id']);
                    $kasa = $enemy -> kasa.' $';
                }
                echo '<span style="color:red;">Przegrywasz pojedynek. Tracisz '.$kasa.'</span>';
				mysqli_query($GLOBALS['db'], "UPDATE `konta` SET `hp`=1 WHERE id=".$user -> get['id']);
            }
            else if ($enemy_hp <= 0) 
            {
                $tura = 0;
                mysqli_query($GLOBALS['db'], "UPDATE `konta` SET `kasa`=`kasa`+".$enemy -> kasa." WHERE `id`=".$user -> get['id']);
                echo '<span style="color:green;">Ludzie głosowali na Ciebie, zdobywasz '.$enemy -> kasa.' $</span>';

                $tura = 0;
                mysqli_query($GLOBALS['db'], "UPDATE `konta` SET `exp`=`exp`+".$enemy -> exp." WHERE `id`=".$user -> get['id']);
                echo '<br><span style="color:green;">Zyskałeś nowe doświadczenie, otrzymujesz'.$enemy -> exp.' EXP</span>';
            }
		}
	}
echo '<br />';
}
?>

		</div>
	<div class="postfooter"></div>
</div>
 
<?php
require_once('bottom.php');
?> 