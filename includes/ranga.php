<?php
if ($szukanie_gracz == true) // view.php
{
	$awatar_gracza = $szukanie_gracz -> awatar_domyslny;
	$poziom_gracza = $szukanie_gracz -> lvl;
}
else // postac.php
{
	$awatar_gracza = $user -> get['awatar_domyslny'];
	$poziom_gracza = $user -> get['lvl'];
}

if($poziom_gracza <= 4)
{
	echo 'Nowy';
}
else
{
	switch ($awatar_gracza)
	{
		case 0: $tytul = 'Podróżnik'; break;
		case 2: $tytul = 'Cień'; break;
		case 3: $tytul = 'Szkodnik'; break;
		case 4: $tytul = 'Nowicjusz'; break;
		default: $tytul = 'Podróżnik'; break;
	}
	echo $tytul;
}
?>