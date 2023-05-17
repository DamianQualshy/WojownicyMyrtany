<?php 
if (($_SERVER['REQUEST_METHOD'] == 'POST')) {// wejście postem
	echo '<div id="sukces"><p>Dziękujemy. Twoja wiadomość została wysłana.</p></div>';
	mysqli_query($GLOBALS['db'], "INSERT INTO `zgloszenia` (`nick`, `email`, `temat`, `tresc`) VALUES ('".$_POST['nick']."', '".$_POST['mail']."', '".$_POST['temat']."', '".$_POST['tresc']."')");
}
else
{
	echo'<form action="'.$_SERVER['REQUEST_URI'].'" method="post" id="formularz">
		<link href="includes/kontakt/formularz.css" rel="stylesheet" type="text/css" />
		<table>
		<div>
			<tr>
			<td>
			<label><font style="font-size:17px;">Nick / Imię i nazwisko: </font> <span class="red">*</span></label>
			<td>
			<input type="text" id="nick" name="nick" value="'.$_POST['nick'].'" />
			</tr>
		</div>
		<div>
			<tr>
			<td>
			<label>Adres e-mail: </label>
			<td>
			<input type="text" id="mail" name="mail" value="'.$_POST['mail'].'" />
			</tr>
		</div>
		<div>
			<tr>
			<td>
			<label>Temat formularza: <span class="red">*</span></label>
			<td>
			<input type="text" id="temat" name="temat" value="'.$_POST['temat'].'" />
			</tr>
		</div>
		<div>
			<tr>
			<td>
			<label>Treść formularza: <span class="red">*</span></label>
			<td>
			<textarea id="tresc" name="tresc" >'.$_POST['tresc'].'</textarea>
			</tr>
		</div>
		</table>
		<div>
			<span class="red">*</span> - oznacza pola wymagane.
		</div>
		<div><br>
			<input id="buttonloginu" type="submit" value="Wyślij" />
		</div>
	</form>';
}
?>