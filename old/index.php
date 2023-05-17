<?php
require_once('head_index.php');

function error_div($text)
{ 
	echo '	<div class="post">
				<div class="postheader"><h1>BŁĄD</h1></div>
				<div class="postcontent">
				'.$text.'
				</div>
				<div class="postfooter"></div>
			</div>';
}

if (isset($_GET["wyloguj"]))
{
    if (isset($_SESSION['login']) && isset($_SESSION['pass']))
    {
	    $onlin = mysqli_fetch_object(mysqli_query($GLOBALS['db'], "SELECT `id`, `online` FROM `konta` WHERE `login`='".$_SESSION['login']."' AND `haslo`='".$_SESSION['pass']."'"));
	    $minus = $onlin -> online - 400;
		mysqli_query($GLOBALS['db'], 'UPDATE `konta` SET `online`='.$minus.' WHERE `id`='.$onlin -> id);
        session_destroy();
		session_unset();
        header('Location: index.php');
    }
    else
    {
        error_div('<div class="komunikat_m komred">Najpierw musisz się zalogować!</div>');
    }
}

function filtruj($zmienna)
{
    if(get_magic_quotes_gpc()) $zmienna = stripslashes($zmienna); // usuwamy slashe
 
   // usuwamy spacje, tagi html oraz niebezpieczne znaki
    return mysqli_real_escape_string($GLOBALS['db'], htmlspecialchars(trim($zmienna)));
}


if (isset($_GET['loguj']))
{
	if (isset($_POST['loguj']))
	{
		$login = filtruj($_POST['login']);
		$ip = filtruj($_SERVER['REMOTE_ADDR']);
		
		$check = mysqli_fetch_array(mysqli_query($GLOBALS['db'], "SELECT login, haslo, poradnik FROM konta WHERE login = '".$login."';"));
		$haslo = password_verify(filtruj($_POST['haslo']), $check['haslo']);
	 
	   // sprawdzamy czy login i hasło są dobre
	   if ($login == $check['login'] && $haslo == $check['haslo'])
	   {
		  // uaktualniamy date logowania oraz ip
		  mysqli_query($GLOBALS['db'], "UPDATE `konta` SET (`ip` = '".$ip."'') WHERE login = '".$login."';");
	 
		  $_SESSION['zalogowany'] = true;
		  $_SESSION['login'] = $login;
		  $_SESSION['pass'] = $check['haslo'];
	 
		  // zalogowany
		if ($check['poradnik'] == 0)
		{ 
			header('Location: poradnik.php'); 
		} 
		else
		{
			header('Location: postac.php');
		}
	 
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
		$pobierz = mysqli_query($GLOBALS['db'], 'SELECT * FROM `newsy` ORDER BY `id` DESC LIMIT 3');
        if(mysqli_num_rows($pobierz) > 0) 
        {
            while($i = mysqli_fetch_object($pobierz)) 
            {
			$str     = $i -> text;
			$order   = array("\r\n", "\n", "\r");
			$replace = '<br />';
			$newstr = str_replace($order, $replace, $str);
			
			$str2     = ''.$newstr.'';
			$order2   = array("&lt;br /&gt;");
			$replace2 = '';
			$newstr2 = str_replace($order2, $replace2, $str2);

				echo '<p>'.$i -> data;
				echo ', '.$i -> czas;
				if (isset($_SESSION['login']) && isset($_SESSION['pass']))
				{
					require_once('common/user.php');
					if ($user -> get['rank'] == 'Admin')
					{
						echo ', ID '.$i -> id;
					}
				}
				echo '</p>';
                echo '<h3 style="padding-left: 20px; padding-right: 20px;" >'.$newstr2.'</h3>';
				if(mysqli_num_rows($pobierz) > 1)
				{
					echo '<br /><div src="images/article_separator.png" style="width: 410px;height: 11px;margin: 0 auto;background: url(images/article_separator.png);background-repeat: no-repeat;"></div><br />';
				}
            }
        }
        else echo '<p>Brak newsów</p>';
		echo '<h1 style="text-align: center;"><a style="margin: 0 auto; cursor: pointer" href="newsy.php">Pełna lista</a></h1>';
		?>
	</div>
	<div class="postfooter"></div>
</div>		

<?php
require_once('bottom.php');
?>