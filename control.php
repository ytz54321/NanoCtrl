<html>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <title>魚缸生態主控台</title>

  <link rel="stylesheet" href="css/honeySwitch.css">
  <link rel="stylesheet" href="css/main.css">

  <script type="text/javascript" src="js/highcharts.js"></script>
  <script type="text/javascript" src="js/highcharts-more.js"></script>
  <script type="text/javascript" src="js/jquery.js"></script>
  <script type="text/javascript" src="js/solid-gauge.js"></script>
  <script type="text/javascript" src="js/honeySwitch.js"></script>
  




  <script type="text/javascript">
    
	$(document).ready(function () {
		
      //判斷當開關作動時要做的事情
	  switchEvent("#relay1",function(){relay_change(1,1);},function(){relay_change(1,0);});
	  switchEvent("#relay2",function(){relay_change(2,1);},function(){relay_change(2,0);});
	  switchEvent("#relay3",function(){relay_change(3,1);},function(){relay_change(3,0);});
	  switchEvent("#relay4",function(){relay_change(4,1);},function(){relay_change(4,0);});
	  switchEvent("#relay5",function(){relay_change(5,1);},function(){relay_change(5,0);});
	  switchEvent("#relay6",function(){relay_change(6,1);},function(){relay_change(6,0);});


	  Highcharts.setOptions({
		    chart: {
				type: 'solidgauge',
				backgroundColor:'#00000000',
			},
		    title: null,
		    pane: {
			  	center: ['50%', '85%'],
				  size: '145%',
				  startAngle: -90,
			  	  endAngle: 90,
			  	background: {
						backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || '#EEE',
						innerRadius: '60%',
						outerRadius: '100%',
						shape: 'arc'
				}
		  },
		  tooltip: {
				enabled: false
		  },
		  yAxis: {
				stops: [
						[0.1, '#55BF3B'], // green
						[0.3, '#DDDF0D'], // yellow
						[0.8, '#DF5353'] // red
				],
				lineWidth: 0,
				minorTickInterval: null,
				tickPixelInterval: 400,
				tickWidth: 0,
				title: {
						y: -70
				},
				labels: {
						y: 16
				}
		  },
		  plotOptions: {
				solidgauge: {
					dataLabels: {
						y: 5,
						borderWidth: 0,
						useHTML: true

					}
				}
		  }
      });
      //空氣濕度
      var chart1 = Highcharts.chart('h_air', {
		  yAxis: {
				min: 0,
				max: 100,
				title: {
					text: null,
					style:{
						fontSize:'25px',
						color:'#ffffff'
					}
				}
		  },
		  credits: {
				enabled: false
		  },
		  series: [{
				name: '濕度',
				data: [100],
				dataLabels: {
					format: '<div style="text-align:center"><span style="font-size:20px;color:' +
					((Highcharts.theme && Highcharts.theme.contrastTextColor) || 'blue') + '">{y}</span><br/>' +
					'<span style="font-size:10px;color:black">%</span></div>'
				},
				tooltip: {
						valueSuffix: ' %'			
				}
		  }]
      });

      //空氣溫度
	  var chart2 = Highcharts.chart('t_air', {
		  yAxis: {
				min: 20,
				max: 40,
				title: {
					text: null,
					style:{
						fontSize:'25px',
						color:'#ffffff'
					}
				}
		  },
		  credits: {
				enabled: false
		  },
		  series: [{
				name: '溫度',
				data: [40],
				dataLabels: {
					format: '<div style="text-align:center"><span style="font-size:20px;color:' +
					((Highcharts.theme && Highcharts.theme.contrastTextColor) || 'blue') + '">{y}</span><br/>' +
					'<span style="font-size:10px;color:black">度</span></div>'
				},
				tooltip: {
						valueSuffix: '度'
				}
		  }]
      });

      //體感溫度
	  var chart3 = Highcharts.chart('heat_air', {
		  yAxis: {
				min: 20,
				max: 40,
				title: {
					text: null,
					style:{
						fontSize:'25px',
						color:'#ffffff'
					}
				}
		  },
		  credits: {
				enabled: false
		  },
		  series: [{
				name: '溫度',
				data: [40],
				dataLabels: {
					format: '<div style="text-align:center"><span style="font-size:20px;color:' +
					((Highcharts.theme && Highcharts.theme.contrastTextColor) || 'blue') + '">{y}</span><br/>' +
					'<span style="font-size:10px;color:black">度</span></div>'
				},
				tooltip: {
						valueSuffix: '度'
				}
		  }]
      });

      //水中溫度
	  var chart4 = Highcharts.chart('t_water', {
		  yAxis: {
				min: 20,
				max: 40,

				title: {
					text: null,
					style:{
						fontSize:'25px',
						color:'#ffffff'
					}
				}
		  },
		  credits: {
				enabled: false
		  },
		  series: [{
				name: '溫度',
				data: [40],
				dataLabels: {
					format: '<div style="text-align:center"><span style="font-size:20px;color:' +
					((Highcharts.theme && Highcharts.theme.contrastTextColor) || 'blue') + '">{y}</span><br/>' +
					'<span style="font-size:10px;color:black">度</span></div>'
				},
				tooltip: {
						valueSuffix: '度'
				}
		  }]
      });

      // 定時更新
      setInterval(function () {

		//ajax取資料狀態
		var h_air, h_air, t_air, heat_air, t_water, relay1_state, relay2_state, relay3_state, relay4_state, relay5_state;
		
			$.ajax({
    			type: "GET",
    			url: "data/data.txt",
				dataType:"json",
    			success: function(data){
					var point;
					h_air = parseFloat(data.h_air);
		    		t_air = parseFloat(data.t_air);
					heat_air = parseFloat(data.heat_air);
					t_water = parseFloat(data.t_water);
					datatime = data.datetime;

					if (chart1) {point = chart1.series[0].points[0];point.update(h_air);}
					if (chart2) {point = chart2.series[0].points[0];point.update(t_air);}
					if (chart3) {point = chart3.series[0].points[0];point.update(heat_air);}
					if (chart4) {point = chart4.series[0].points[0];point.update(t_water);}

					relay1_state = parseInt(data.relay1);
					relay2_state = parseInt(data.relay2);
					relay3_state = parseInt(data.relay3);
					relay4_state = parseInt(data.relay4);
					relay5_state = parseInt(data.relay5);
					relay6_state = parseInt(data.relay6);

					if(relay1_state == 1) { honeySwitch.showOn("#relay1"); } else { honeySwitch.showOff("#relay1"); }
					if(relay2_state == 1) { honeySwitch.showOn("#relay2"); } else { honeySwitch.showOff("#relay2"); }
					if(relay3_state == 1) { honeySwitch.showOn("#relay3"); } else { honeySwitch.showOff("#relay3"); }
					if(relay4_state == 1) { honeySwitch.showOn("#relay4"); } else { honeySwitch.showOff("#relay4"); }
					if(relay5_state == 1) { honeySwitch.showOn("#relay5"); } else { honeySwitch.showOff("#relay5"); }
					if(relay6_state == 1) { honeySwitch.showOn("#relay6"); } else { honeySwitch.showOff("#relay6"); }
					$("#time").text(datatime);
				}
			});
		
		
		
		////

	  }, 1000);

	  function relay_change(r,s){
		if(r==1){$.ajax({type: "GET",url: "GetData.php?upload&",data: {relay1:s}});}
		else if(r==2){$.ajax({type: "GET",url: "GetData.php?upload&",data: {relay2:s}});}
		else if(r==3){$.ajax({type: "GET",url: "GetData.php?upload&",data: {relay3:s}});}
		else if(r==4){$.ajax({type: "GET",url: "GetData.php?upload&",data: {relay4:s}});}
		else if(r==5){$.ajax({type: "GET",url: "GetData.php?upload&",data: {relay5:s}});}
		else if(r==6){$.ajax({type: "GET",url: "GetData.php?upload&",data: {relay6:s}});}
	  }

      //////
});

