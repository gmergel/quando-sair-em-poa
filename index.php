<?php ?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Visu</title>
		<style>
			body{margin:0;padding:0;background-color: #ccc;font-family: Helvetica, Arial;}
			h1{margin-bottom:0; color: #555;text-align: center;background: url("./line.png") repeat-x 47% 54%}
			span{background-color: white;padding: 0 12px;}
			#container{width: 1000px;height: 680px;background-color: white;margin: 60px auto auto auto;border-radius: 5px;box-shadow: 0px 6px 13px 0px #999;padding: 1px 15px;}
			.icon{width: 60px;}
			#dia{width: 38px;padding: 9px;}
			#sliderdot{width: 20px;height: 17px;background-color: #2980b9;border-radius: 6px;margin-left: 130px;margin-top: -11px;}
			#sliderbar{background-color: #ccc;height: 5px;margin: 0px 130px 0 130px;border-radius: 42px;}

			#controls{height: 40px;text-align: center;margin-top: 20px;width:200px;margin:auto;}
			#btn-play,#btn-stop{display: block; background-color: rgb(52, 152, 219); width: 60px; margin: auto; padding: 5px; border-top-left-radius: 5px; border-top-right-radius: 5px; border-bottom-right-radius: 5px; border-bottom-left-radius: 5px; color: white;box-shadow: 0 4px #2980b9; border:0; cursor: pointer;float:left;}
			#btn-stop{background-color:#e74c3c;box-shadow: 0 4px #c0392b;}
			#btn-play:active,#btn-stop:active{box-shadow: 0 3px #2980b9;padding-top: 3px;}

			#btn-prv, #btn-nxt{margin-right:20px;float:left;display: block; background-color: rgb(52, 152, 219); width: 30px; margin: auto 20px; padding: 5px; border-top-left-radius: 5px; border-top-right-radius: 5px; border-bottom-right-radius: 5px; border-bottom-left-radius: 5px; color: white;box-shadow: 0 4px #2980b9; border:0; cursor: pointer;}
			#date{margin: auto;text-align: center;}

			#options{margin: auto;width: 730px;}

		</style>
		<script src="jquery.js"></script>
		<script type="text/javascript" src="https://www.google.com/jsapi"></script>
		<script>
	google.load("visualization", "1", {packages:["corechart"]});
	google.setOnLoadCallback(drawChart);
	
	NMes = new Array();
	NMes[1] = "Janeiro";
	NMes[2] = "Fevereiro";
	NMes[3] = "Março";
	NMes[4] = "Abril";
	NMes[5] = "Maio";
	NMes[6] = "Junho";
	NMes[7] = "Julho";
	NMes[8] = "Agosto";
	NMes[9] = "Setembro";
	NMes[10] = "Outubro";
	NMes[11] = "Novembro";
	NMes[12] = "Dezembro";

	var parsedResult = [];
	var currentDate = 20091;
	var mes = NMes[1];

	var opts = {
		dia: true,
		noite: true
	}

	function addano(dir){
		var tmes = currentDate.toString().substr(4,2);
		var tano = currentDate.toString().substr(0,4);
		if(dir>0) tmes++; else tmes--;

		if(tmes>12){
			tmes = '1';
			tano++;
		}
		if(tmes<1){
			tmes = '12';
			tano--;
		}
		currentDate = (tano+tmes);
		mes = NMes[tmes];
	}

	function drawChart() {

		var data = new google.visualization.DataTable();
		
		data.addColumn('string','Dia da semana',1);
		data.addColumn('number','Posicao',2);
		data.addColumn('number','Feridos',3);
		data.addColumn('string','Regiao',4);
		data.addColumn('number','Acidentes',5);

		data.addRow(['', 0.5, 0, 'Segunda', 0]);
		data.addRow(['', 1.5, 0, 'Terca', 0]);
		data.addRow(['', 2.5, 0, 'Quarta', 0]);
		data.addRow(['', 3.5, 0, 'Quinta', 0]);
		data.addRow(['', 4.5, 0, 'Sexta', 0]);
		data.addRow(['', 5.5, 0, 'Sabado', 0]);
		data.addRow(['', 6.5, 0, 'Domingo', 0]);

		var options = {
			chartArea:{width:"620px",height:"720px"}
			,title: ''
			,hAxis: {title: '', gridlines: {color: '#ccc', count: 4}, viewWindow: {min: 0, max: 7.5}, ticks: [{v:0.5, f:"Segunda-feira"}, {v:1.5, f:"Terca-feira"}, {v:2.5, f:"Quarta-feira"}, {v:3.5, f:"Quinta-feira"}, {v:4.5, f:"Sexta-feira"}, {v:5.5, f:"Sabado"}, {v:6.5, f:"Domingo"}, {v:7.5, f:""}]}
			,vAxis: {title: 'Feridos', gridlines: {color: '#ccc', count: 4}, viewWindow: {min: 0, max: 210}, ticks: [0,30,60,90,120,150,180,210]}
			,sizeAxis: {maxSize: 50, minSize: 20}
			,colors: ['#71C6C1', '#7ab800', '#F2AF00', '#FF7700', '#DC5034', '#B7295A', '#6E2585', '#317b77', '486C00', 'B48100', 'AC5200', 'A0321C', '811D3E', '4B195B']
			,bubble: {textStyle: {fontSize: 13, fontName: 'Helvetica', color: '#333'}, stroke: '#eee'}
			,explorer: { maxZoomIn: .25, maxZoomOut: 4, zoomDelta: 1.5}
			,animation: { easing: 'in', duration: 100}
		};

		var chart = new google.visualization.BubbleChart(document.getElementById('chart_div'));

		function drawit(chartopts) {
			var drawopts = chartopts || options;
			chart.draw(data, drawopts);
		}

		$('#btn').click(function(){
			loadDataCVS(2008);
		});

		$('#fake').click(function(){
			var newv = data.getValue(0,2)-1;
			data.setValue(0,2,newv);
			drawit();
		});

		$('#btn-nxt').click(function(e,playing){
			if(!playing) $('#btn-stop').trigger('click');
			if(currentDate == 201312){ $('#btn-stop').trigger('click'); return; }
			$('#sliderdot').css('margin-left',parseInt($('#sliderdot').css('margin-left'))+10);
			addano(1);
			loadDataTable(parsedResult[currentDate.toString().substr(0,4)]);
		});

		$('#btn-prv').click(function(){
			$('#btn-stop').trigger('click');
			if(currentDate == 20081) return;
			$('#sliderdot').css('margin-left',parseInt($('#sliderdot').css('margin-left'))-10);
			addano(-1);
			loadDataTable(parsedResult[currentDate.toString().substr(0,4)]);
		});

		$('#btn-dianoite').click(function(){
			opts.diaenoite++;
			if(opts.diaenoite == 3) opts.diaenoite = 0;
			loadDataTable(parsedResult[currentDate.toString().substr(0,4)]);
		});

		$('#dia').click(function(){
			if($(this).css('opacity') == 1){ $(this).css('opacity','0.2'); opts.dia = false; }
			else{ $(this).css('opacity',1); opts.dia = true; }

			setTimeout(function(){
				if(!opts.dia && !opts.noite){
					$('#dia').css('opacity',1);
					$('#noite').css('opacity',1);

					opts.dia = true; opts.noite = true;
				}	
			},400);
			
		});
		$('#noite').click(function(){
			if($(this).css('opacity') == 1){ $(this).css('opacity','0.2'); opts.noite = false; }
			else{ $(this).css('opacity',1); opts.noite = true; }

			setTimeout(function(){
				if(!opts.dia && !opts.noite){
					$('#dia').css('opacity',1);
					$('#noite').css('opacity',1);

					opts.dia = true; opts.noite = true;
				}	
			},400);
		});

		var inter;

		$('#btn-play').click(function(){
			$('#btn-stop').css('display','block');
			$('#btn-play').css('display','none');
			inter = setInterval(function(){
				$('#btn-nxt').trigger('click', true);
			},800);
		});

		$('#btn-stop').click(function(){
			clearInterval(inter);
			
			$('#btn-stop').css('display','none');
			$('#btn-play').css('display','block');

		});

		$('#seg').click(function(){
			data.addRow(['', 0.75, 0, 'Segunda Noite', 0]);
			data.setValue(0,1,0.25);

			data.addRow(['', 1.75, 0, 'Terca Noite', 0]);
			data.setValue(1,1,1.25);

			data.addRow(['', 2.75, 0, 'Quarta Noite', 0]);
			data.setValue(2,1,2.25);

			data.addRow(['', 3.75, 0, 'Quinta Noite', 0]);
			data.setValue(3,1,3.25);

			data.addRow(['', 4.75, 0, 'Sexta Noite', 0]);
			data.setValue(4,1,4.25);

			data.addRow(['', 5.75, 0, 'Sabado Noite', 0]);
			data.setValue(5,1,5.25);

			data.addRow(['', 6.75, 0, 'Domingo Noite', 0]);
			data.setValue(6,1,6.25);

			//options.vAxis.viewWindowMode = 'maximized';
			drawit();
		});		

		function loadDataCVS(year){

			if(year == 2007 || year == 2014) return;

			$.get('./reader.php?ano='+year).success(function(res){
				parsedResult[year] = $.parseJSON(res);
				currentDate = year+'1';
				loadDataTable(parsedResult[year]);
			});
		}

		function loadDataTable(jsondata){

			if(typeof jsondata === 'undefined' || !('a'+currentDate in jsondata)){
				loadDataCVS(currentDate.toString().substr(0,4));
				return;
			}

			var jsonResult = jsondata['a'+currentDate];

			for(var key in jsonResult){
				switch(key){
					case 'SEGUNDA':
						row = 0;
						break;
					case 'TERCA':
						row = 1;
						break;
					case 'QUARTA':
						row = 2;
						break;
					case 'QUINTA':
						row = 3;
						break;
					case 'SEXTA':
						row = 4;
						break;
					case 'SABADO':
						row = 5;
						break;
					case 'DOMINGO':
						row = 6;
						console.warn('aaa');
						break;
					default:
						row = -1;
						break;
				}

				if(row!=-1){

					var feridosv = (opts.dia && opts.noite || (!opts.dia && !opts.noite))? jsonResult[key].Feridos : (opts.dia && !opts.noite)? jsonResult[key].DIA.Feridos : jsonResult[key].NOITE.Feridos;
					data.setValue(row, 2, feridosv);

					var acidentesv = (opts.dia && opts.noite || (!opts.dia && !opts.noite))? jsonResult[key].Acidentes : (opts.dia && !opts.noite)? jsonResult[key].DIA.Acidentes : jsonResult[key].NOITE.Acidentes;
					data.setValue(row, 4, acidentesv);
					console.log(data);
				}
			}
			drawit();
			$("#date").html(mes+" de "+currentDate.toString().substr(0,4));
		}
		drawit();
	}

	</script>
	</head>
	<body>
		<div id="container">
			<h1><span class="title">bla bla bla bla bla</span></h1>			
			<div id="chart_div" style="height: 380px"></div>
			
			<div id="controls"><button id="btn-prv"><</button><button id="btn-play" href="#" style="">Play</button><button id="btn-stop" style="display: none;" href="#">Stop</button><button id="btn-nxt">></button></div>
			<div id="sliderarea"><div id="sliderbar"></div><div id="sliderdot"></div></div><br/>
			<div id="date">Janeiro de 2008</div><br/>
			
			<div id="options">
				<a id="btn-dianoite" href="#"><img id="dia" class="icon" src="./icons/sun.png"/><img id="noite" class="icon" src="./icons/moon.png"/></a><br/>
				<a id="btn" href="#">Load</a><br/>
				

				<a href="#" id='seg'>Seg</a> | <a href="#">Ter</a> | <a href="#">Qua</a> | <a href="#">Qui</a><br/>
			</div>
		</div>
	</body>
</html>