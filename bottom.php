			<div class="footer" style="margin-bottom: 10px; clear: both;">
			    <div class="postheader"></div>
	            <div class="postcontent" style="text-align: center; padding: 0px;">
                    <p>&copy <?php echo date('Y'); ?> Gothic po Chamsku | <a href="stopka.php">WIĘCEJ</a> | <a style="color: goldenrod;" href="kontakt.php">PANEL KONTAKTOWY</a></p>				
			    </div>
				<div class="postfooter"></div>
		    </div>
        </div>
	</div>
</div>

</body>
</html>
<script>
$(function() {
	$(".komunikat").delay(5000).fadeOut('slow');
	setTimeout(function(){  $(".komunikat").remove(); }, 6000);
});
<?php
if(isset($nie_index) && $nie_index == 1)
{
	echo 'function odswiez()
		{
			$.ajax
			(
			{
				async: true,
				type: "POST",
				url: "includes/nawigacja.php",
				data: ({php_self: "'.$_SERVER['PHP_SELF'].'"}),
				success: function (html)
				{
					$("#menu_nawigacja").html(html);		
				}  
			}
			);
			
			$.ajax
			(
			{
				async: true,
				type: "POST",
				url: "includes/panel.php",
				success: function (html)
				{
					$("#dane_gracza").html(html);		
				}  
			}
			);
		}

		odswiez();

		setInterval(function() {
		  odswiez();
		}, 10000);
		</script>';
}

mysqli_close($GLOBALS['db']);
?>