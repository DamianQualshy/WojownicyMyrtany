<?php
	if(isset($nawigacja) && $nawigacja == 1)
	{
	}
	else
	{
		require_once('../common/session.php');
		require_once('../common/config.php');
		require_once('../common/user.php');
	}
	
	$num_mail = mysqli_num_rows(mysqli_query($GLOBALS['db'], "SELECT * FROM `mail` WHERE `owner`=".$user -> get['id']." AND `type`='odebrane' AND `przeczytane`='0'"));
	if ($num_mail == 0) $mail = '';
	else $mail = ' [<span style="color: gold; !important">'.$num_mail.'</span>]';
	
	if ($user -> get['pkt'] == 0) $nauka = '';
	else $nauka = ' [<span style="color: gold; !important">'.$user -> get['pkt'].'</span>]';

	$zgloszenia1 = mysqli_num_rows(mysqli_query($GLOBALS['db'], "SELECT * FROM `zgloszenia` WHERE `przeczytane`=0 AND `archiwum`=0"));
	if ($zgloszenia1 == 0) $zgloszenia = '';
	else $zgloszenia = '[<span style="color: gold; !important">'.$zgloszenia1.'</span>]';

	$karczma = '';
	$czat_najwyzsze2 = mysqli_query($GLOBALS['db'], "SELECT id FROM `chat` ORDER BY `id` DESC LIMIT 1");
	while($czat_najwyzsze = mysqli_fetch_object($czat_najwyzsze2))
	{
		$czat_najwyzszy_id = $czat_najwyzsze -> id;
		if ($user -> get['czat_przeczytane'] < $czat_najwyzszy_id)
		{
			$karczma = 'style="color: red;"';
		}
	}
	
	$oboz_gracza = mysqli_fetch_array(mysqli_query($GLOBALS['db'], "SELECT `skrot_frakcji` FROM `frakcje` WHERE `id`='".$user -> get['oboz_id']."'"));
	if($oboz_gracza == true)
	{
		$oboz_url = '?oboz='.$oboz_gracza['skrot_frakcji'];
	} else $oboz_url = '';

echo '<ul>';
if(!isset($_POST['php_self'])) {$_POST['php_self'] = '';}
	

// **************************************************************************** PORADNIK
if ($user -> get['poradnik'] == '0')
{
	if($_SERVER['PHP_SELF'] == '/dropbox/poradnik.php' || $_POST['php_self'] == '/dropbox/poradnik.php')
	{
		echo '<li><a class="phpself" style="color: gold;" href="poradnik.php">Poradnik</a></li>';
	} else echo '<li><a style="color: gold;" href="poradnik.php">Poradnik</a></li>';
}

// **************************************************************************** Postać
if($_SERVER['PHP_SELF'] == '/dropbox/postac.php' || $_POST['php_self'] == '/dropbox/postac.php')
{
	echo '<li><a class="phpself" href="postac.php">Postać</a></li><br />';
} else echo '<li><a href="postac.php">Postać</a></li><br />';

// **************************************************************************** Podróż
if($_SERVER['PHP_SELF'] == '/dropbox/podroz.php' || $_POST['php_self'] == '/dropbox/podroz.php')
{
	echo '<li><a class="phpself" href="postac.php">Podróż</a></li>';
} else echo '<li><a href="postac.php">Podróż</a></li>';

// **************************************************************************** POCZTA
if($_SERVER['PHP_SELF'] == '/dropbox/mail.php' || $_POST['php_self'] == '/dropbox/mail.php')
{
	echo '<li><a class="phpself" href="mail.php">Poczta'.$mail.'</a></li>';
} else echo '<li><a href="mail.php">Poczta'.$mail.'</a></li>';

// **************************************************************************** ARENA
if($_SERVER['PHP_SELF'] == '/dropbox/walka.php' || $_POST['php_self'] == '/dropbox/walka.php')
{
	echo '<li><a class="phpself" href="walka.php">Arena</a></li>';
} else echo '<li><a href="walka.php">Arena</a></li>';

// **************************************************************************** TRENING
if($_SERVER['PHP_SELF'] == '/dropbox/trening.php' || $_POST['php_self'] == '/dropbox/trening.php')
{
	echo '<li><a class="phpself" href="trening.php">Trening'.$nauka.'</a></li>';
} else echo '<li><a href="trening.php">Trening'.$nauka.'</a></li>';

