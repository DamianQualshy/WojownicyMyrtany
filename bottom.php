			<div class="footer" style="margin-bottom: 10px; clear: both;">
			    <div class="postheader"><h1 style="text-align: right; margin-right: 25px;"><a style="color: goldenrod;" href="kontakt.php">Panel Kontaktowy</a> <a href="autorzy.php">Autorzy</a></h1></div>
	            <div class="postcontent" align="center">
                    <p>Prawa autorskie &copy <?php echo date('Y'); ?> Gothic po Chamsku. Zawiera materiały z gry Gothic, należącej do Piranha Bytes. Wszelkie prawa zastrzeżone.</p>				
			    </div>
				<div class="postfooter"></div>
		    </div>
        </div>
	</div>
</div>

</body>
</html>

<?php
if($nie_index == 1)
{
	echo '<script>
		function panel()
		{
			$.ajax
			(
			{
				async: true,
				type: "POST",
				url: "/includes/panel.php",
				success: function (html)
				{
					$("#dane_gracza").html(html);		
				}  
			}
			);
		}

		function menu()
		{
			$.ajax
			(
			{
				async: true,
				type: "POST",
				url: "/includes/nawigacja.php",
				success: function (html)
				{
					$("#menu_nawigacja").html(html);		
				}  
			}
			);
		}

		panel();
		menu();

		setInterval(function() {
		  panel();
		}, 10000);

		setInterval(function() {
		  menu();
		}, 10000);
		</script>';
}

mysqli_close($GLOBALS['db']);
?>