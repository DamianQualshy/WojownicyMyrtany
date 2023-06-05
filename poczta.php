<?php


require_once('head.php');
?>

<div class="post">
    <div class="postheader"><h1>Poczta</h1></div>
	<div class="postcontent">

<?php
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

function close($text)
{
    echo "$text";
	echo '</div><div class="postfooter"></div></div>';
	require_once('bottom.php');
	exit;
}

$num = mysqli_num_rows(mysqli_query($GLOBALS['db'], "SELECT * FROM `mail` WHERE `owner`=".$user -> get['id']." ORDER BY `id` DESC"));

if ($user -> get['rank'] == 'User') $max_num = 100;
else $max_num = 500;

if ($num < $max_num) echo '<b>Pojemność</b>: '.$num.'/'.$max_num.'<br /><br />';
else echo '<b>Pojemność</b>: <span style="color:red;">'.$num.'/'.$max_num.'</span><br /><br />';

if (!isset($_GET['czytaj']) && !isset($_GET['opcja']) && !isset($_GET['del']))
{
    echo '<center><a style="color: gold; font-size: 20px;" href="poczta.php">Odebrane</a> | <a href="poczta.php?opcja=wyslane">Wysłane</a> | <a href="poczta.php?opcja=napisz">Napisz</a></center><br /><br />';
}
    elseif (isset($_GET['opcja']) && $_GET['opcja'] == 'wyslane')
{
    echo '<center><a href="poczta.php">Odebrane</a> | <a style="color: gold; font-size: 20px;" href="poczta.php?opcja=wyslane">Wysłane</a> | <a href="poczta.php?opcja=napisz">Napisz</a></center><br /><br />';
}
    elseif (isset($_GET['opcja']) && $_GET['opcja'] == 'napisz')
{
    echo '<center><a href="poczta.php">Odebrane</a> | <a href="poczta.php?opcja=wyslane">Wysłane</a> | <a style="color: gold; font-size: 20px;" href="poczta.php?opcja=napisz">Napisz</a> </center><br /><br />';
}
    else
{
    echo '<center><a href="poczta.php">Odebrane</a> | <a href="poczta.php?opcja=wyslane">Wysłane</a> | <a href="poczta.php?opcja=napisz">Napisz</a></center><br /><br />';
}

$bg = '#3F3F3F';

if (!isset($_GET['czytaj']) && !isset($_GET['opcja']) && !isset($_GET['del']))
{
    $pobierz = mysqli_query($GLOBALS['db'], "SELECT * FROM `mail` WHERE `owner`=".$user -> get['id']." AND `type`='odebrane' ORDER BY `id` DESC");
    echo '<table width="600" cellpadding="0" cellspacing="1">
          <tr>
	      <td width="10%"><p style="color:white;">Lp</p></td>
	      <td width="40%"><p style="color:white;">Nadawca</p></td>
	      <td width="40%"><p style="color:white;">Temat</p></td>
	      <td width="10%"><p style="color:white;">Opcje</p></td>
	      </tr>';
    $pobierz_num = mysqli_num_rows($pobierz);
    $lp = $pobierz_num;	  
    if($pobierz_num > 0) 
    {
        while($i = mysqli_fetch_object($pobierz)) 
        {
            echo '<tr>';
		    if ($i -> przeczytane == '0') echo '<td><p>'.$lp.' <blink style="color: red;font-weight: bolder;font-size: 18px;">!!</blink></p></td>';
	        else echo '<td><p>'.$lp.'</p></td>';
		    echo '<td><p>'.$i -> autor.' ('.$i -> autor_id.')</p></td>
		          <td><p>'.clip($i -> title, 20).'</p></td>
		          <td><p><a href="poczta.php?czytaj='.$i -> id.'">Czytaj</a><br /><a href="poczta.php?del='.$i -> id.'">Skasuj</a></p></td>
		          </tr>';
            $lp--;
        }
	}
	else close ('</table><br />Nie masz żadnych wiadomości!');
	echo '</table>';
}

