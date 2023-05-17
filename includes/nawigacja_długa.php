<?php
	if(isset($nawigacja) && $nawigacja == 1)
	{
		unset($_SESSION['poradnik']);
		unset($_SESSION['postac']);
		unset($_SESSION['mail']);
		unset($_SESSION['walka']);
		unset($_SESSION['trening']);
		unset($_SESSION['klasztor']);
		unset($_SESSION['karczma']);
		unset($_SESSION['sklep']);
		unset($_SESSION['ekwipunek']);
		unset($_SESSION['praca']);
		unset($_SESSION['ranking']);
		unset($_SESSION['obozy']);
		unset($_SESSION['admin']);
		unset($_SESSION['zgloszenia']);
		unset($_SESSION['opcje']);
	}
	else
	{
		require_once('../common/session.php');
		require_once('../common/config.php');
		require_once('../common/user.php');
	}
	
	$num_mail2 = mysqli_query($GLOBALS['db'], "SELECT * FROM `mail` WHERE `owner`=".$user -> get['id']." AND `type`='odebrane' AND `przeczytane`='0'");
	$num_mail = mysqli_num_rows($num_mail2);
	if ($num_mail == 0) $mail = ' ['.$num_mail.']';
	else $mail = ' [<span style="color: gold; !important">'.$num_mail.'</span>]';
	
	if ($user -> get['pkt'] == 0) $nauka = '';
	else $nauka = ' [<span style="color: gold; !important">'.$user -> get['pkt'].'</span>]';

	$zgloszenia1 = mysqli_query($GLOBALS['db'], "SELECT * FROM `zgloszenia` WHERE `przeczytane`=0 AND `archiwum`=0");
	$zgloszenia1 = mysqli_num_rows($zgloszenia1);
	if ($zgloszenia1 == 0) $zgloszenia = '['.$zgloszenia1.']';
	else $zgloszenia = '[<span style="color: gold; !important">'.$zgloszenia1.'</span>]';

	$czat_najwyzsze2 = mysqli_query($GLOBALS['db'], "SELECT id FROM `chat` ORDER BY `id` DESC LIMIT 1");
	while($czat_najwyzsze = mysqli_fetch_object($czat_najwyzsze2))
	{
		$czat_najwyzszy_id = $czat_najwyzsze -> id;
		if ($user -> get['czat_przeczytane'] < $czat_najwyzszy_id)
		{
			$nieprzeczytane = 'style="color: red;"';
		} else $nieprzeczytane = '';
	}
	
	$oboz_gracza = mysqli_fetch_array(mysqli_query($GLOBALS['db'], "SELECT `skrot_frakcji` FROM `frakcje` WHERE `id`='".$user -> get['oboz_id']."'"));
	if($oboz_gracza == true)
	{
		$oboz_url = '?oboz='.$oboz_gracza['skrot_frakcji'];
	} else $oboz_url = '';

echo '<ul>';
$nav_lista = array(
'poradnik',
'postac',
'mail',
'walka',
'trening',
'klasztor',
'karczma',
'sklep',
'ekwipunek',
'praca',
'ranking',
'obozy',
'admin',
'zgloszenia',
'opcje',
);
$nazwa_lista = array(
'Poradnik',
'Postać',
'Poczta',
'Arena',
'Trening',
'Klasztor',
'Karczma',
'Sklep',
'Ekwipunek',
'Praca',
'Ranking',
'Obozy',
'Panel Admina',
'Zgłoszenia',
'Ustawienia',
);
$prefix_lista = array(
'',
'',
'',
'',
'',
'',
'',
'',
'',
'',
'',
'',
'<br />',
'',
'<br />'
);
$znacznik_lista = array(
'',
'',
'',
'',
'',
'',
'',
'',
'',
'',
'',
'',
'',
'',
''
);
$suffix_lista = array(
'',
'',
$mail,
'',
$nauka,
'',
'',
'',
'',
'',
'',
'',
'',
'',
''
);
$poznacznik_lista = array(
'',
'<br />',
'',
'',
'',
'',
'',
'',
'',
'',
'',
'',
'',
'',
''
);

$nav_liczba = count($nav_lista);

for($x = 0; $x < $nav_liczba; $x++)
{
	if(!isset($nazwa_lista[$x])) {$nazwa_lista[$x] = '_';}
	if(!isset($prefix_lista[$x])) {$prefix_lista[$x] = '';}
	if(!isset($znacznik_lista[$x])) {$znacznik_lista[$x] = '';}
	if(!isset($suffix_lista[$x])) {$suffix_lista[$x] = '';}
	if(!isset($poznacznik_lista[$x])) {$poznacznik_lista[$x] = '';}
	
	if($_SERVER['PHP_SELF'] == '/'.$nav_lista[$x].'.php' || isset($_SESSION[$nav_lista[$x]]))
	{
		if($nav_lista[$x] != 'postac')
		{
			
		}
		echo $prefix_lista[$x].'<li><a '.$znacznik_lista[$x].' class="phpself" href="'.$nav_lista[$x].'.php">'.$nazwa_lista[$x].''.$suffix_lista[$x].'</a></li>'.$poznacznik_lista[$x];
		$_SESSION[$nav_lista[$x]] = $_SERVER['PHP_SELF'];
	} else echo $prefix_lista[$x].'<li><a '.$znacznik_lista[$x].' href="'.$nav_lista[$x].'.php">'.$nazwa_lista[$x].''.$suffix_lista[$x].'</a></li>'.$poznacznik_lista[$x];
}


echo '<li><a href="index.php?wyloguj">Wyloguj</a></li><br />';
echo '</ul>';
?>