</script>

</head>

<body style="font-family: Microsoft JhengHei;">
  <div id="Header">
  	<div id="Tittle">
		  <div id="img" style="width:13%; height:95%; background-image:url('img/icon.png');float: left;background-size:contain;background-repeat:no-repeat"></div>
		  <div id="tittle_text" style="width:80%; height:100%; margin-top:1.4%; margin-bottom:1%; margin-left:16%; position:absolute;float: left; ">智慧魚缸監控與自動化控制系統</div>
	</div>
  
  
  
  
  </div>
  
  
  <div id="Sidebar">
	<div id="button">房間</div>
	
	<div id="button">客廳</div>
	
  
  </div>
  
  
  <div id="Content">
   	<div id="Thr">
		<div id="constom">
			<div id="block">
				<div id="thr_textbox" style="background-color:#ffffff90;border-top-left-radius:10px;">空氣濕度</div>
				<div id="h_air" style="width:100%; height:80%;float: left; background-color:#dddddd90;border-bottom-left-radius:10px; "></div>
			</div>
			<div id="block">
				<div id="thr_textbox" style="background-color:#eeeeee90;">空氣溫度</div>
				<div id="t_air" style="width:100%; height:80%; float: left; background-color:#bbbbbb90;"></div>
			</div>
			<div id="block">
				<div id="thr_textbox"style="background-color:#ffffff90;">體感溫度</div>
				<div id="heat_air" style="width:100%; height:80%; float: left background-color:#dddddd90;" ></div>
			</div>
			<div id="block">
				<div id="thr_textbox"style="background-color:#eeeeee90;border-top-right-radius:10px;">水中溫度</div>
				<div id="t_water" style="width:100%; height:80%; float: left;background-color:#bbbbbb90;border-bottom-right-radius:10px;"></div>
			</div>
			
			
		</div>
  	</div>

  	<div id="Relay">
  		<div style="float:left"><p>電器一號：</p><span class="switch-off" themeColor="gold" id="relay1"></span></div>
  		<div style="float:left"><p>電器二號：</p><span class="switch-off" themeColor="gold" id="relay2"></span></div>
  		<div style="float:left"><p>電器三號：</p><span class="switch-off" themeColor="gold" id="relay3"></span></div>
    	<div style="float:left"><p>電器四號：</p><span class="switch-off" themeColor="gold" id="relay4"></span></div>
    	<div style="float:left"><p>電器五號：</p><span class="switch-off" themeColor="gold" id="relay5"></span></div>
    	<div style="float:left"><p>電器六號：</p><span class="switch-off" themeColor="gold" id="relay6"></span></div>
  	</div>
	
	
	
	<div>
		
	</div>

	
	<div id="bottom">
	<a>開關狀態: </a><a id="F">顯示在這</a><a>    繼電器接收狀態:</a><a id="d">顯示於這</a><a>資料時間:</a><a id="time">顯示時間在此</a>
	<?php
			//讀取目前資料
			$file = file_get_contents("data/data.txt"); //資料
			
			//Json解碼
			$json = json_decode($file, true);
			
			//溫溼度變數定義
			$h_air = $json['h_air'];
			$t_air = $json['t_air'];
			$heat_air = $json['heat_air'];
			$t_water = $json['t_water'];
			$datetime = $json['datetime'];
			//開關變數定義
			$relay1_state = $json['relay1'];
			$relay2_state = $json['relay2'];
			$relay3_state = $json['relay3'];
			$relay4_state = $json['relay4'];
			$relay5_state = $json['relay5'];
			$relay6_state = $json['relay6'];
			//回報所有值(測試用)
			echo $relay1_state, $relay2_state, $relay3_state, $relay4_state, $relay5_state, $relay6_state . '<br/>';
			echo $h_air, $t_air, $heat_air, $t_water, $datetime;
 		?>
	</div>



  </div>
  <div style='clear:both;'></div>




