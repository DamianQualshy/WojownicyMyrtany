<?php
require_once('head.php');
?>
	<div class="post" style="font-size: 20px;">
    <div class="postheader"><h1>Zadania do wykonania</h1></div>
	<div class="postcontent">
<?php
	function mysqli_field_name($result, $field_offset)
	{
		$properties = mysqli_fetch_field_direct($result, $field_offset);
		return is_object($properties) ? $properties->name : null;
	}

	$pobierz = mysqli_query($GLOBALS['db'], "SELECT * FROM `zadania` WHERE `id_gracza`='".$user -> get['id']."'");
	$pobierz3 = mysqli_fetch_array($pobierz);
	$num_columns = mysqli_num_fields($pobierz);
	for ($i = 1; $i < $num_columns; $i++)
	{
		$arrusers[$i] = mysqli_field_name($pobierz, $i);
		
		$pobierz2 = mysqli_fetch_array(mysqli_query($GLOBALS['db'], "SELECT * FROM `zadania_dane` WHERE `nazwa_kolumna`='".$arrusers[$i]."'"));
		
		$postep = ($pobierz3[$i]*100)/$pobierz2['cel'];
		
		
		echo "<style>
				#my-progress-bar-".$i." {
					background: url(images/input_dlugi.png);
					background-size: 344px 36px;
					height: 34px;
					width: 342px;
					padding: 1px;
					margin: 0 auto;
					text-align: center;
					font-size: 15px;
					margin-top: 10px;
					text-shadow: 0px 0px 2px #000, 0px 0px 2px #000, 0px 0px 2px #000, 0px 0px 2px #000;
					box-shadow: inset 0px 0px 2px 3px rgba(0,0,0,0.5);
				}
				  
				#my-progress-bar-".$i."_after {
					display: block;
					background: url(images/postep.jpg);
					background-size: 330px 22px;
					width: ".$postep."%;
					height: 22px;
					margin: 6px 6px 0px 6px;
				}
				</style>";
		
		echo '<br /><div style="text-align: center; font-weight: bold;">'.$pobierz2['nazwa'].'</div>';
		echo '<div id="my-progress-bar-'.$i.'"><div style="width: 330px;"><div id="my-progress-bar-'.$i.'_after">'.$pobierz3[$i].'/'.$pobierz2['cel'].'</div></div></div>';
		echo '<div style="text-align: center;">Nagroda: '.$pobierz2['nagroda'].'</div>';
	}
?>
    </div>
    <div class="postfooter"></div>
</div>

<?php
require_once('bottom.php');
?>