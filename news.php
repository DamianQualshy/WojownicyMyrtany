<?php require_once('head_index.php'); ?>
				<div class="post">
					<div class="postheader"><h1>Nowości oraz ogłoszenia</h1></div>
					<div class="postcontent">
					<?php
					$post = mysqli_query($GLOBALS['db'], 'SELECT * FROM `news` ORDER BY `id` DESC LIMIT 3');
					if(mysqli_num_rows($post) > 0)
					{
						while($i = mysqli_fetch_object($post))
						{
								$str     = $i -> text;
								$order   = array("\r\n", "\n", "\r");
								$replace = '<br />';
								$newstr = str_replace($order, $replace, $str);

								$str2     = ''.$newstr.'';
								$order2   = array("&lt;br /&gt;");
								$replace2 = '';
								$newstr2 = str_replace($order2, $replace2, $str2);

								echo '<p>'.$i -> date;
								echo ', '.$i -> time;
								echo '</p>';
								echo '<h3 style="padding-left: 20px; padding-right: 20px;" >'.$newstr2.'</h3>';
								if(mysqli_num_rows($post) > 1)
								{
									echo '<br /><div src="images/article_separator.png" style="width: 410px;height: 11px;margin: 0 auto;background: url(images/article_separator.png);background-repeat: no-repeat;"></div><br />';
								}
						}
					}
					else echo '<p>Brak newsów</p>';
					echo '<h1 style="text-align: center;"><a style="margin: 0 auto; cursor: pointer" href="news.php">Pełna lista</a></h1>';
					?>
					</div>
					<div class="postfooter"></div>
				</div>
<?php require_once('bottom.php'); ?>