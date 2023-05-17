<?php
require_once('head.php');

$fontwielkosc = 'font-size: 32px; color: #55a;';
$fontwielkosc1 = '32px';
$wielkosc = '140px';
$wielkosc_tla = '160px';

$tab_pic = 200;
$tab_pic_height = 287;
$tab_pic_margin = 10;
$tab_text = 610-$tab_pic-$tab_pic_margin;

$opis_size = 14;
?>

 <div class="post">
     <div class="postheader"><h1><?php echo $user -> get['login'] ?></h1></div>
	<div class="postcontent">
		<center>
		<br />

		<div class="tabs">
			<h3 class="tab-title">Wybierz klasę</h3><br />
			<a href="#paladyn">Paladyn</a>
			<a href="#wojownik">Wojownik</a>
			<a href="#rzezimieszek">Rzezimieszek</a>
			<!--<a href="#tab4">Strażnik</a>-->
		</div>

		<div style="display: none;" id="tabs-container" class="tabs-container">
			<article id="paladyn" class="tab-content">
				<div class="tab-text">
					<table style="padding-right: 10px; padding-left: 10px;">
					  <tr>
						<td style="width: <?php echo $tab_pic; ?>px;"></td>
						<td style="width: <?php echo $tab_text; ?>px;"><h3 style="text-align: left;" class="tab-title">Paladyn</h3></td>
					  </tr>
					  <tr>
						<td style="width: <?php echo $tab_pic; ?>px;" rowspan="6"><div style="margin-right: <?php echo $tab_pic_margin; ?>px; width: <?php echo $tab_pic; ?>px;height: <?php echo $tab_pic_height; ?>px;background: url('images/klasy/paladyn.png');"></div></td>
						<td style="text-align: justify; font-size: <?php echo $opis_size; ?>px; width: <?php echo $tab_text; ?>px;"><b>Paladyni</b> to elitarni wojownicy w służbie Innosa. Służą bezpośrednio królowi Myrtany. Władają magią, używając run ofensywnych i uzdrawiających. Niżsi rangą paladyni nazywani są rycerzami. Nie wiadomo kiedy dokładnie powstał zakon paladynów, możemy się jednak domyślać, iż założył go pierwszy król Myrtany najprawdopodobniej z nakazu Innosa. </td>
					  </tr>
					  <tr>
						<td style="width: <?php echo $tab_text; ?>px;">Siła: <span style="color: green">+10%</span></td>
					  </tr>
					  <tr>
						<td style="width: <?php echo $tab_text; ?>px;">Obrona: <span style="color: green">+10%</span></td>
					  </tr>
					  <tr>
						<td style="width: <?php echo $tab_text; ?>px;">Zręczność: <span style="color: red">-20%</span></td>
					  </tr>
					  <tr>
						<td style="width: <?php echo $tab_text; ?>px;"><a style="text-align: center;" href="postac.php">Wybierz</a></td>
					  </tr>
					  <tr>
						<td style="width: <?php echo $tab_text; ?>px;"></td>
					  </tr>
					</table>
				</div>
			</article>
			<article id="wojownik" class="tab-content">
				<div class="tab-text">
					<table style="padding-right: 10px; padding-left: 10px;">
					  <tr>
						<td style="width: <?php echo $tab_pic; ?>px;"></td>
						<td style="width: <?php echo $tab_text; ?>px;"><h3 style="text-align: left;" class="tab-title">Wojownik</h3></td>
					  </tr>
					  <tr>
						<td style="width: <?php echo $tab_pic; ?>px;" rowspan="6"><div style="margin-right: <?php echo $tab_pic_margin; ?>px; width: <?php echo $tab_pic; ?>px; height: <?php echo $tab_pic_height; ?>px;background: url('images/klasy/wojownik.png');"></div></td>
						<td style="text-align: justify; font-size: <?php echo $opis_size; ?>px; width: <?php echo $tab_text; ?>px;"><b>Wojownicy</b> należą do jednej z pięciu pradawnych kast, urzędujących niegdyś w Jarkendarze. Zajmowali się bronieniem miasta i jego mieszkańców. Wchodzili w skład rady pięciu razem z Uzdrowicielami, Uczonymi, Strażnikami Umarłych i Kapłanami. Ich przywódcą był Quarhodron, który po wygranej bitwie poza murami miasta zdobył Szpon Beliara.</td>
					  </tr>
					  <tr>
						<td style="width: <?php echo $tab_text; ?>px;">Siła: <span style="color: green">+20%</span></td>
					  </tr>
					  <tr>
						<td style="width: <?php echo $tab_text; ?>px;">Obrona: <span style="color: red">-5%</span></td>
					  </tr>
					  <tr>
						<td style="width: <?php echo $tab_text; ?>px;">Zręczność: <span style="color: red">-15%</span></td>
					  </tr>
					  <tr>
						<td style="width: <?php echo $tab_text; ?>px;"><a style="text-align: center;" href="postac.php">Wybierz</a></td>
					  </tr>
					  <tr>
						<td style="width: <?php echo $tab_text; ?>px;"></td>
					  </tr>
					</table>
				</div>
			</article>
			<article id="rzezimieszek" class="tab-content"> <!--- Opis i obrazek http://marant.tawerna-gothic.pl/index.php?topic=26023.0--->
				<div class="tab-text">
					<table style="padding-right: 10px; padding-left: 10px;">
					  <tr>
						<td style="width: <?php echo $tab_pic; ?>px;"></td>
						<td style="width: <?php echo $tab_text; ?>px;"><h3 style="text-align: left;" class="tab-title">Rzezimieszek</h3></td>
					  </tr>
					  <tr>
						<td style="width: <?php echo $tab_pic; ?>px;" rowspan="6"><div style="margin-right: <?php echo $tab_pic_margin; ?>px; width: <?php echo $tab_pic; ?>px;height: <?php echo $tab_pic_height; ?>px;background: url('images/klasy/rzezimieszek.png');"></div></td>
						<td style="text-align: justify; font-size: <?php echo $opis_size; ?>px; width: <?php echo $tab_text; ?>px;"><b>Rzezimieszkiem</b> nazywa siebie każdy kto potrafi w minimalnym stopniu posługiwać się bronią typową dla zabójców. Znani są oni również już z umiejętności szybkiej ucieczki. Poza tym warto uważać w towarzystwie takiego człowieka, gdyż z łatwością jest on w stanie pozbawić cię paru grzywien czy nawet całego mieszka.</td>
					  </tr>
					  <tr>
						<td style="width: <?php echo $tab_text; ?>px;">Siła: <span style="color: red">-15%</span></td>
					  </tr>
					  <tr>
						<td style="width: <?php echo $tab_text; ?>px;">Obrona: <span style="color: red">-5%</span></td>
					  </tr>
					  <tr>
						<td style="width: <?php echo $tab_text; ?>px;">Zręczność: <span style="color: green">+20%</span></td>
					  </tr>
					  <tr>
						<td style="width: <?php echo $tab_text; ?>px;"><a style="text-align: center;" href="postac.php">Wybierz</a></td>
					  </tr>
					  <tr>
						<td style="width: 380px;"></td>
					  </tr>
					</table>
				</div>
			</article>
		</div>
		<script src="zakladki/zakladki.js"></script>
		<link href="zakladki/zakladki.css" rel="stylesheet" />
		</center>

		<br />
		<table style="margin: 0 auto;">
			<tr>
				<?php
				$file_name = 'images/av_graczy/'.$user -> get['login'].'_av.png';
				if ($user -> get['awatar_domyslny'] == 1)
				{
					if (file_exists($file_name))
					{
						echo '<th style="padding-bottom: 5px;" rowspan="3">
						<div style="background: url(images/bck.png) no-repeat center center; background-size: '.$wielkosc_tla.' '.$wielkosc_tla.'; position: relative; width:'.$wielkosc.'; height:'.$wielkosc.';" >
						<img style="margin: auto; position: absolute; top: 0; left: 0; bottom: 0; right: 0;max-width: '.$wielkosc.'; max-height: '.$wielkosc.';" src="'.$file_name.'?'.filemtime($file_name).'" />
						<img draggable="false" style="position: relative; max-width: '.$wielkosc.'; max-height: '.$wielkosc.';" src="images/awatary/ramka.png" />
						</div>';
					}
					else
					{
					echo '<img height="'.$wielkosc.'" src="images/awatary/DefAV.png" alt="member" />';
					mysqli_query($GLOBALS['db'], "UPDATE `konta` SET `awatar_domyslny`=0 WHERE `id`=".$user -> get['id']);	
					} 
				}
				else
				{
					echo '<th rowspan="3">';
					switch ($user -> get['awatar_domyslny'])
					{
						case 0: $awatar = 'DefAV.png'; break;
						case 2: $awatar = 'cien.png'; break;
						case 3: $awatar = 'szkodnik.png'; break;
						case 4: $awatar = 'nowicjusz.png'; break;
						default: $awatar = 'DefAV.png'; break;
					}
					echo '<img draggable="false" style="width: '.$wielkosc.'; height: '.$wielkosc.';" src="images/awatary/'.$awatar.'" alt="member" />';
				}
				?>
				</th>
				<th style="padding-left: 10px; text-align:left; vertical-align:top;">
					<span>
					<font style="font-size: <?php echo $fontwielkosc1 ?>;">
					<?php $oboz = mysqli_fetch_array(mysqli_query($GLOBALS['db'], "SELECT * FROM `frakcje` WHERE `id`='".$user -> get['oboz_id']."'")); if($oboz == true) {echo '['.$oboz['skrot_frakcji'].'] ';} echo $user -> get['login']; ?>
					</font>
					</span>
				</th>
			</tr>
			<tr>
				<td style="padding-left: 10px; text-align:left; vertical-align:top;">
					<span><font style="font-style: italic; font-size: <?php echo $fontwielkosc1 ?>;"><?php $szukanie_gracz = false; include('includes/ranga.php'); ?></font></span>
				</td>
			</tr>
			<tr>
				<td style="padding-left: 10px; text-align:left; vertical-align:top;">
					<span><font style="font-size: <?php echo $fontwielkosc1 ?>;">Poziom: </font><font style="<?php echo $fontwielkosc ?>"><?php echo $user -> get['lvl']; ?></font></span>
				</td>
			</tr>
			<tr>
				<td colspan="2" style="text-align:center; vertical-align:top;">
				Atak: <font style="<?php echo $fontwielkosc ?>"><?php echo $user -> get['atak']; ?></font> Obrona: <font style="<?php echo $fontwielkosc ?>"><?php echo $user -> get['obrona']; ?></font> Szybkość: <font style="<?php echo $fontwielkosc ?>"><?php echo $user -> get['szybkosc']; ?></font>
				</td>
			</tr>
		</table>
		<br />
		<?php
			$szpan = time() - 400;
			$online = mysqli_num_rows(mysqli_query($GLOBALS['db'], "SELECT `id` FROM `konta` WHERE `online`>=".$szpan));
			echo '<a style="margin-right: 15px; float: right; font-size: 17px; font-weight: normal; color: #E5E4E2;" href="online.php">Online: <b>'.$online.'</b></a>';
		?>
    </div>
    <div class="postfooter"></div>
</div>
	
<?php
require_once('bottom.php');
?>