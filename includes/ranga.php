<?php
if($user -> get['lvl'] <= 4)
{
	echo 'Nowy';
}
else if($user -> get['lvl'] >= 5)
{
	if ($user -> get['awatar_domyslny'] == 3)
	{
		echo 'Nowicjusz';
	}
	else if ($user -> get['awatar_domyslny'] == 2)
	{
		echo 'Szkodnik';
	}
	else if ($user -> get['awatar_domyslny'] == 1)
	{
		echo 'Cień';
	}
	else
	{
		echo 'Podróżnik';
	}
}
?>