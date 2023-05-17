<html>
<head>
	<title>Kwadraciki</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script>
	function getRandomColor() {
	  var letters = '0123456789ABCDEF';
	  var color = '#';
	  for (var i = 0; i < 6; i++) {
		color += letters[Math.floor(Math.random() * 16)];
	  }
	  return color;
	}
	
	var kwadrat = 1;
	function kw()
	{
		var i;
		for (i = 0; i < 17660; i++) { 
			$('#k'+i).css("background-color", getRandomColor());
		}
	}
	</script>
	<style>
	body
	{
		margin: 0px;
	}
	.kwadrat
	{
		background-color: cyan;
		width: 10px;
		height: 10px;
		float: left;
	}
	</style>
</head>
<body>
	<?php 
	for ($x = 0; $x <= 17660; $x++) {
		echo '<div id="k'.$x.'" class="kwadrat"></div>';
	}
	?>
	<script>
	setInterval(kw, 100);
	</script>
</body>
</html>