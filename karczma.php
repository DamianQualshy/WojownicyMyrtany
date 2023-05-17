<?php
require_once('head.php');
?>

<div class="post">
    <div class="postheader"><h1>Karczma</h1></div>
	<div class="postcontent">
	<div class="postbg" style="background: url(images/tla_strony/karczma.jpg);"></div>
	<div class="postbreak"></div>
		<?php
		if ($user -> get['zmeczenie'] != '0')
		{
			$cost = ceil($user -> get['zmeczenie'] * 3.5);
			echo '<p>Witaj w karczmie! Jeśli chcesz się wyspać, koszt wynosi: '.$cost.' $. <a href="karczma.php?get=pij">Idź wypocząć</a></p><br/>';
			if (isset($_GET['get']) && $_GET['get'] == 'pij')
			{
				if ($user -> get['kasa'] >= $cost)
				{
					mysqli_query($GLOBALS['db'], 'UPDATE `konta` SET `zmeczenie`="0", `kasa`=`kasa`-'.$cost.' WHERE `id`='.$user -> get['id']);
					echo '<p>Budzisz się następnego ranka... Łóżko nie było zbyt wygodne, ale czujesz się wypoczęty.</p><br/>';
				}
				else echo '<p>Nie stać Cię!</p><br/>';
			}
		}
		else echo '<p>Nie potrzebujesz snu!</p><br/>';


		include_once('includes/karczma_czat.php');
		?>	 
    </div>
    <div class="postfooter"></div>
</div>

<?php
require_once('bottom.php');
?>