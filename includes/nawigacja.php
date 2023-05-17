<?php
	if($nawigacja == 1)
	{}
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

echo '<ul>';
if ($user -> get['tuti'] == '0'){
	echo '<li><a style="color: gold;" href="poradnik.php">Poradnik</a></li>';
}

echo '<li><a href="postac.php">Postać</a></li><br />
<li><a href="mail.php">Poczta'.$mail.'</a></li>
<li><a href="walka.php">Arena</a></li>
<li><a href="trening.php">Trening'.$nauka.'</a></li>
<li><a href="klasztor.php">Klasztor</a></li>';

$czat_najwyzsze2 = mysqli_query($GLOBALS['db'], "SELECT id FROM `chat` ORDER BY `id` DESC LIMIT 1");
while($czat_najwyzsze = mysqli_fetch_object($czat_najwyzsze2))
{
	$czat_najwyzszy_id = $czat_najwyzsze -> id;
	if ($user -> get['czat_przeczytane'] < $czat_najwyzszy_id)
	{
		$nieprzeczytane = 'style="color: red;"';
	} else $nieprzeczytane = '';
}
echo '<li><a '.$nieprzeczytane.' href="karczma.php">Karczma</a></li>';

echo '<li><a href="sklep.php">Sklep</a></li>
<li><a href="ekwipunek.php">Ekwipunek</a></li>
<li><a href="praca.php">Praca</a></li>
<li><a href="ranking.php">Ranking</a></li>
<li><a href="obozy.php">Obozy</a></li>

<br />';

if ($user -> get['rank'] == 'Admin')
{
	echo '<li><a href="admin.php">Panel admina</a></li>';
	echo '<li><a href="zgloszenia.php">Zgłoszenia '.$zgloszenia.'</a></li><br />';
}

if ($user -> get['rank'] == 'Moderator')
{
	echo '<li><a href="zgloszenia.php">Zgłoszenia '.$zgloszenia.'</a></li><br />';
}
echo '<li><a href="opcje.php">Ustawienia</a></li>
<li><a href="index.php?wyloguj=ok">Wyloguj</a></li><br />';
echo '</ul>';
?>