if (isset($_GET['czytaj']))
{
    if (preg_match("/^[0-9]*$/", $_GET['czytaj']))
	{
        $check = mysqli_fetch_object(mysqli_query($GLOBALS['db'], 'SELECT * FROM `mail` WHERE `id`='.$_GET['czytaj'].' AND `owner`='.$user -> get['id']));	
		if ($check == true)
		{
		    if (!isset($_POST['odpisz']))
			{
			    if ($check -> przeczytane == '0') mysqli_query($GLOBALS['db'], "UPDATE `mail` SET `przeczytane`='1' WHERE `id`=".$_GET['czytaj']);
                $od = mysqli_fetch_object(mysqli_query($GLOBALS['db'], "SELECT `login` FROM `konta` WHERE `id`=".$check -> owner));
		        echo '<table style="border:1px solid '.$bg.'; padding:5px;"><tr><td>
				      <b>Data wysłania:</b> '.$check -> date.' <br />
			          <b>Nadawca:</b> '.$check -> autor.' ('.$check -> autor_id.')<br />
					  <b>Odbiorca:</b> '.$od -> login.' ('.$check -> owner.')<br />
				      <b>Tytuł:</b> '.$check -> title.'</b>
					  </td></tr></table><br /><br />
			          '.$check -> text.'
					  <br /><br />
				      <form method="post" action="poczta.php?czytaj='.$_GET['czytaj'].'#odpisz">
				      <textarea name="text" style="width:300px; height:200px;"></textarea><br />
				      <input type="submit" name="odpisz" style="width:302px;" value="Odpisz">
				      </form>';
            }
			    else
			{
			    if ($num < $max_num)
                {
                    if (!empty($_POST['text']))
	     			{
			    	    $date = date("Y-m-d H:i:s");
					    $_POST['text'] = nl2br(strip_tags($_POST['text']));
                        $title = $check -> title.': odp';
			            mysqli_query($GLOBALS['db'], "INSERT INTO `mail` (`owner`, `text`, `title`, `autor_id`, `autor`, `date`, `type`) VALUES (".$check -> autor_id.", '<span style=font-size:15px;>".$user -> get['login']."</span></i>: ".$_POST['text']."', '".$title."', ".$user -> get['id'].", '".$user -> get['login']."', '".$date."', 'odebrane')");
			            mysqli_query($GLOBALS['db'], "INSERT INTO `mail` (`owner`, `text`, `title`, `autor_id`, `autor`, `date`, `type`, `do_user`) VALUES (".$user -> get['id'].", '<span style=font-size:15px;>".$user -> get['login']."</span></i>: ".$_POST['text']."', '".$title."', ".$user -> get['id'].", '".$user -> get['login']."', '".$date."', 'wyslane', ".$check -> autor_id.")");
						echo '<span style="color:green;">Wysłano wiadomość do usera o id '.$check -> autor_id.'</span>';
				    }
					else echo '<span style="color:red;">Nic nie wpisano!</span>';
				}
			    else echo '<span style="color:red;">Twoja poczta jest zapełniona. Wykasuj niektóre wiadomości, aby móc dalej pisać</span><br /><br />';
			}
		}
		else echo '<span style="color:red;">Nie ma takiej wiadomości!</span>';
	}
	else echo '<span style="color:red;">Nie ma takiej wiadomości!</span>';
}

if (isset($_GET['opcja']) && $_GET['opcja'] == 'wyslane')
{  
    if (!isset($_GET['zobacz']))
	{
        $wyslane = mysqli_query($GLOBALS['db'], "SELECT * FROM `mail` WHERE `owner`=".$user -> get['id']." AND `type`='wyslane' ORDER BY id DESC");
		$number = mysqli_num_rows($wyslane);
        echo '<table width="600" cellpadding="0" cellspacing="1">
              <tr>
	          <td width="20%"><p style="color:white;">Lp</p></td>
	          <td width="35%"><p style="color:white;">Do</p></td>
	          <td width="35%"><p style="color:white;">Temat</p></td>
	          <td width="10%"><p style="color:white;">Opcje</p></td>
	          </tr>';
        $lp = $number;	  
        if ($number > 0) 
        {
            while ($i = mysqli_fetch_object($wyslane)) 
            {
			    $do = mysqli_fetch_object(mysqli_query($GLOBALS['db'], "SELECT `login` FROM `konta` WHERE `id`=".$i -> do_user));
                echo '<tr>
                      <td style="padding-left:20px;">'.$lp.'</td>
                      <td style="padding-left:20px;">'.$do -> login.' ('.$i -> do_user.')</td>
		              <td style="padding-left:20px;">'.clip($i -> title, 30).'</td>
		              <td style="padding-left:20px;"><a href="poczta.php?opcja=wyslane&zobacz='.$i -> id.'">Czytaj</a><br /><a href="poczta.php?del='.$i -> id.'">Skasuj</a></td>
		              </tr>';
                $lp--;
            }
	    }
		else close ('</table><br />Brak wysłanych listów!');
		echo '</table>';
	}
	    else
	{ 
        $check = mysqli_fetch_object(mysqli_query($GLOBALS['db'], 'SELECT * FROM `mail` WHERE `id`='.$_GET['zobacz'].' AND `owner`='.$user -> get['id']));
		if ($check == true)
		{	
		    $text = nl2br(strip_tags($check -> text));
			$od = mysqli_fetch_object(mysqli_query($GLOBALS['db'], "SELECT `login` FROM `konta` WHERE `id`=".$check -> do_user));
	     	echo '<table style="border:1px solid '.$bg.'; padding:5px;"><tr><td>
			      <b>Data wysłania:</b> '.$check -> date.' <br />
		          <b>Nadawca:</b> '.$check -> autor.' ('.$check -> autor_id.')<br />
				  <b>Odbiorca:</b> '.$od -> login.' ('.$check -> do_user.')<br />
		          <b>Tytuł:</b> '.$check -> title.'</b>
				  </td></tr></table><br /><br />
		          '.$check -> text.'<br /><br />';	    
	    }
		else echo '<span style="color:red;">Nie ma takiej wiadomości!</span>';
	}
}