</body>

</html>




<!--暫存區
<iframe width="450" height="260" style="border: 1px solid #cccccc;" src="https://thingspeak.com/channels/507442/charts/1?bgcolor=%23ffffff&color=%23d62020&dynamic=true&results=60&title=%E9%AD%9A%E7%BC%B8%E6%B0%B4%E6%BA%AB&type=line&xaxis=%E6%99%82%E9%96%93&yaxis=%E6%BA%AB%E5%BA%A6&yaxismax=35&yaxismin=25">
</iframe>

<iframe width="450" height="260" style="border: 1px solid #cccccc;" src="https://thingspeak.com/channels/507442/charts/2?bgcolor=%23ffffff&color=%23d62020&dynamic=true&results=60&title=%E5%AE%A4%E5%85%A7%E6%BA%AB%E5%BA%A6&type=line&xaxis=%E6%99%82%E9%96%93&yaxis=%E6%BA%AB%E5%BA%A6&yaxismax=35&yaxismin=25">
</iframe>

<iframe width="450" height="260" style="border: 1px solid #cccccc;" src="https://thingspeak.com/channels/507442/charts/3?bgcolor=%23ffffff&color=%23d62020&dynamic=true&results=60&title=%E5%AE%A4%E5%85%A7%E6%BA%BC%E5%BA%A6&type=line&xaxis=%E6%99%82%E9%96%93&yaxis=%E6%BF%95%E5%BA%A6&yaxismax=100&yaxismin=30"></iframe>
-->