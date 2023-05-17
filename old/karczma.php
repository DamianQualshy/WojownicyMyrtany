<?php
require_once('head.php');
?>

<div id="post" class="post">
    <div class="postheader"><h1>Karczma</h1></div>
	<div class="postcontent">
	<div class="postbg" style="background: url(images/tla_strony/karczma.jpg);"></div>
	<div class="postbreak"></div>
		<?php
		if ($user -> get['zmeczenie'] != '0')
		{
			$cost = ceil($user -> get['zmeczenie'] * 2.5);
			if (isset($_POST['pij']))
			{
				if ($user -> get['kasa'] >= $cost)
				{
					mysqli_query($GLOBALS['db'], 'UPDATE `konta` SET `zmeczenie`="0", `kasa`=`kasa`-'.$cost.' WHERE `id`='.$user -> get['id']);
					echo '<div class="komunikat_s komwhite">Budzisz się następnego ranka... Łóżko nie było zbyt wygodne, ale czujesz się wypoczęty.</div>';
				}
				else echo '<div class="komunikat_s komwhite">Nie stać Cię!</div>';
			}
			else echo '<div class="komunikat_s komwhite">Witaj w karczmie! Jeśli chcesz się wyspać, koszt wynosi: '.$cost.' $. <form style="margin-bottom: 20px;" method="post" action="karczma.php"><input style="margin: 0 auto; margin-top: 10px; color: white;" class="gothbutton" name="pij" type="submit" value="Idź wypocząć" /></form></div>';
		}
		else echo '<div class="komunikat_s komwhite">Witaj w karczmie! Możesz tutaj przyjść i wypocząć, kiedy zajdzie taka potrzeba.</div>';


		include_once('includes/karczma_czat.php');
		?>	 
    </div>
    <div class="postfooter"></div>
</div>

<?php
require_once('bottom.php');
?>