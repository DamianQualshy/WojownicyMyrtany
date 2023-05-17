	#komunikat#
	<form action="#strona#" method="post" id="formularz">
		<link href="includes/kontakt/formularz.css" rel="stylesheet" type="text/css" />
		<table>
		<div>
			<tr style="height: 35px;">
			<td>
			<label><font style="font-size:17px;">Nick / Imię i nazwisko: </font> <span class="red">*</span></label>
			<td>
			<input class="formul" type="text" id="nick" name="nick" value="#nick#" />
			</tr>
		</div>
		<div>
			<tr style="height: 35px;">
			<td>
			<label>Adres e-mail: <span class="red">*</span></label>
			<td>
			<input class="formul" type="text" id="mail" name="mail" value="#mail#" />
			</tr>
		</div>
		<div>
			<tr style="height: 35px;">
			<td>
			<label>Temat formularza: <span class="red">*</span></label>
			<td>
			<input class="formul" type="text" id="temat" name="temat" value="#temat#" />
			</tr>
		</div>
		<div>
			<tr style="height: 160px;">
			<td>
			<label>Treść formularza: <span class="red">*</span></label>
			<td>
			<textarea id="tresc" name="tresc" >#tresc#</textarea>
			</tr>
		</div>
		</table>
		<div>
			<span class="red">*</span> - oznacza pola wymagane.
		</div>
		<div><br>
			<input class="gothbutton" id="buttonloginu" type="submit" value="Wyślij" />
		</div>
		
	</form>