if (isset($_GET['opcja']) && $_GET['opcja'] == 'napisz')
{
    if (!isset($_POST['napisz']))
	{
	    if (isset($_GET['do'])) $value = $_GET['do'];
		else $value = 'Login usera';
	    echo '<center><form method="post" action="poczta.php?opcja=napisz#napisz">
		      <input type="text" name="do" style="width:300px;" value="'.$value.'" onfocus="if (this.value == \'Login usera\') this.value = \'\';" onblur="if (this.value == \'\') this.value = \'Login usera\';"><br />
		      <input type="text" style="width:300px;" name="title" value="Tytuł" onfocus="if (this.value == \'Tytuł\') this.value = \'\';" onblur="if (this.value == \'\') this.value = \'Tytuł\';"><br />
		      <textarea name="text" style="width:300px; height:200px;"></textarea><br />
			  <input type="submit" name="napisz" style="width:302px;" value="Napisz">
			  </form></center>';
    }
	    else
	{
	    if ($num < $max_num)
		{ 
		    if ($_POST['do'] != $user -> get['login'])
            {
			    $tescik = mysqli_fetch_array(mysqli_query($GLOBALS['db'], 'SELECT `login`, `id` FROM `konta` WHERE `login`="'.$_POST['do'].'"'));
			    if ($tescik == false) close ('Użytkownik do którego wysyłasz wiadomość nie istnieje!');
				if (!empty($_POST['text']) && !empty($_POST['do']) && !empty($_POST['title']))
		        {
		            $date = date("Y-m-d H:i:s");
		     	    $_POST['text'] = nl2br(strip_tags($_POST['text']));
			        mysqli_query($GLOBALS['db'], "INSERT INTO `mail` (`owner`, `text`, `title`, `autor_id`, `autor`, `date`, `type`) VALUES (".$tescik['id'].", '<i><span style=font-size:15px;>".$user -> get['login']."</span></i>: ".$_POST['text']."', '".$_POST['title']."', ".$user -> get['id'].", '".$user -> get['login']."', '".$date."', 'odebrane')");
		            mysqli_query($GLOBALS['db'], "INSERT INTO `mail` (`owner`, `text`, `title`, `autor_id`, `autor`, `date`, `type`, `do_user`) VALUES (".$user -> get['id'].", '<i><span style=font-size:15px;>".$user -> get['login']."</span></i>: ".$_POST['text']."', '".$_POST['title']."', ".$user -> get['id'].", '".$user -> get['login']."', '".$date."', 'wyslane', ".$tescik['id'].")");
					echo '<span style="color:green;">Wysłano wiadomość do '.$_POST['do'].'</span>';
		        }
				else echo '<span style="color:red;">Wypełnij wszystkie pola!</span>';
			}
			else echo '<span style="color:red;">Nie możesz wysyłać wiadomości do siebie!</span>';
		}
	        else
		{
		    echo '<span style="color:red;">Twoja poczta jest zapełniona. Wykasuj niektóre wiadomości, aby móc dalej pisać</span><br /><br />';
		}		
	}
}

if (isset($_GET['del']))
{
    if (mysqli_fetch_object(mysqli_query($GLOBALS['db'], "SELECT `id` FROM `mail` WHERE `owner`=".$user -> get['id']." AND `id`=".$_GET['del'])))
	{
	    mysqli_query($GLOBALS['db'], 'DELETE FROM `mail` WHERE `id`='.$_GET['del']);
		echo '<span style="color:green;">Skasowano wiadomość</span>';
	}
	else echo '<span style="color:red;">Nie ma takiej wiadomości!</span>';
}
?>

    </div>
    <div class="postfooter"></div>
</div>

<?php
require_once('bottom.php');
?>