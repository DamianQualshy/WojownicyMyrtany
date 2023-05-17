<!doctype html>
<html lang="pl-PL">
<head>
<meta charset="UTF-8">
<link rel="icon" type="image/png" href="images/favicon/favicon-32x32.png?v=2bbK9R8jpr" sizes="32x32">
<link href="css/style.css" rel="stylesheet" type="text/css" />
<meta name="description" content="Wojownicy Myrtany darmowa gra online w świecie Gothica. W grze wcielasz się w wojownika, którego wyposażasz w różny ekwipunek. Poprzez treningi i walkę z przeciwnikami wspinaj się na sam szczyt!">
<meta name="author" content="Gothic po chamsku">
<title>Wojownicy Myrtany - Darmowa gra internetowa w świecie Gothica</title>
<script src="includes/jquery.js"></script>
</head>

<?php
require_once('common/session.php');
require_once('common/config.php');

if (!$install) 
{
    header('Location: install/install.php');
    exit;
}
?>

<body>

<div id="header">
	<a draggable="false" href="index.php">
		<img draggable="false" src="images/WojMyrLOGO.png" style="margin-left: auto; margin-right: auto; left: 0; right: 0; top: -250px; position: absolute;">
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
                        if (isset($_SESSION['login']) && isset($_SESSION['pass']))
                        {
                            echo '<div style="margin-left: 10px; margin-bottom: 6px;">
							<a style="text-decoration: none;" href="postac.php"><input type="submit" class="gothbutton" value="Graj"></a>
							<br/ >
							<a style="text-decoration: none;" href="index.php?wyloguj"><input type="submit" class="gothbutton" value="Wyloguj"></a>
							</div>';
                        }
						else
						{
						?>
						<form action="index.php?loguj" name="logowanie" method="post" style="margin-left: -20px;">
						<center>
                        <p style="font-family: Metamorphous;">Twój login:<input class="formul" style="width: 130px;margin-top: 5px;" type="text" name="login"></p>
						<p style="font-family: Metamorphous;">Twoje hasło:<input class="formul" style="width: 130px;margin-top: 5px;" type="password" name="haslo"></p>
					    <p><input class="gothbutton" type="submit" value="Zaloguj" name="loguj"><br></p>
						</form>
						<form action="rejestracja.php">
						<p><input type="submit" class="gothbutton" value="Zarejestruj się!" style="color: gold; font-size: 13px; font-style: italic;"></p>
						</form>
                        </center>
						<?php
						}
						?>
					</div>
     				<div class="clear"></div>
			    </div>
				<div class="menufooter"></div>
			</div>
			<?php require_once('includes/linki.php'); ?>
	    </div>
        <div id="middle">