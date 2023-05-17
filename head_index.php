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
?>
<body>
	<div id="header">
	<a draggable="false" href="index.php">
		<img draggable="false" src="images/logo.png" style="margin-left: auto; margin-right: auto; left: 0; right: 0; top: -250px; position: absolute;">
	</a>
	</div>
	<div style="top: 300px;" id="container">
		<div id="content">
			<div style="margin-top: -20px;" id="left">
				<div class="menu">
					<div class="menuheader"><h3>Logowanie</h3></div>
					<div class="menucontent">
						<div class="member">
							<?php
							if (isset($_SESSION['nick']) && isset($_SESSION['pass']))
							{
								echo '<ul>
								<li><a style="text-decoration: none;" href="summary.php">Graj</a></li><br/ >
								<li><a style="text-decoration: none;" href="index.php?signout">Wyloguj</a></li>
								</ul><br />';
							} else
							{
							?>
							<div class="signin">
								<form style="margin-bottom: 40px;" action="index.php?signin" name="signin" method="post">
									<input class="formul" style="width: 136px; margin-top: 5px; margin-bottom: 10px;" type="text" placeholder="Login" name="nick" />
									<input class="formul" style="width: 136px; margin-top: 5px; margin-bottom: 15px;" type="password" placeholder="Hasło" name="pass" />
									<input class="gothbutton" style="margin: 0 auto;" type="submit" value="Zaloguj" name="signin">
								</form>
								<form action="reg.php">
									<input type="submit" class="gothbutton" value="Zarejestruj się!" style="color: gold; font-size: 13px; font-style: italic; margin: 0 auto; margin-bottom: 7px;">
								</form>
							</div>
							<?php
							}
							?>
						</div>
						<div class="clear"></div>
					</div>
					<div class="menufooter"></div>
				</div>
				<?php require_once('config/linki.php'); ?>
			</div>
			<div id="middle">
			<?php
			function error_div($text)
			{
			echo "<div class='postheader'><h1>ERROR</h1></div>
			<div class='postcontent'>
				<p>".$text."</p>
				</div>
				<div class='postfooter'></div>
			</div>";
			exit;
			}
			?>