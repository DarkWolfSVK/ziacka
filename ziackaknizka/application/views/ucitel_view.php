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
 	<body>
 		<header  class="page-header header-logged">
			<h1> Vitaj
			<?php	
			if (isset($data))	{echo $data->meno.' '.$data->priezvisko; } ?></h1>
   			<a href="home/logout" class="pull-right btn btn-info btn-sm logout-button">Odhlásiť sa</a>
   		</header>
   		<main>

   		</main>
		<script type="text/javascript">
		   			$(document).ready(function(){
		   				$.getJSON("ajax/ucitel", function(data){

		   					$.each(data.triedy, function(i,trieda)
		   					{
		   						var class_teacher;
		   						$.each(data.ucitelia,function(j,ucitel)
		   						{
		   							if (ucitel.trieda != trieda.id) return;
		   							class_teacher = $('<h4 class="triedny">'+ucitel.meno + ' ' + ucitel.priezvisko+'</h4>');
		   						});
								$('main').append(class_teacher);

								var table = $('<table class="table table-bordered table-hover"></table>');
								var nadpis = $('<tr class="info"></tr>');
								nadpis.append('<th>'+trieda.trieda+'</th>');
								$.each(data.predmety, function(j,predmet)
								{
									nadpis.append('<th>'+predmet.nazov+'</th>');
								});
								table.append(nadpis);
								$.each(data.ziaci, function(j,ziak)
								{
									if (ziak.trieda != trieda.id) return;
									var riadok = $('<tr data-id="'+ziak.id+'"></tr>');
									riadok.append('<td>'+ziak.meno + ' ' + ziak.priezvisko+'</td>');
									$.each(data.predmety, function(k,predmet)
									{
										var znmk = [];
										if(typeof data.znamky[ziak.id] != 'undefined' && typeof data.znamky[ziak.id][predmet.id] == 'object')
										{
											$.each(data.znamky[ziak.id][predmet.id], function(znamkaid,znamka){
												znmk.push('<a href="ajax/deleteznamka/'+znamkaid+'" class="ajax">'+znamka+"</a>");
											//	znmk.push(Math.round(znamka.reduce(function(a, b) { return parseInt(a) + parseInt(b); }) / znamka.length*1000)/1000);
											});
										}
										riadok.append('<td data-id="'+predmet.id+'">'+znmk.join(', ')+'</td>');
									});
									table.append(riadok);
								});
								$('main').append(table);
								var pridaj = $('<form class="form-inline .sr-only pridaj-znamku" action="ajax/addznamka/"></form>');
								var meno = $('<select name="ziak" class="form-control"></select>');
								$.each(data.ziaci, function(j,ziak)
								{
									if (ziak.trieda != trieda.id) return;
									meno.append('<option value="' + ziak.id + '">'+ziak.meno + ' ' + ziak.priezvisko+'</option>');
								});	
								pridaj.append(meno);

								var predmet_select = $('<select name="predmet" class="form-control"></select>');
								$.each(data.predmety, function(j,predmet)
								{
									predmet_select.append('<option value="' + predmet.id + '">'+predmet.nazov+'</option>');
								});
								pridaj.append(predmet_select);

								var znamky_select = $('<select name="znamky" class="form-control"><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option></select>');
								pridaj.append(znamky_select);

								var tlacitko_pridaj = $('<button type="submit" class="pridaj btn btn-primary btn-sm"> Pridaj známku</button>');
								pridaj.append(tlacitko_pridaj);
								$('main').append(pridaj);

		   					});
		   				});
 
		   				$(document).on('click','.ajax',function() {
		   					if(!confirm('Naozaj zmazat tuto znamku?')) return false;
		   					var znamka = $(this);
			   				$.getJSON(znamka.attr("href"), function(data){
			   					console.log(data);
			   					if(data.result == true)
			   					{
			   						var bunka = $(znamka).parents('td');
			   						znamka.remove();
			   						$(bunka).html($(bunka).html().replace(/((^| ), |, $)/,' '));
			   					}
			   					else
			   					{
			   						alert('chyba mazania');
			   					}

			   				}).fail(function() {
							    console.log( "error" ); // TODO
							});
							return false;
		   				});
		   				$(document).on('submit','form',function() {
		   					if(!confirm('Naozaj pridat tuto znamku?')) return false;
		   					var scope = $(this);
		   					var znamka = $('select[name="znamky"]', scope).val();
		   					var ziak = $('select[name="ziak"]', scope).val();
		   					var predmet = $('select[name="predmet"]', scope).val()
		   					var link = $(this).attr("action") + ziak + "/" + predmet + "/" + znamka;
		   					if (znamka == null || ziak == null || predmet == null) return false
			   				$.getJSON(link, function(data){
			   					console.log(data);
			   					if(data.result != 0)
			   					{
			   						if ($('tr[data-id="'+ziak+'"] td[data-id="'+predmet+'"]').text() == '')
			   						{
			   						$('tr[data-id="'+ziak+'"] td[data-id="'+predmet+'"]').append('<a href="ajax/deleteznamka/'+data.result+'" class="ajax">'+znamka+'</a>');
			   						}
			   						else
			   						{
			   						$('tr[data-id="'+ziak+'"] td[data-id="'+predmet+'"]').append(', <a href="ajax/deleteznamka/'+data.result+'" class="ajax">'+znamka+'</a>');
			   						}
			   					}
			   					else
			   					{
			   						alert('chyba mazania');
			   					}

			   				}).fail(function() {
							    console.log( "error" );
							});
							return false;
		   				});
		   			});

		   		</script>


 	</body>
</html>