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

	${$_SERVER['PHP_SELF']} = 'phpself';
	
echo '<ul>';
if(!isset($_POST['php_self'])) {$_POST['php_self'] = '';}
	
if ($user -> get['poradnik'] == '0')
{
	echo '<li><a class="'.${$_SERVER['PHP_SELF']}.'" style="color: gold;" href="poradnik.php">Poradnik</a></li>';
}

echo '<li><a class="'.${$_SERVER['PHP_SELF']}.'" href="postac.php">Postać</a></li><br />';
echo '<li><a class="'.${$_SERVER['PHP_SELF']}.'" href="mail.php">Poczta'.$mail.'</a></li>';
echo '<li><a class="'.${$_SERVER['PHP_SELF']}.'" href="walka.php">Arena</a></li>';
echo '<li><a class="'.${$_SERVER['PHP_SELF']}.'" href="trening.php">Trening'.$nauka.'</a></li>';
echo '<li><a class="'.${$_SERVER['PHP_SELF']}.'" href="klasztor.php">Klasztor</a></li>';
echo '<li><a class="'.${$_SERVER['PHP_SELF']}.'" '.$karczma.' href="karczma.php">Karczma</a></li>';
echo '<li><a class="'.${$_SERVER['PHP_SELF']}.'" href="sklep.php">Targowisko</a></li>';
echo '<li><a class="'.${$_SERVER['PHP_SELF']}.'" href="ekwipunek.php">Ekwipunek</a></li>';
echo '<li><a class="'.${$_SERVER['PHP_SELF']}.'" href="praca.php">Praca</a></li>';
echo '<li><a class="'.${$_SERVER['PHP_SELF']}.'" href="ranking.php">Ranking</a></li>';
echo '<li><a class="'.${$_SERVER['PHP_SELF']}.'" href="obozy.php'.$oboz_url.'">Obozy</a></li><br />';

if ($user -> get['rank'] == 'Admin' || $user -> get['rank'] == 'Moderator')
{
	if ($user -> get['rank'] == 'Admin')
	{
		echo '<li><a class="'.${$_SERVER['PHP_SELF']}.'" href="admin.php">Panel admina</a></li>';
	}
		echo '<li><a class="'.${$_SERVER['PHP_SELF']}.'" href="zgloszenia.php">Zgłoszenia '.$zgloszenia.'</a></li><br />';
}

echo '<li><a class="'.${$_SERVER['PHP_SELF']}.'" href="opcje.php">Ustawienia</a></li>';
echo '<li><a href="index.php?wyloguj">Wyloguj</a></li><br />';
echo '</ul>';
?>
