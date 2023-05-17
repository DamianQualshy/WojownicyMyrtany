<?php

require_once('head_index.php');
?>

<div class="post">
    <div class="postheader"><h1>Rejestracja</h1></div>
	<div class="postcontent">
<?php

if (!isset($_SESSION['login']))
{
	
function filtruj($zmienna)
{
    if(get_magic_quotes_gpc())
        $zmienna = stripslashes($zmienna); // usuwamy slashe
 
   // usuwamy spacje, tagi html oraz niebezpieczne znaki
    return mysqli_real_escape_string($GLOBALS['db'], htmlspecialchars(trim($zmienna)));
}
 
if (isset($_POST['rejestruj']))
{
   $login = filtruj($_POST['login']);
   $haslo1 = filtruj($_POST['haslo1']);
   $haslo2 = filtruj($_POST['haslo2']);
   $email = filtruj($_POST['email']);
   $ip = filtruj($_SERVER['REMOTE_ADDR']);
 
    $next = 1;

    if (!$login && !$haslo1 && !$haslo2 && !$email) 
	{
	    echo '<p><span style="color:red;">Nie wypełniono wszystkich pól</span></p>';
        $next = null;
	}
	
    else if (strlen($login) < 5) 
	{
	    echo '<p><span style="color:red;">Login musi składać się z minimum 5 znaków!</span></p>';
		$next = null;
	}

    elseif (strlen($haslo1) < 6) 
	{
	    echo '<p><span style="color:red;">Hasło musi zawierać conajmniej 6 znaków!</span></p>';
        $next = null;
	}
	
	if ($haslo1 != $haslo2) // sprawdzamy czy hasła takie same
    {
		echo '<p><span style="color:red;">Hasła się nie zgadzają!</span></p>';
        $next = null;
    }
	
    elseif(strlen($email) < 6) 
	{
	    echo '<p><span style="color:red;">Email musi składać się conajmniej z 6 znaków!</span></p>';
        $next = null;
	}
	
    $check = mysqli_fetch_array(mysqli_query($GLOBALS['db'], "SELECT `login` FROM `konta` WHERE `login`='".$login."'"));
    $check2 = mysqli_fetch_array(mysqli_query($GLOBALS['db'], "SELECT `email` FROM `konta` WHERE `email`='".$email."'"));

    if (isset($check) && !empty($login)) 
	{
	    echo '<p><span style="color:red;">Istnieje już gracz o takim loginie.</span></p>';
		$next = null;
	}

    if (isset($check2) && !empty($email)) 
	{
	    echo '<p><span style="color:red;">Istnieje już gracz o takim mailu.</span></p>';
		$next = null;
	}
	
	
	$regex = '/^[a-zA-Z0-9.\-_]+@[a-zA-Z0-9\-.]+\.[a-zA-Z]{2,4}$/';
    if (!preg_match($regex, $email))
    {  
	    echo '<p><span style="color:red;">Taki adres e-mail nie istnieje!</span></p>';
		$next = null;
	}

	if($next != null)
	{
		mysqli_query($GLOBALS['db'], "INSERT INTO `konta` (`login`, `haslo`, `email`, `atak`, `obrona`, `szybkosc`) VALUES ('".$login."', '".password_hash($haslo1, PASSWORD_DEFAULT)."', '".$email."', 10, 10, 10)");
        echo '<p><span style="color:green;">Zostałeś poprawnie zarejestrowany.</span></p>';
	}
}
	
?>



<form method="POST" action="rejestracja.php">
<br />
<b>Login:</b> <input class="formul" value="<?php if (isset($login)) echo $login;?>" type="text" name="login"><br  /><br />
<b>Hasło:</b> <input class="formul" type="password" name="haslo1"><br  />
<b>Powtórz hasło:</b> <input class="formul" type="password" name="haslo2"><br /><br />
<b>Email:</b> <input class="formul" value="<?php if (isset($email)) echo $email;?>" type="text" name="email"><br /><br />
<input type="submit" class="gothbutton" value="Utwórz konto" name="rejestruj">
</form>

<?php
}
else echo '<br />Jesteś zalogowany';
?>
    </div>
    <div class="postfooter"></div>
</div>

<?php
require_once('bottom.php');
?>