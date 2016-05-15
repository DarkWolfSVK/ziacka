<!DOCTYPE html>
<html>
	<head>
		<title>Žiacka Knižka</title>
		<script src="https://code.jquery.com/jquery-2.2.3.min.js"></script>
			<!-- Bootstrap -->
			<!-- Latest compiled and minified CSS -->
			<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
			<!-- Optional theme -->
			<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap-theme.min.css">

			<link rel="stylesheet" href="<?= base_url() ?>/css/main.css"/>
			<meta charset="utf-8" />
 	</head>
	</head>
	<body>
		<header>
   			<a href="home/logout" class="pull-right btn btn-info btn-sm">Odhlásiť sa</a>
			<h3> Vitaj 
			<?php	
			if (isset($data))	{echo $data->meno.' '.$data->priezvisko; } ?></h3>
   		</header>
   		<main>

   		</main>
   		<script type="text/javascript"> //<!--
   			$(document).ready(function(){
   				$.getJSON("ajax/ziak", function(data){
   					var table = $('<table class="table table-bordered table-hover"></table>');
   					table.append('<tr><th>Predmet</th><th>Znamky</th><th>Priemer</th></tr>');
   					$.each(data, function(k,v) {
   							table.append('<tr><td>'+k+'</td><td>'+v.join(', ')+'</td><td>'+Math.round(v.reduce(function(a, b) { return parseInt(a) + parseInt(b); }) / v.length*1000)/1000+'</td></tr>');
   					});
   					$('main').append(table);
   				});
   			});
		//-->
   		</script>

 	</body>
</html>