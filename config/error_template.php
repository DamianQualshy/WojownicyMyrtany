<?php
$before = '<body>
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
				<?php require_once("config/linki.php"); ?>
			</div>
			<div id="middle">
				<div class="post">
					<div class="postheader"><h1>BŁĄD</h1></div>
					<div class="postcontent">
			';

$after = '</div>
					<div class="postfooter"></div>
				</div>
				<div class="footer" style="margin-bottom: 10px; clear: both;">
					<div class="postheader"></div>
					<div class="postcontent" style="text-align: center; padding: 0px;">
						<p>&copy'.date('Y').' Gothic po Chamsku | <a href="footer.php">WIĘCEJ</a> | <a style="color: goldenrod;" href="kontakt.php">PANEL KONTAKTOWY</a></p>
					</div>
					<div class="postfooter"></div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>';
?>