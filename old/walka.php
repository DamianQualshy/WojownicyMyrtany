<?php
require_once('head.php');
?>

<div class="post">
    <div class="postheader"><h1>Arena</h1></div>
	<div class="postcontent">
	<div class="postbg" style="background: url(images/tla_strony/arena.jpg);"></div>
	<div class="postbreak"></div>
<?php
$walka = 1;

if (!isset($_POST['enemy']))
{$walka = 0;}

if (isset($_POST['enemy']))
{
	$enemys = mysqli_fetch_array(mysqli_query($GLOBALS['db'], "SELECT * FROM `enemy` WHERE `id`=".$_POST['enemy']));
    if ($enemys == false)
    {
        echo '<div class="komunikat komred">Nie ma takiego przeciwnika.</div>';
		$walka = 0;
    }
    else if ($user -> get['hp'] <= 1) 
    {
        echo '<div class="komunikat komred">Nie jesteś w stanie walczyć!</div>';
		$walka = 0;
    }
    else if ($user -> get['zmeczenie'] == $user -> get['max_zmeczenie'])
    {
        echo '<div class="komunikat komred">Jesteś zbyt zmęczony, aby walczyć.</div>';
		$walka = 0;
    }
}


if ($walka == 0) /*Panel wyboru przeciwnika */
{
    $enemys = mysqli_query($GLOBALS['db'], "SELECT * FROM `enemy` ORDER BY `atak` ASC");
    if(mysqli_num_rows($enemys) > 0) 
    {
		$bron2 = mysqli_fetch_array(mysqli_query($GLOBALS['db'], 'SELECT `id_broni`,`id` FROM `ekwipunek` WHERE `owner`='.$user -> get['id'].' AND `stan`=1'));
		if ($bron2 == true)
		{
			$bron = mysqli_fetch_array(mysqli_query($GLOBALS['db'], 'SELECT `atak` FROM `sklep` WHERE `id`='.$bron2['id_broni']));
		} else $bron['atak'] = 0;

		$pancerz2 = mysqli_fetch_array(mysqli_query($GLOBALS['db'], 'SELECT `id_zbroi`,`id` FROM `eq_zbroje` WHERE `owner`='.$user -> get['id'].' AND `stan`=1'));
		if ($pancerz2 == true)
		{
			$pancerz = mysqli_fetch_array(mysqli_query($GLOBALS['db'], 'SELECT `obrona` FROM `zbrojmistrz` WHERE `id`='.$pancerz2['id_zbroi']));
		} else $pancerz['obrona'] = 0;
		
        while($i = mysqli_fetch_object($enemys)) 
        {
			
			/* Szansa na trafienie przeciwnika */
			$atak_gracz1 = $user -> get['atak'] + $bron['atak'];
			$atak_gracz2 = $user -> get['szybkosc'] * $atak_gracz1;
			$atak_gracz3 = $atak_gracz2 * 100;
			$obrona_wrog = $i -> szybkosc * $i -> obrona;
			$szansa_na_atak = $atak_gracz3 / $obrona_wrog;

			if ($szansa_na_atak <= 5) {$szansa_atak = 5;}
			else if ($szansa_na_atak >= 95) {$szansa_atak = 95;} 
			else $szansa_atak = round($szansa_na_atak, 0);

			/* echo $user -> get['szybkosc'].' - szybkość gracza<br />';
			echo $atak_gracz1.' - siła i broń, czyli broń "'.$bron['atak'].'" i siła '.$user -> get['atak'].'<br />';
			echo $atak_gracz2.' - mnożenie ataku i szybkości<br />';
			echo $atak_gracz3.' - mnożenie razy 100%<br />';
			echo $i -> szybkosc.' - szybkość wroga<br />';
			echo $i -> obrona.' - obrona wroga<br />';
			echo $obrona_wrog.' - mnożenie szybkości i obrony wroga<br /><br />'; */

			/* Szansa na obronę ciosu */
			$atak_wrog = $i -> szybkosc * $i -> atak;
			$atak_wrog2 = $atak_wrog * 100;
			$obrona_gracz = $user -> get['szybkosc'] * ($user -> get['obrona'] + $pancerz['obrona']);
			$szansa_na_obrone = $atak_wrog2 / $obrona_gracz;

			if ($szansa_na_obrone <= 5){$szansa_obrona = 5;}
			else if ($szansa_na_obrone >= 95){$szansa_obrona = 95;}
			else $szansa_obrona =  round($szansa_na_obrone, 0);

			/* echo $i -> szybkosc.' - szybkość wroga<br />';
			echo $i -> atak.' - siła wroga <br />';
			echo $atak_wrog.' - mnożenie ataku i szybkości <br />';
			echo $atak_wrog2.' - mnożenie razy 100%<br />';
			echo $user -> get['szybkosc'].' - szybkość gracza<br />';
			echo $user -> get['obrona'].' - obrona gracza<br />';
			echo $obrona_gracz.' - mnożenie szybkości i obrony gracza z pancerzem ('.$pancerz['obrona'].' pancerz)<br />'; */
			
			/* Wyświetlanie panelu z przeciwnikiem */
			echo '<table class="lista">
				  <tr>';
					if($i -> awatar == 'DefAV')
					{
						echo '<th rowspan="6" style="padding-left: 15px; padding-right: 15px;">
						<img draggable="false" style="height: 130px;" src="images/awatary/walka/DefAV.jpg" alt="member" />';
					}
					else
					{
						$file_name = 'images/awatary/walka/'.$i -> awatar.'.jpg';
						if (file_exists($file_name))
						{
							echo '<th rowspan="6" class="av" style="padding-right: 15px;">
							<img style="margin: auto; position: absolute; top: 0; left: 0; bottom: 0; right: 0;max-width: 120px; max-height: 120px; margin-top: 10px;" src="'.$file_name.'" />
							<img draggable="false" style="position: relative; margin-top: -25px; max-width: 130px; max-height: 130px; padding-left: 15px" src="images/awatary/ramka.png" />';
						}
						else
						{
							echo '<th rowspan="6" style="padding-left: 15px; padding-right: 15px;">
							<img draggable="false" style="height: 130px;" src="images/awatary/walka/DefAV.jpg" alt="member" />';
						}
					}
			echo '</th>
					<th class="th">'.$i -> name.'</th>
					<th></th>
				  </tr>
				  <tr>
					<td class="one">Atak</td>
					<td class="two">'.$i -> atak.'</td>
				  </tr>
				  <tr>
					<td class="one">Szybkość</td>
					<td class="two">'.$i -> szybkosc.'</td>
				  </tr>
				  <tr>
					<td class="one">Obrona</td>
					<td class="two">'.$i -> obrona.'</td>
				  </tr>
				  <tr>
					<td class="one">---------------------------</td>
					<td class="two"></td>
				  </tr>
				  <tr>
					<td class="one">Szansa na atak</td>
					<td class="two">'.$szansa_atak.'%</td>
				  </tr>
				  <tr>
					<td></td>
					<td class="one">Szansa na trafienie przez wroga</td>
					<td class="two">'.$szansa_obrona.'%</td>
				  </tr>
				  <tr>
					<td></td>
					<td class="one"><form class="inter" method="post" action="walka.php"><input type="hidden" name="enemy" value="'.$i -> id.'" /><input id="wskaz" value="Walka" style="margin-left: -3px; width: 65px; color: gold;" type="submit" /></form></td>
					<td></td>
				  </tr>
				</table> <br />';
        }
    }
}

