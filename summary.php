<?php
require_once('head.php');

$fontwielkosc = 'font-size: 32px; color: #55a;';
$fontwielkosc1 = '32px';
$wielkosc = '140px';
$wielkosc_tla = '160px';

$tab_pic = 200;
$tab_pic_height = 287;
$tab_pic_margin = 10;
$tab_text = 610-$tab_pic-$tab_pic_margin;

$opis_size = 14;
?>
				<div class="post">
					<div class="postheader"><h1><?php echo $user -> get['nick'] ?></h1></div>
						<div class="postcontent">
						</div>
					<div class="postfooter"></div>
					</div>
	
<?php require_once('bottom.php'); ?>