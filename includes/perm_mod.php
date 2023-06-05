<?php
if ($user -> get['rank'] == 'Admin' || $user -> get['rank'] == 'Moderator')
{}
else
{
    echo '<div class="post"><div class="postheader"></div><div class="postcontent">';
    echo '<div style="text-align: center; color: red;">Nie masz uprawnień, by przeglądać tą stronę!</div>';
	echo '</div><div class="postfooter"></div></div>';
	require_once('bottom.php');
	exit;
}
?>