<?php
require_once('head.php');
?>

<div class="post">
    <div class="postheader"><h1>Praca</h1></div>
	<div class="postcontent">
	<div class="postbg" style="background: url(images/tla_strony/praca.jpg);"></div>
	<div class="postbreak"></div>
<script type="text/javascript">
function toggle(id) {
  var elem = document.getElementById(id);
  if(elem.style.display==''){ elem.style.display='none'; return; }
  elem.style.display='';
}
</script>
<?php
$zmeczenie = $user -> get['zmeczenie']+5;
$max_zmeczenie = $user -> get['max_zmeczenie'];
echo "<script type='text/javascript'>\n";
echo "var zmeczenie = $zmeczenie\n";
echo "var max_zmeczenie = $max_zmeczenie\n";
echo "</script>\n";
?>
<div id="div1" style="display: none;"></div>
<?php
if (isset($_POST['pracuj']))
{
	$check = mysqli_fetch_array(mysqli_query($GLOBALS['db'], 'SELECT `id`,`czas` FROM `prace` WHERE `id`='.$_POST['pracuj']));
	if ($check == true)
	{
		mysqli_query($GLOBALS['db'], "UPDATE `konta` SET `praca_czas`=".time()."+".$check['czas'].", `praca_aktywna`=1, `praca_id`=".$check['id']." WHERE `id`=".$user -> get['id']);
		$praca = mysqli_fetch_array(mysqli_query($GLOBALS['db'], 'SELECT `praca_czas` FROM `konta` WHERE `id`='.$user -> get['id']));
		
		$time = time();
		$czas2 = $praca['praca_czas'];
		$czas = $czas2-$time;
	}
	else $czas = 0;
} else $czas = 0;

if ($user -> get['praca_aktywna'] == 1)
{
	$praca = mysqli_fetch_array(mysqli_query($GLOBALS['db'], 'SELECT `praca_czas`,`praca_id` FROM `konta` WHERE `id`='.$user -> get['id']));
	$time = time();
	$czas2 = $praca['praca_czas'];
	$czas = $czas2-$time;
	
	if($czas <= 0)
	{
		$check = mysqli_fetch_array(mysqli_query($GLOBALS['db'], 'SELECT `id`,`kasa`,`zmeczenie` FROM `prace` WHERE `id`='.$praca['praca_id']));
		if ($check == true)
		{
			if($user -> get['zmeczenie']+$check['zmeczenie'] >= $user -> get['max_zmeczenie'])
			{
				echo '<div class="komunikat komred">Odpocznij trochę, zanim odbierzesz zyskane pieniącze.</div>';
			}
			else
			{
				mysqli_query($GLOBALS['db'], "UPDATE `konta` SET `kasa`=`kasa`+".$check['kasa'].", `praca_aktywna`=0, `praca_id`=0, `praca_czas`=0, `zmeczenie`=`zmeczenie`+".$check['zmeczenie']." WHERE `id`=".$user -> get['id']);
				echo '<div class="komunikat komgreen">Do twojego mieszka wpłynęły pieniądze: <b>'.$check['kasa'].'</b>.<br />Zmęczenie wzrosło o <b>'.$check['zmeczenie'].'</b></div>';
			}
		}
	}
	
} else $czas = 0;

echo "<script>
var tak = false;
var intervalHandler;

function stoper2()
{
	if(zmeczenie <= max_zmeczenie)
	{
		toggle('div1');
		stoper1();
	}
	else
	{
	document.print('Jesteś zbyt zmęczony, aby pracować');
	}
}

function stoper1()
{
	tak=true;
	ile=".$czas.";
	intervalHandler = setInterval(stoper,1000);
	stoper();
}

function stoper()
{
	if(tak==true)
	{
		godzin=Math.floor(ile/3600);

		minut=Math.floor(ile/60)%60;
		sekund =ile%60;

		document.getElementById('div1').innerHTML = '<center>Pozostało: <b>'+godzin+'</b>h <b>'+minut+'</b>min <b>'+sekund+'</b>s</center><br/ >';
		ile--;
		if(ile<0)
		{
			clearInterval(intervalHandler);
		}
		if(ile==0-1)
		{
			toggle('div1');
			tak=false;
			window.location='praca.php'
		}
	}
}
</script>";
$stoper = '';
if (isset($_POST['pracuj']))
{
	$check = mysqli_fetch_array(mysqli_query($GLOBALS['db'], 'SELECT `id`,`czas` FROM `prace` WHERE `id`='.$_POST['pracuj']));
	if ($check == true)
	{
		$stoper =  '<script>stoper2();</script>';
	}
}

$praca_aktywna = mysqli_fetch_array(mysqli_query($GLOBALS['db'], 'SELECT `praca_aktywna` FROM `konta` WHERE `id`='.$user -> get['id']));
if ($praca_aktywna['praca_aktywna'] == 1)
{
	$stoper =  '<script>stoper2();</script>';
}
echo $stoper;
?>

<div id="kasa_gracza"></div>
<?php
	$a = mysqli_query($GLOBALS['db'], "SELECT * FROM `prace` ORDER BY `czas` ASC");
	while($item = mysqli_fetch_array($a))
	{
		if($user -> get['zmeczenie']+$item['zmeczenie'] >= $user -> get['max_zmeczenie'])
		{
			$zmeczony = 'color:#6b7272;'; $kup = 'Pracuj';
		}
		else
		{
			$zmeczony = 'color:#c4b61d;'; $kup = '<form method="post" action="praca.php"><input type="hidden" name="pracuj" value="'.$item['id'].'" /><input id="wskaz" value="Pracuj" style="cursor: pointer; text-align: left; width: 82px; font-style: italic; font-size: 25px; color: gold; background: none; border: none; font-weight: bold;" type="submit" /></form>';
		}
		
		$ik = '<div style="background: url(/images/prace/'.$item['ikonka'].'.png); margin: 19px auto auto auto; position: absolute; top: 0; left: 0; bottom: 0; right: 0; max-width: 100px; max-height: 100px;"></div>';
		echo '<table style="margin: 0px auto;">
			  <tr>
				<th style="background: url(images/bck.png) no-repeat center 5px; background-size: 130px 130px; position: relative; width: 130px; height: 130px; padding-right: 30px;" rowspan="5">'.$ik.'</th>
				<th style="font-style: italic; padding-bottom: 10px;">'.$item['nazwa'].'</th>
				<th></th>
			  </tr>
			  <tr>
				<td style="width: 275px;">Kasa</td>
				<td style="width: 55px;">'.$item['kasa'].'</td>
			  </tr>
			  <tr>
				<td style="width: 275px;">Zmęczenie</td>
				<td style="width: 55px;">'.$item['zmeczenie'].'</td>
			  </tr>
			  <tr>
				<td style="width: 275px;">Czas</td>
				<td style="width: 55px;">'.$item['czas'].'</td>
			  </tr>
			  <tr>
				<td style="'.$zmeczony.' font-weight: bold; font-size: 25px; font-style: italic; padding-top: 25px;">'.$kup.'</td>
				<td></td>
			  </tr>
			  </table><br />';
	}
?>
    </div>
    <div class="postfooter"></div>
</div>
<?php
require_once('bottom.php');
?>	 