// **************************************************************************** KLASZTOR
if($_SERVER['PHP_SELF'] == '/dropbox/klasztor.php' || $_POST['php_self'] == '/dropbox/klasztor.php')
{
	echo '<li><a class="phpself" href="klasztor.php">Klasztor</a></li>';
} else echo '<li><a href="klasztor.php">Klasztor</a></li>';

// **************************************************************************** TARGOWISKO
if($_SERVER['PHP_SELF'] == '/dropbox/sklep.php' || $_POST['php_self'] == '/dropbox/sklep.php')
{
	echo '<li><a class="phpself" href="sklep.php">Targowisko</a></li>';
} else echo '<li><a href="sklep.php">Targowisko</a></li>';

// **************************************************************************** EKWIPUNEK
if($_SERVER['PHP_SELF'] == '/dropbox/ekwipunek.php' || $_POST['php_self'] == '/dropbox/ekwipunek.php')
{
	echo '<li><a class="phpself" href="ekwipunek.php">Ekwipunek</a></li>';
} else echo '<li><a href="ekwipunek.php">Ekwipunek</a></li>';

// **************************************************************************** KARZCMA
if($_SERVER['PHP_SELF'] == '/dropbox/karczma.php' || $_POST['php_self'] == '/dropbox/karczma.php')
{
	echo '<li><a class="phpself" '.$karczma.' href="karczma.php">Karczma</a></li>';
} else echo '<li><a '.$karczma.' href="karczma.php">Karczma</a></li>';

// **************************************************************************** PRACA
if($_SERVER['PHP_SELF'] == '/dropbox/praca.php' || $_POST['php_self'] == '/dropbox/praca.php')
{
	echo '<li><a class="phpself" href="praca.php">Praca</a></li>';
} else echo '<li><a href="praca.php">Praca</a></li>';

// **************************************************************************** OBOZY
if($user -> get['lvl'] >= 5)
{
	if($_SERVER['PHP_SELF'] == '/dropbox/obozy.php' || $_POST['php_self'] == '/dropbox/obozy.php')
	{
		echo '<li><a class="phpself" href="obozy.php'.$oboz_url.'">Obozy</a></li>';
	} else echo '<li><a href="obozy.php'.$oboz_url.'">Obozy</a></li>';
}

// **************************************************************************** ZADANIA
if($_SERVER['PHP_SELF'] == '/dropbox/zadania.php' || $_POST['php_self'] == '/dropbox/zadania.php')
{
	echo '<br /><li><a class="phpself" href="zadania.php">Zadania</a></li><br />';
} else echo '<br /><li><a href="zadania.php">Zadania</a></li><br />';



if ($user -> get['rank'] == 'Admin' || $user -> get['rank'] == 'Moderator')
{
	if ($user -> get['rank'] == 'Admin')
	{
		// **************************************************************************** PANEL ADMINA
		if($_SERVER['PHP_SELF'] == '/dropbox/admin.php' || $_POST['php_self'] == '/dropbox/admin.php')
		{
			echo '<li><a class="phpself" href="admin.php">Panel admina</a></li>';
		} else echo '<li><a href="admin.php">Panel admina</a></li>';
	}
	
	// **************************************************************************** ZGŁOSZENIA
	if($_SERVER['PHP_SELF'] == '/dropbox/zgloszenia.php' || $_POST['php_self'] == '/dropbox/zgloszenia.php')
	{
		echo '<li><a class="phpself" href="zgloszenia.php">Zgłoszenia '.$zgloszenia.'</a></li><br />';
	} else echo '<li><a href="zgloszenia.php">Zgłoszenia '.$zgloszenia.'</a></li><br />';
}

// **************************************************************************** RANKING
if($_SERVER['PHP_SELF'] == '/dropbox/ranking.php' || $_SERVER['PHP_SELF'] == '/dropbox/view.php' || $_POST['php_self'] == '/dropbox/ranking.php' || $_POST['php_self'] == '/dropbox/view.php')
{
	echo '<li><a class="phpself" href="ranking.php">Ranking</a></li>';
} else echo '<li><a href="ranking.php">Ranking</a></li>';

// **************************************************************************** USTAWIENIA
if($_SERVER['PHP_SELF'] == '/dropbox/opcje.php' || $_POST['php_self'] == '/dropbox/opcje.php')
{
	echo '<li><a class="phpself" href="opcje.php">Ustawienia</a></li>';
} else echo '<li><a href="opcje.php">Ustawienia</a></li>';


echo '<li><a href="index.php?wyloguj">Wyloguj</a></li><br />';
echo '</ul>';
?>
