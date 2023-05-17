<!doctype html>
<html lang="pl-PL">
<head>
	<meta charset="UTF-8">
	<link rel="icon" href="images/favicon.ico">
	<link href="styles/style.css" rel="stylesheet" type="text/css" />
	<meta name="description" content="Wojownicy Myrtany darmowa gra online w świecie Gothica. W grze wcielasz się w wojownika, którego wyposażasz w różny ekwipunek. Poprzez treningi i walkę z przeciwnikami wspinaj się na sam szczyt!">
	<meta name="author" content="GPC">
	<title>Wojownicy Myrtany - Darmowa gra internetowa w świecie Gothica</title>
</head>

<?php
require_once('config/session.php');
require_once('config/config.php');
require_once('config/user.php');
?>
<body>
	<div id="container">
		<div id="content">
			<div id="left">
				<div class="menu" style="margin-top: -8px; margin-bottom: -15px;">
					<a draggable="false" href="index.php"><img draggable="false" src="images/logo_mini.png" /></a>
				</div>
				<div class="menu">
					<div class="menuheader"><h3>Menu</h3></div>
					<div id="menu_nawigacja" class="menucontent">
						<?php require_once('config/nawigacja.php');?>
					</div>
					<div class="menufooter"></div>
				</div>
			</div>
			<div id="right">
				<div style="margin-top: -10px;" class="menu">
					<div class="menuheader"><h3>Statystyki</h3></div>
					<div class="menucontent">
						<div style="text-align: center;"><b><?php echo $user -> get['nick']; ?></b></div>
						<div id="dane_gracza">
							<?php require_once('config/panel.php'); ?>
						</div>
					</div>
					<div class="menufooter"></div>
				</div>
				<?php require_once('config/linki.php'); ?>
			</div>
			<div id="middle">