<?php 
include ('ustawienia.php');

ob_start();
    include('formularz.php');
    $formularz = ob_get_contents();
ob_end_clean();


function wyswietl_forme($komunikat='') {
	global $formularz;
	
	$do_zmiany = array(
		'#komunikat#',
		'#strona#',
		'#nick#',
		'#mail#',
		'#temat#',
		'#tresc#'
	);
	$zmien_na = array(
		$komunikat,
		$_SERVER['REQUEST_URI'],
		$_POST['nick'],
		$_POST['mail'],
		$_POST['temat'],
		$_POST['tresc']
	);
	
	$formularz = str_replace ( $do_zmiany, $zmien_na, $formularz);
	
	return $formularz;	
}


function waliduj() {
	global $komunikat;
	global $valid;
	
	if( $valid['nick'] > 0 ) {
		if(strlen($_POST['nick']) < $valid['nick'] ){
			$walidacja['nick'] = $komunikat['nick']; 
		}
	}
	
	if( $valid['mail'] == 1 ) {
		if(!filter_var($_POST['mail'],FILTER_VALIDATE_EMAIL)) {
			$walidacja['mail'] =  $komunikat['mail'];
		}
	}
	
	if( $valid['temat'] > 0 ) {
		if(strlen($_POST['temat']) < $valid['temat'] ){
			$walidacja['temat'] = $komunikat['temat']; 
		}
	}
	
	if( $valid['tresc'] > 0 ) {
		if(strlen($_POST['tresc']) < $valid['tresc'] ){
			$walidacja['tresc'] = $komunikat['tresc']; 
		}
	}
	
	if(empty($walidacja)) {
		return 'true';
	}else{
		return $walidacja;
	}
	
}

// Działanie
if (($_SERVER['REQUEST_METHOD'] == 'POST')) {// wejście postem
		$walidacja = waliduj();
		
		if ($walidacja == 'true'){ //poprawnie wypełniony formularz
			print '<div id="sukces"><p>'.$komunikat['sukces'].'</p></div>';
			mysqli_query($GLOBALS['db'], "INSERT INTO `zgloszenia` (`nick`, `email`, `temat`, `tresc`) VALUES ('".$_POST['nick']."', '".$_POST['mail']."', '".$_POST['temat']."', '".$_POST['tresc']."')");
		}
		else{
			//błędna walidacja
			$blad_walidacji = $walidacja;
			
			$blad_walidacji = '
					<div id="blad">
						<p>'.$komunikat['blad'].'</p>
						<ul>
						';
			foreach ($walidacja as $wpis) {
				$blad_walidacji .= '<li>'.$wpis.'</li>';
			}	
			$blad_walidacji .= '
						</ul>
					</div> <br />
					';
					
			print wyswietl_forme($blad_walidacji);
		}	
	
}else{
	// nowe wejście
	print wyswietl_forme();
}






?>