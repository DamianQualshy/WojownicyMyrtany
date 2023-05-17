
<script type="text/javascript">
function updateScrollx(){
  var scrollingElement = (document.scrollingElement || document.body);
scrollingElement.scrollTop = scrollingElement.scrollHeight;
}
</script>
<?php

function send($rank, $message = "", $user)
{
    echo '<div>';
	echo $message;
	echo '<div class="postbreak"></div>';
	echo '<div style="margin-top: -33px;overflow:scroll; overflow-x:hidden;max-height:400px;margin-bottom: 6px;" id="karczma_czat">';

	$karczma_chat = mysqli_query($GLOBALS['db'], "SELECT * FROM (SELECT * FROM chat ORDER BY id DESC LIMIT 50) sub ORDER BY id ASC");
    if(mysqli_num_rows($karczma_chat) > 0)
    {
        while($i = mysqli_fetch_object($karczma_chat))
        {
			//if ($rank == 'Admin') $del = ' <a style="float: right;" href="karczma.php?del='.$i -> id.'"> <img src="images/ex.png"></a>';
			$del = '';
			if ($rank == 'Admin') {$del = '<a href="karczma.php?del='.$i -> id.'"><font style="color: #ff0000;">x</font></a>';}
            if($i -> autor == $user)
			{
				// $del = '<a style="margin-right: 2px; margin-top: -6px; float: right;" href="karczma.php?del='.$i -> id.'"><font style="color: #ff0000;">x</font></a>';
				echo '<div title="['.$i -> data.'] ['.$i -> czas.']" style="margin-right: 5px;word-wrap: break-word; border-radius: 16px 0px 16px 16px; padding: 3px; margin-bottom: 2px; background: #515767;"><b> <div style="font-family: Englebert; color: #E9E9E9; margin-left: 8px; margin-top: 4px; margin-bottom: 4px;">'.$del.' <a style="color: white;" href="view.php?name='.$i -> autor.'">'.$i -> autor.'</a></b>: <br>'.$i -> text.'</div></div>';
			}
   	        else echo '<div title="['.$i -> data.'] ['.$i -> czas.']" style="margin-right: 5px;word-wrap: break-word; border-radius: 0px 16px 16px 16px; padding: 3px; margin-bottom: 2px; background: #343a48;"><b> <div style="font-family: Englebert; color: #E9E9E9; margin-left: 8px; margin-top: 4px; margin-bottom: 4px;">'.$del.' <a style="color: white;" href="view.php?name='.$i -> autor.'">'.$i -> autor.'</a></b>: <br>'.$i -> text.'</div></div>';
        }
    }
    else echo '<br /><div class="komunikat_s komwhite">Nie ma żadnych wypowiedzi w czacie</div>';
    echo '<script type="text/javascript">
   	           function licz(pole,max)
			   {
                    if (pole.value.length > max) pole.value = pole.value.substr(0,max);
                    document.getElementById(\'wskaz\').value=200-pole.value.length;
               }
          </script>';
	echo '</div>';
	echo '<div class="postbreak"></div>';
    echo '<br />';
	echo '<table style="margin: 0 auto;">';
	echo '<tr>';
	echo '<td style="width: 315px;">';
	echo '<form method="post" action="karczma.php?send=yes">';
    echo "<input class=\"formul\" type=\"text\" onInput=\"licz(this,200)\" name=\"text\" style=\"background: url(images/input_dlugi.png); width: 284px; padding-left: 8px; padding-right: 8px;\" value=\"\" onfocus=\"if (this.value == '') this.value = '';\" onblur=\"if (this.value == '') this.value = '';\" /> ";
	echo '</td>';
	echo '<td>';
    echo '<input style="display: inline-block;" class="gothbutton" type="submit" value="Wyślij" /><br />';
	echo '</td>';
	echo '</tr>';
	echo '<tr>';
	echo '<td>';
    echo 'Pozostało znaków: <input id="wskaz" value="200" readonly="readonly" style="width: 40px; font-size: 20px; color: whitesmoke; background: none; border: none; font-weight: bold;" type="text" />';
	echo '</td>';
	echo '<td>';
	echo '</td>';
	echo '</tr>';
    echo '</form>';
	echo '</table>';
	echo '</div>';
}

if (!isset($_GET['send']) && !isset($_GET['del']))
{
	send($user -> get['rank'],'',$user -> get['login']);
}

if (isset($_GET['send']))
{
    if (strlen($_POST['text']) <= 200)
	{
        if (!empty($_POST['text']))
        {
			$czas = date('H:i');
			$data = date('d-m-Y')."r.";
            $_POST['text'] = htmlspecialchars($_POST['text']);
            // mysqli_query($GLOBALS['db'], "INSERT INTO `chat` VALUES (NULL, '".$data."', '".$czas."', '".$user -> get['login']."', '".$_POST['text']."')");
            mysqli_query($GLOBALS['db'], "INSERT INTO `chat` (`data`,`czas`,`autor`,`text`) VALUES ('".$data."', '".$czas."', '".$user -> get['login']."', '".$_POST['text']."')");
            send($user -> get['rank'], '<div class="komunikat komgreen">Dodano wypowiedź</div><script>updateScrollx();</script>', $user -> get['login']);
          }
	    else send($user -> get['rank'], '<div class="komunikat komred">Musisz coś wpisać!</div>', $user -> get['login']);
    }
	else send($user -> get['rank'], '<div class="komunikat komred">Zbyt długa wypowiedź! Maksymalnie możesz wpisać 200 znaków!</div>', $user -> get['login']);
}

function clip ($text, $number)
{
    if (strlen($text) > $number)
    {
        $text = preg_replace('/s+?(S+)?$/', '', substr($text, 0, $number+1));
        $text = substr($text, 0, $number);
        return $text.'...';
	}
	else return $text;
}

if (isset($_GET['del']))
{
	$usun = mysqli_fetch_object(mysqli_query($GLOBALS['db'], 'SELECT * FROM `chat` WHERE `id`='.$_GET['del']));
	if($usun == true)
	{
		if ($user -> get['rank'] == 'Admin' or $user -> get['login'] == $usun -> autor)
		{
			if ($usun -> autor == $user -> get['login'])
			{
				$usun_autor = 'Ciebie';
			}
			else $usun_autor = $usun -> autor;

		    mysqli_query($GLOBALS['db'], 'DELETE FROM `chat` WHERE `id`='.$_GET['del']);
			send($user -> get['rank'], '<span style="color:green;">Skasowano wypowiedź napisaną przez <i><b>'.$usun_autor.'</b></i></span><br /><br />', $user -> get['login']);
		}
		else send($user -> get['rank'], '<span style="color:red;">Nie posiadasz uprawnień do tego!</span><br /><br />', $user -> get['login']);
	}
	else send($user -> get['rank'], '<span style="color:red;">Nie ma takiego postu!</span><br /><br />', $user -> get['login']);
}

$czat_najwyzszy2 = mysqli_query($GLOBALS['db'], "SELECT id FROM `chat` ORDER BY `id` DESC LIMIT 1");
while($czat_najwyzszy = mysqli_fetch_object($czat_najwyzszy2))
{
	$czat_naj_id = $czat_najwyzszy -> id;
	mysqli_query($GLOBALS['db'], 'UPDATE konta SET czat_przeczytane='.$czat_naj_id.' WHERE id='.$user -> get['id']);
}
?>
<script type="text/javascript">
function updateScroll(){
    var element = document.getElementById("karczma_czat");
    element.scrollTop = element.scrollHeight;
}
updateScroll();
</script>
