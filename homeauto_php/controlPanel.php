<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>The Home System</title>
	<meta name="description" content="Home Automation">
	<meta name="author" content="Serkan KARAOT">
	<link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
	<link rel="stylesheet" href="cssjs/css/bootstrap.min.css">
	<link rel="stylesheet" href="cssjs/css/styles.css?v=1.0">
	<link rel="stylesheet" href="bower_components/chartist/dist/chartist.min.css">
	<link rel="stylesheet" href="bower_components/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.css">
	<link rel="stylesheet" href="bower_components/jQuery-ui-Slider-Pips/dist/jquery-ui-slider-pips.min.css">
	<link rel="stylesheet" href="bower_components/jquery-ui/jquery-ui.css">
</head>

<body>
	<div class="container well margin20">
		<div class='row'>
			<div class="col-sm-4 col-xs-10">
				<h3><img src='img/temperature-2-xxl.png' alt='Oda Sıcaklığı' class='tempICO'>My Heat Service</h3>
			</div>
			<div class="col-sm-8 col-xs-2 setPosition">
				<a href="kapatCik.php" class="btn btn-danger pull-right"><i class="glyphicon glyphicon-off"></i></a>
			</div>
		</div>

		<div class='row'>
			<div class="col-sm-2 col-xs-5 pull-left">
				<h3>
				<i class='glyphicon glyphicon-log-in small-text text-danger'></i> <?php echo number_format($oku[0]->sicaklik,2,'.',',');?> °C
				</h3>
			</div>
			<div class="col-sm-4 col-xs-7">
				<h3 id='outsideTemp'></h3>
			</div>
		</div>

		<!--<div class="col-sm-1 hidden-xs"></div>-->

		<div class='row'>
			<?php
                        $autoOnOffStatus = $al->autoControl=='on' ?  "checked" : "";
                        ?>

			<div class="col-sm-6 col-xs-8 setPosition hide" id="changeHeat">
				<input id='setforHeat' type='text' value='<?php echo $al->heatForDB; ?>' name='setforHeat'>
			</div>
			<div class="col-sm-6 col-xs-8 setPosition hide" id='autoStatusText'>
				<h4 class='text-success'><i class='glyphicon glyphicon-leaf text-success'></i> Otomatik Kontrol &nbsp;&nbsp;
				<a href='javascript:void(0);' data-toggle='openSett'><i class='glyphicon glyphicon-cog text-success'></i></a></h4>
			</div>

			<div class='col-sm-6 col-xs-4 setPosition'>
			<div class="onoffswitch pull-right">
			<input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch" <?php echo $autoOnOffStatus;?>>
				<label class="onoffswitch-label" for="myonoffswitch">
		        	<span class="onoffswitch-inner"></span>
			        <span class="onoffswitch-switch"></span>
				</label>
			</div>
			</div>
		</div>

		<!--
		<div class="col-sm-1 hidden-xs setPosition hide">
		<a href="kapatCik.php" class="btn btn-danger pull-right"><i class="glyphicon glyphicon-off"></i></a>
		</div>
		-->
	</div>
	<div id="sicaklikPaneli" class="settings container well margin20">
		<div class="row">
			<div class="pull-right" style='margin-right:15px;cursor:pointer;'>
			<i class='glyphicon glyphicon-remove' onclick="$('#sicaklikPaneli').fadeOut('slow');"></i>
			</div>
		</div>
		<div id="sicaklikDetay">

		</div>
	</div>
	<div class="container well margin20">
		<span class="text-center text-success">Sıcaklık değişim grafiği </span>
		<div class="pull-right">
		<i class="glyphicon glyphicon-fire<?php echo $fireStatus;?>" role="button" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php echo $lastRun; ?>"></i>
		&nbsp;&nbsp;&nbsp;<kbd>h/°C</kbd>
		</div>
		<div class="ct-chart ct-perfect-fourth"></div>
	</div>

  	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<!-- Include all compiled plugins (below), or include individual files as needed -->
	<script src="cssjs/js/bootstrap.min.js"></script>
	<script src="bower_components/chartist/dist/chartist.min.js"></script>
	<script src="bower_components/chartist-plugin-pointlabels/dist/chartist-plugin-pointlabels.min.js"></script>
	<script src="bower_components/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js"></script>
	<script src="bower_components/notifyjs/notify.js"></script>
	<script src="bower_components/jquery-ui/jquery-ui.min.js"></script>
	<script src="bower_components/jQuery-ui-Slider-Pips/dist/jquery-ui-slider-pips.min.js"></script>

	<script type="text/javascript">
	var date = [];
        var santigrat = [];

	$.getJSON("http://www.netustasi.com/slimTest/public/sicaklik/12", function(data){
		$.each(data, function(key, val){
		//console.log(key+" "+val);
		//console.log(Math.round(val.santigrat));
		santigrat.push(val.santigrat);
		timestamp = val.tarih;
		var jsDate = new Date(timestamp*1000);
		var dakika = jsDate.getMinutes()<10 ? '0'+jsDate.getMinutes() : jsDate.getMinutes();
		var getTime = jsDate.getHours()+":"+dakika;
		date.push(getTime);
		});
	}).done(function(){
		driweGraph();
	});

	function updateHeatValue(selector, level){
		var deger = level;
		var islem = "yaz";
		var id = 0;
		switch(selector){
		case 'sld0':id = 1;break;
		case 'sld1':id = 2;break;
		case 'sld2':id = 3;break;
		case 'sld3':id = 4;break;
		}
	$.getJSON("http://www.netustasi.com/slimTest/public/viewRule/"+islem+"/"+id+"/"+deger, function(data){});
	}

	function  driweGraph(){
		var data = {
                // A labels array that can contain any sort of values
                labels: date,
                // Our series array that contains series objects or in this case series data arrays
                series: [ santigrat ]
                };
                new Chartist.Line('.ct-chart',
		data,
		{
		low:0, showArea:true,fullWidth:true,
		plugins: [
  		Chartist.plugins.ctPointLabels({
	        textAnchor: 'middle'
   		})
		]
		}
		);
	}
	function havaDurumu(){
                $.ajax({
                type: "GET",
                //url: "http://dataservice.accuweather.com/locations/v1/318251?apikey=SMudRwHJALs9CGiHKmUoctMkdrcnTxi4&language=tr-TR&details=false",
		url:"http://api.openweathermap.org/data/2.5/weather?q=Istanbul,tr&appid=b90f65129504ce41aa891e544257de83&units=metric",
                dataType: "jsonp",
                        success: function(data){
				var santigrat = data.main.temp;
				//var ikon = "<img src='img/temperature-2-xxl.png' style='width:25px;height:auto;' alt='"+data.weather.icon+"'>";
				var ikon = "<i class='glyphicon glyphicon-log-out small-text text-primary'></i>";
				$('#outsideTemp').append(ikon+" "+santigrat+" °C");
                        }
                });
        }

	$('[data-toggle="openSett"]').click(function(e){
		//var caseValue = $(this).data("case");
		$('#sicaklikPaneli').fadeIn('fast');
		$('#sicaklikDetay').html("<h4 class='text-success'><i class='glyphicon glyphicon-leaf text-success'></i> Otomatik Program Sıcaklık Değerleri</h4>");
		$.getJSON("http://www.netustasi.com/slimTest/public/viewRule/oku", function(data){
			$.each(data, function (key,value){
				//console.log(value.derece);
				console.log(value);
				var label = value.haftaici == 1 ? "Hafta içi" : "Hafta sonu";
	 			var icerik = "<div class='row margin20'><div class='col-sm-1 hidden-xs'></div>";
				icerik += "<div class='col-sm-3 col-xs-12'><strong>"+ label +"</strong> <code>"+ value.baslangic +" | "+ value.bitis +"</code> <strong>arası</strong></div>";
				icerik += "<div class='col-sm-7 col-xs-12'><div class='slider"+ key +"' id='sld"+ key +"'></div></div>";
				icerik += "<div class='col-sm-1 hidden-xs'></div></div>";
		 		$("#sicaklikDetay").append(icerik);
		                $(".slider"+key).slider({
					min:21,
					max:40,
					value:value.derece,
					step:0.1,
					change:function(event, ui){
						//console.log($(this).attr('id'));
						//console.log(ui.value);
						updateHeatValue($(this).attr('id'), ui.value);
						}
				}).slider("float");
			});
		});
        });

	$(document).ready(function(){
        if($('#myonoffswitch').is(':checked')){$('#autoStatusText').removeClass('hide');}else{$('#changeHeat').removeClass('hide');}
	$('#myonoffswitch').change(function(e){
		var islem = "";
		if($('#myonoffswitch').is(':checked')){
	 		 islem = "aon";
			 $.notify("Otomatik Kontrol Devrede", "success");
			 $('#changeHeat').addClass('hide');
			 $('#autoStatusText').removeClass('hide');

		}else{
			 islem = "aoff";
			 $.notify("Manuel Kontrol Devrede", "success");
			 $('#autoStatusText').addClass('hide');
			 $('#changeHeat').removeClass('hide');
		}
	$.getJSON("http://www.netustasi.com/slimTest/public/viewRule/"+islem, function(data){});
	});

	$('#sicaklikPaneli').hide();
	$('[data-toggle=popover]').popover();
	$("input[name='setforHeat']").TouchSpin({
                min: 20,
                max: 50,
                step: 0.1,
                decimals: 2,
                boostat: 5,
                maxboostedstep: 10,
                postfix: '°C'
        });

	$("#setforHeat").change(function(){
		//console.log($(this).val());
		var sicak = $(this).val();
		$.get( "http://www.netustasi.com/slimTest/public/setHeatInDB/"+$(this).val(), function( data ) {

		}).done(function(){
			$.notify("Sıcaklık Güncellendi "+sicak, "success");
		});
	});
	havaDurumu();
	});
	</script>
</body>
</html>
