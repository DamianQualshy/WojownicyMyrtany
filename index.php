<?php
require_once('head_index.php');

function filter($data)
{
    if(get_magic_quotes_gpc()) $data = stripslashes($data);
    return mysqli_real_escape_string($GLOBALS['db'], htmlspecialchars(trim($data)));
}

if (isset($_GET["signout"]))
{
    if (isset($_SESSION['nick']) && isset($_SESSION['pass']))
    {
	    $online = mysqli_fetch_object(mysqli_query($GLOBALS['db'], "SELECT `id`, `online` FROM `acct_data` WHERE `nick`='".$_SESSION['nick']."' AND `pass`='".$_SESSION['pass']."'"));
	    $minus = $online -> online - 400;
		mysqli_query($GLOBALS['db'], 'UPDATE `acct_data` SET `online`='.$minus.' WHERE `id`='.$online -> id);
        session_destroy();
		session_unset();
        header('Location: index.php');
    }
    else
    {
        error_div('<div class="komunikat_m komred">Najpierw musisz się zalogować!</div>');
    }
}

if (isset($_GET['signin']))
{
	if (isset($_POST['signin']))
	{
		$nick = filter($_POST['nick']);
		$ip = filter($_SERVER['REMOTE_ADDR']);

		$check = mysqli_fetch_array(mysqli_query($GLOBALS['db'], "SELECT nick, pass FROM acct_data WHERE nick = '".$nick."';"));
		$pass = password_verify(filter($_POST['pass']), $check['pass']);
		if ($nick == $check['nick'] && $nick == $check['nick'])
		{
			mysqli_query($GLOBALS['db'], "UPDATE `acct_data` SET (`ip` = '".$ip."') WHERE nick = '".$nick."';");
			$_SESSION['zalogowany'] = true;
			$_SESSION['nick'] = $nick;
			$_SESSION['pass'] = $check['pass'];
			header('Location: summary.php');
		}
	   else error_div('<div class="komunikat_m komred">Wpisano złe dane!</div>');
	}
}

?>
				<div class="post">
					<div class="postheader"><h1>Wojownicy Myrtany</h1></div>
					<div class="postcontent">
						<p style="font-weight: bold; margin-bottom: -20px;">Wojownicy Myrtany darmowa gra online w świecie Gothica. W grze wcielasz się w wojownika, którego wyposażasz w różny ekwipunek. Poprzez treningi i walkę z przeciwnikami wspinaj się na sam szczyt!</p>
					</div>
					<div class="postfooter"></div>
				</div>
				<div class="post">
					<div class="postheader"><h1>Nowości oraz ogłoszenia</h1></div>
					<div class="postcontent">
					<?php
					$post = mysqli_query($GLOBALS['db'], 'SELECT * FROM `news` ORDER BY `id` DESC LIMIT 3');
					if(mysqli_num_rows($post) > 0)
					{
						while($i = mysqli_fetch_object($post))
						{
								$str     = $i -> text;
								$order   = array("\r\n", "\n", "\r");
								$replace = '<br />';
								$newstr = str_replace($order, $replace, $str);

								$str2     = ''.$newstr.'';
								$order2   = array("&lt;br /&gt;");
								$replace2 = '';
								$newstr2 = str_replace($order2, $replace2, $str2);

								echo '<p>'.$i -> date;
								echo ', '.$i -> time;
								echo '</p>';
								echo '<h3 style="padding-left: 20px; padding-right: 20px;" >'.$newstr2.'</h3>';
								if(mysqli_num_rows($post) > 1)
								{
									echo '<br /><div src="images/article_separator.png" style="width: 410px;height: 11px;margin: 0 auto;background: url(images/article_separator.png);background-repeat: no-repeat;"></div><br />';
								}
						}
					}
					else echo '<p>Brak newsów</p>';
					echo '<h1 style="text-align: center;"><a style="margin: 0 auto; cursor: pointer" href="news.php">Pełna lista</a></h1>';
					?>
					</div>
					<div class="postfooter"></div>
				</div>
<?php require_once('bottom.php'); ?>
