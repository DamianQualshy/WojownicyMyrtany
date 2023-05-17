<?php
require_once('head_index.php');
?>

<div class="post">
    <div class="postheader"><h1>Rejestracja</h1></div>
	<div class="postcontent">
	<br />
<?php

if (!isset($_SESSION['nick']))
{
	function filter($data)
	{
		if(get_magic_quotes_gpc())
		$data = stripslashes($data);
		return mysqli_real_escape_string($GLOBALS['db'], htmlspecialchars(trim($data)));
	}
	 
	if (isset($_POST['register']))
	{
	   $nick = filter($_POST['nick']);
	   $pass1 = filter($_POST['pass1']);
	   $pass2 = filter($_POST['pass2']);
	   $email = filter($_POST['email']);
	   $ip = filter($_SERVER['REMOTE_ADDR']);
	 
		$next = 1;

		if (!$nick && !$pass1 && !$pass2 && !$email) 
		{
			echo '<div class="komunikat komred" style="padding-bottom: 5px;">Nie wypełniono wszystkich pól!</div>';
			$next = null;
		}
		
		else if (strlen($nick) < 4) 
		{
			echo '<div class="komunikat komred" style="padding-bottom: 5px;">Login musi składać się z minimum 4 znaków!</div>';
			$next = null;
		}

		elseif (strlen($pass1) < 6) 
		{
			echo '<div class="komunikat komred" style="padding-bottom: 5px;">Hasło musi zawierać conajmniej 6 znaków!</div>';
			$next = null;
		}
		
		if ($pass1 != $pass2)
		{
			echo '<div class="komunikat komred" style="padding-bottom: 5px;">Hasła się nie zgadzają!</div>';
			$next = null;
		}
		
		elseif(strlen($email) < 6) 
		{
			echo '<div class="komunikat komred" style="padding-bottom: 5px;">Email musi składać się conajmniej z 6 znaków!</div>';
			$next = null;
		}
		
		$check = mysqli_fetch_array(mysqli_query($GLOBALS['db'], "SELECT `nick` FROM `acct_data` WHERE `nick`='".$nick."'"));
		$check2 = mysqli_fetch_array(mysqli_query($GLOBALS['db'], "SELECT `email` FROM `acct_data` WHERE `email`='".$email."'"));

		if (isset($check) && !empty($nick)) 
		{
			echo '<div class="komunikat komred" style="padding-bottom: 5px;">Istnieje już gracz o takim loginie.</div>';
			$next = null;
		}

		if (isset($check2) && !empty($email)) 
		{
			echo '<div class="komunikat komred" style="padding-bottom: 5px;">Istnieje już gracz o takim mailu.</div>';
			$next = null;
		}
		
		
		$regex = '/^[a-zA-Z0-9.\-_]+@[a-zA-Z0-9\-.]+\.[a-zA-Z]{2,4}$/';
		if (!preg_match($regex, $email))
		{  
			echo '<div class="komunikat komred" style="padding-bottom: 5px;">Wpisano zły format maila!</div>';
			$next = null;
		}

		if($next != null)
		{
			mysqli_query($GLOBALS['db'], "INSERT INTO `acct_data` (`nick`, `pass`, `email`) VALUES ('".$nick."', '".password_hash($pass1, PASSWORD_DEFAULT)."', '".$email."')");
			echo '<div class="komunikat_s komgreen" style="padding-bottom: 5px;">Zostałeś poprawnie zarejestrowany.</div>';
		}
		else echo '<br />';
	}
	?>
	<form method="POST" action="reg.php">
	<table style="margin: 0 auto;">
	  <tr>
		<th style="height: 35px; padding-right: 10px;">Login:</th>
		<th style="height: 35px;"><input class="formul" value="<?php if (isset($nick)) echo $nick;?>" type="text" name="nick"></th>
	  </tr>
	  <tr>
		<th style="height: 35px; padding-right: 10px;">Hasło:</th>
		<td style="height: 35px;"><input class="formul" type="password" name="pass1"></td>
	  </tr>
	  <tr>
		<th style="height: 35px; padding-right: 10px;">Powtórz hasło:</th>
		<td style="height: 35px;"><input class="formul" type="password" name="pass2"></td>
	  </tr>
	  <tr>
		<th style="height: 35px; padding-right: 10px;">Email:</th>
		<td style="height: 35px;"><input class="formul" value="<?php if (isset($email)) echo $email;?>" type="text" name="email"></td>
	  </tr>
	  <tr>
		<th style="height: 35px; padding-right: 10px;"></th>
		<td style="height: 35px;"><input type="submit" class="gothbutton" value="Utwórz konto" name="register"></td>
	  </tr>
	</table>
	</form>
<?php
}
else echo '<br /><div class="komunikat_s komred">Jesteś zalogowany</div>';
?>
    </div>
    <div class="postfooter"></div>
</div>

<?php
require_once('bottom.php');
?>