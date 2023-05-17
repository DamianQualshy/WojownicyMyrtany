<?php
if (isset($_GET['tuti']))
{
	require_once('common/session.php');
	require_once('common/config.php');
	require_once('common/user.php');
    mysqli_query($GLOBALS['db'], 'UPDATE `konta` SET `tuti`=1 WHERE `id`='.$user -> get['id']);
	header("Location: postac.php");
	exit();
}

require_once('head.php');
?>

<div class="post">
    <div class="postheader"><h1>Tutorial</h1></div>
	<div class="postcontent">
		<br />
		<div style="text-align: center;">
		<h2>Witaj nowy wojowniku!</h2>
		<p style="font-size: 20px">Jak odnaleźć się w świecie Wojowników Myrtany? Bez obawy, nie jest to trudne!</p><br />
		</div>

		<p style="font-size: 25px;"><a style="font-size: 25px;color: gold;" href="walka.php">WALCZ</a> i zdobywaj doświadczenie oraz monety za stoczenie walki na Arenie.</p><br />
		<p style="font-size: 25px;"><a style="font-size: 25px;color: gold;" href="trening.php">Trening</a> czyni mistrza! Rozwijaj swoją postać za Punkty Nauki, które otrzymujesz zdobywając nowy poziom.</p><br />
		<p style="font-size: 25px;">Pozwól swoim ranom szybciej się zagoić w <a style="font-size: 25px;color: gold;" href="klasztor.php">Klasztorze</a> poprzez zakupienie mikstur lub darmowo się podleczyć dzięki modlitwie Magów.</p><br />
		<p style="font-size: 25px;">W <a style="font-size: 25px;color: gold;"href="karczma.php">Karczmie</a> możesz się odprężyć i napić zimnego piwa. Redukujesz dzięki temu poziom zmęczenia.</p><br />
		<p style="font-size: 25px;"><a style="font-size: 25px;color: gold;"href="sklep.php">Sklep</a> oferuje Ci uzbrajanie twojej postaci, a zakupione rzeczy znajdziesz w <a style="font-size: 25px;color: gold;" href="ekwipunek.php">Ekwipunku</a>.</p><br />
		<p style="font-size: 25px;"><a style="font-size: 25px;color: gold;"href="praca.php">Pracuj</a> i zdobywaj pieniądze potrzebne do rozwoju postaci.</p><br />

		<div style="text-align: center;">
		<h3 style="color: red; font-weight: bold;">Gra jest stale rozwijana, z czasem pojawią się nowe funkcje i rzeczy. Miłej zabawy!<br /><br /></h3>
		</div>
		
		<form method="get" action="">
		<p align="right">Aby zamnkąć kliknij przycisk <input type="submit" class="gothbutton" name="tuti" value="Dalej"></p>
		</form>
		
     </div>
	<div class="postfooter"></div>
</div>	 

<?php
require_once('bottom.php');
?>