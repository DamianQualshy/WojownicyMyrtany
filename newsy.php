<?php
require_once('head_index.php');

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

if (isset($_GET["wyloguj"]) && $_GET['wyloguj'] == 'ok')
{
    if (isset($_SESSION['login']) && isset($_SESSION['pass']))
    {
	    $test = mysqli_fetch_object(mysqli_query($GLOBALS['db'], "SELECT `id`, `online` FROM `konta` WHERE `login`='".$_SESSION['login']."' AND `haslo`='".$_SESSION['pass']."'"));
	    $minus = $test -> online - 400;
		mysqli_query($GLOBALS['db'], 'UPDATE `konta` SET `online`='.$minus.' WHERE `id`='.$test -> id);
        session_destroy();
		session_unset();
        header('Location: index.php');
    }
        else
    {
        error_div('<span style="color:red;">Najpierw musisz się zalogować!</span>');
    }
}

if (isset($_GET['loguj']) && $_GET['loguj'] == 'ok')
{
    if (empty($_POST['login']) && empty($_POST['haslo'])) error_div('<span style="color:red;">Wypełnij wszystkie pola!</span>');
    $pobierz = mysqli_num_rows(mysqli_query($GLOBALS['db'], "SELECT `login`, `haslo` FROM `konta` WHERE `login`='".htmlspecialchars($_POST['login'])."' AND `haslo`='".htmlspecialchars($_POST['haslo'])."'"));
    if ($pobierz == 0) error_div('<span style="color:red;">Wpisane dane są niepoprawne. Sprawdź pisownię i spróbuj jeszcze raz</span>');
	$_SESSION['login'] = htmlspecialchars($_POST['login']);
	$_SESSION['pass'] = htmlspecialchars($_POST['haslo']);
	$odczyt = mysqli_fetch_array(mysqli_query($GLOBALS['db'], "SELECT `tuti` FROM `konta` WHERE `login`='".$_SESSION['login']."' AND `haslo`='".$_SESSION['pass']."'"));
	if ($odczyt['tuti'] == 0)
    { 
        header('Location: poradnik.php'); 
    } 
        else
    {
        header('Location: postac.php');
    }
}
?>

<div class="post">
    <div class="postheader"><h1>Nowości oraz ogłoszenia</h1></div>
	<div class="postcontent">
	    <?php
		$pobierz = mysqli_query($GLOBALS['db'], 'SELECT * FROM `newsy` ORDER BY `id` DESC');
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
				if(mysqli_num_rows($pobierz) > 1)
				{
					echo '<br /><div src="images/article_separator.png" style="width: 410px;height: 11px;margin: 0 auto;background: url(images/article_separator.png);background-repeat: no-repeat;"></div><br />';
				}
            }
        }
        else echo '<p>Brak newsów</p>';
		echo '<h1 style="text-align: center;"><a style="margin: 0 auto; cursor: pointer" href="index.php">Strona główna</a></h1>';		
		?>
	</div>
	<div class="postfooter"></div>
</div>		

<?php
require_once('bottom.php');
?>