if ($walka == 1)
{
	if (isset($_POST['enemy'])) /*Panel walki z przeciwnikiem */
	{
		$enemy = mysqli_fetch_object(mysqli_query($GLOBALS['db'], "SELECT * FROM `enemy` WHERE `id`=".$_POST['enemy']));
		if ($enemy == true)
		{ /* Skrypt walki */
			if($enemy -> szybkosc > $user -> get['szybkosc']) /* Kto rozpoczyna walkę */
			{
				$coinflip = 1;
			}
			else if($enemy -> szybkosc == $user -> get['szybkosc'])
			{
				$coinflip = rand(1, 2);
			}
			else $coinflip = 2;
			
			$tura = 0; /* Początkowa tura */
			$niekoniec = 1; /* Trwająca walka */
			
			/* Sprawdzenie czy przeciwnik ma broń i pancerz */
			$bron2 = mysqli_fetch_array(mysqli_query($GLOBALS['db'], 'SELECT `id_broni`,`id` FROM `ekwipunek` WHERE `owner`='.$user -> get['id'].' AND `stan`=1'));
			if ($bron2 == true)
			{
				$bron = mysqli_fetch_array(mysqli_query($GLOBALS['db'], 'SELECT `atak` FROM `sklep` WHERE `id`='.$bron2['id_broni']));
			} else $bron['atak'] = 0;

			$pancerz2 = mysqli_fetch_array(mysqli_query($GLOBALS['db'], 'SELECT `id_zbroi`,`id` FROM `eq_zbroje` WHERE `owner`='.$user -> get['id'].' AND `stan`=1'));
			if ($pancerz2 == true)
			{
				$pancerz = mysqli_fetch_array(mysqli_query($GLOBALS['db'], 'SELECT `obrona` FROM `zbrojmistrz` WHERE `id`='.$pancerz2['id_zbroi']));
			} else $pancerz['obrona'] = 0;

			$enemy_hp = $enemy -> hp; /* HP Przeciwnika */
			$my_hp = $user -> get['hp']; /* HP Gracza */
			$my_maxhp = $user -> get['maxhp']; /* Max HP Gracza */
			$my_zmeczenie = $user -> get['zmeczenie']; /* Zmęczenie gracza */
			$my_maxzmeczenie = $user -> get['max_zmeczenie']; /* Max zmęczenie gracza */

			$atak_ogolny = $user -> get['atak'] + $bron['atak']; /* Atak - siła i atak broni */
			$atak_ogolny_wroga = $enemy -> atak; /* Atak wgora - siłą i atak broni */

			/* Szansa na trafienie przeciwnika */
			$atak_gracz1 = $user -> get['atak'] + $bron['atak'];
			$atak_gracz2 = $user -> get['szybkosc'] * $atak_gracz1;
			$atak_gracz3 = $atak_gracz2 * 100;
			$obrona_wrog = $enemy -> szybkosc * $enemy -> obrona;
			$szansa_na_atak = $atak_gracz3 / $obrona_wrog;

			if ($szansa_na_atak <= 5) {$szansa_atak = 5;}
			else if ($szansa_na_atak >= 95) {$szansa_atak = 95;} 
			else $szansa_atak = round($szansa_na_atak, 0);
			
			/* Szansa na obronę ciosu */
			$atak_wrog = $enemy -> szybkosc * $enemy -> atak;
			$atak_wrog2 = $atak_wrog * 100;
			$obrona_gracz = $user -> get['szybkosc'] * ($user -> get['obrona'] + $pancerz['obrona']);
			$szansa_na_obrone = $atak_wrog2 / $obrona_gracz;

			if ($szansa_na_obrone <= 5){$szansa_obrona = 5;}
			else if ($szansa_na_obrone >= 95){$szansa_obrona = 95;}
			else $szansa_obrona =  round($szansa_na_obrone, 0);
			
			echo '<div id="arena">';
			echo' <script>
				function arena()
				{
					$.ajax
					({
						async: true,
						type: "POST",
						url: "includes/arena.php",
						data: ({niekoniec: "'.$niekoniec.'", szansa_na_obrone: "'.$szansa_obrona.'", szansa_na_obrone2: "'.$szansa_obrona.'", szansa_na_atak: "'.$szansa_atak.'", coinflip: "'.$coinflip.'",tura: "'.$tura.'", enemy_hp: "'.$enemy_hp.'", my_hp: "'.$my_hp.'", my_maxhp : "'.$my_maxhp.'", my_zmeczenie: "'.$my_zmeczenie.'", my_maxzmeczenie: "'.$my_maxzmeczenie.'", atak_ogolny: "'.$atak_ogolny.'", atak_ogolny_wroga: "'.$atak_ogolny_wroga.'", szansa_obrona: "'.$szansa_obrona.'", szansa_atak: "'.$szansa_atak.'", przeciwnik: "'.$_POST['enemy'].'", kasa: "'.$enemy -> kasa.'", exp: "'.$enemy -> exp.'"}),
						success: function (html)
						{
							$("#arena").html(html);		
						}  
					});
				}
				arena();
				</script>';
			echo '</div>';
		}
	echo '<br />';
	}
}
?>
		</div>
	<div class="postfooter"></div>
</div>

<?php
require_once('bottom.php');
?> 