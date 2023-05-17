<!doctype html>
<html lang="pl-PL">
<head>
<meta charset="UTF-8">
<link rel="icon" type="image/png" href="/images/favicon/favicon-32x32.png?v=2bbK9R8jpr" sizes="32x32">
<link href="css/style.css" rel="stylesheet" type="text/css" />
<meta name="description" content="Wojownicy Myrtany darmowa gra online w świecie Gothica. W grze wcielasz się w wojownika, którego wyposażasz w różny ekwipunek. Poprzez treningi i walkę z przeciwnikami wspinaj się na sam szczyt!">
<meta name="author" content="Gothic po chamsku">
<title>Wojownicy Myrtany - Darmowa gra internetowa w świecie Gothica</title>
<script src="includes/jquery.js"></script>
</head>

<?php
require_once('common/session.php');
require_once('common/config.php');
require_once('common/user.php');

if (!$install) 
{
    header('Location: install/install.php');
    exit;
}

if($_SERVER['PHP_SELF'] != '/praca.php')
{
	if($_SERVER['PHP_SELF'] != '/karczma.php')
	{
		if ($user -> get['praca_aktywna'] == 1)
		{
			header('Location: praca.php');
		}
	}
}

if (!isset($_SESSION['login'])) die ('<div style="display: table; margin: 0 auto;" class="post">
    <div class="postheader"><h1>Wojownicy Myrtany</h1></div>
	<div class="postcontent">
		<center><p>Musisz się zalogować!<br /><br /><a href="index.php">Strona główna</a></p></center>
	</div>
	<div class="postfooter"></div>
</div>');

mysqli_query($GLOBALS['db'], 'UPDATE `konta` SET `online`='.time().', `ip`="'.$_SERVER['REMOTE_ADDR'].'" WHERE `id`='.$user -> get['id']);

$nie_index = 1;

include('includes/lvlup.php');

?>

<body>

<div id="header">
	<a href="index.php">
		<img src="/images/WojMyrLOGO_cut.png" style="margin-left: auto; margin-right: auto; left: 0; right: 0; top: -390px; position: absolute;">
	</a>
</div>
	
<div style="top: 145px;" id="container">
	<div id="content">
		<div style="margin-top: -20px;" id="left">
			<div class="menu">
				<div class="menuheader"><h3>Statystyki</h3></div>
				<div class="menucontent">
					<div style="text-align: center;"><b><?php echo $user -> get['login']; ?></b></div>
					<div id="dane_gracza">
						<?php $panel = 1; require_once('includes/panel.php'); $panel = 0;?>
					</div>
				</div>
				<div class="menufooter"></div>
			</div>
			<div class="menu">
				<div class="menuheader"><h3>Menu</h3></div>
				<div id="menu_nawigacja" class="menucontent">
					<?php $nawigacja = 1; require_once('includes/nawigacja.php'); $nawigacja = 0;?>
				</div>
				<div class="menufooter"></div>
			</div>
			<?php require_once('includes/linki.php'); ?>
		</div>
        <div id="middle">