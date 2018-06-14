<html>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <title>魚缸生態主控台</title>

  <link rel="stylesheet" href="css/honeySwitch.css">

  <script type="text/javascript" src="js/highcharts.js"></script>
  <script type="text/javascript" src="js/highcharts-more.js"></script>
  <script type="text/javascript" src="js/jquery.js"></script>
  <script type="text/javascript" src="js/solid-gauge.js"></script>
  <script type="text/javascript" src="js/honeySwitch.js"></script>




  <script type="text/javascript">
    $(document).ready(function () {
      //////
      $("on").click(function () {
        $.get("GetData_relay.php", { relay1: "1" });
      });

      $("off").click(function () {
        $.get("GetData_relay.php", { relay1: "0" });
      });

	  switchEvent("#relay1",function(){$.get("GetData_relay.php", { relay1: "1" });},function(){$.get("GetData_relay.php", { relay1: "0" });});
	  switchEvent("#relay2",function(){$.get("GetData_relay.php", { relay2: "1" });},function(){$.get("GetData_relay.php", { relay2: "0" });});
	  switchEvent("#relay3",function(){$.get("GetData_relay.php", { relay3: "1" });},function(){$.get("GetData_relay.php", { relay3: "0" });});
	  switchEvent("#relay4",function(){$.get("GetData_relay.php", { relay4: "1" });},function(){$.get("GetData_relay.php", { relay4: "0" });});
	  switchEvent("#relay5",function(){$.get("GetData_relay.php", { relay5: "1" });},function(){$.get("GetData_relay.php", { relay5: "0" });});
	  switchEvent("#relay6",function(){$.get("GetData_relay.php", { relay6: "1" });},function(){$.get("GetData_relay.php", { relay6: "0" });});



	  Highcharts.setOptions({
		    chart: {
				  type: 'solidgauge'
		    },
		    title: null,
		    pane: {
			  	center: ['50%', '85%'],
				  size: '100%',
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
					text: '空氣濕度'
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
					((Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black') + '">{y}</span><br/>' +
					'<span style="font-size:10px;color:silver">%</span></div>'
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
					text: '空氣溫度'
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
					((Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black') + '">{y}</span><br/>' +
					'<span style="font-size:10px;color:silver">度</span></div>'
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
					text: '體感溫度'
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
					((Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black') + '">{y}</span><br/>' +
					'<span style="font-size:10px;color:silver">度</span></div>'
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
					text: '水中溫度'
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
					((Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black') + '">{y}</span><br/>' +
					'<span style="font-size:10px;color:silver">度</span></div>'
				},
				tooltip: {
						valueSuffix: '度'
				}
		  }]
    });

    // 定時更新
    setInterval(function () {
		//JSON取Relay值
		var relay1_state,relay2_state,relay3_state,relay4_state,relay5_state;
		$.getJSON("data/relay.txt", function (relay) {
			relay1_state = parseInt(relay.relay1);
			relay2_state = parseInt(relay.relay2);
			relay3_state = parseInt(relay.relay3);
			relay4_state = parseInt(relay.relay4);
			relay5_state = parseInt(relay.relay5);
			relay6_state = parseInt(relay.relay6);

			if(relay1_state == 1){honeySwitch.showOn("#relay1");}else{honeySwitch.showOff("#relay1");}
			if(relay2_state == 1){honeySwitch.showOn("#relay2");}else{honeySwitch.showOff("#relay2");}
			if(relay3_state == 1){honeySwitch.showOn("#relay3");}else{honeySwitch.showOff("#relay3");}
			if(relay4_state == 1){honeySwitch.showOn("#relay4");}else{honeySwitch.showOff("#relay4");}
			if(relay5_state == 1){honeySwitch.showOn("#relay5");}else{honeySwitch.showOff("#relay5");}
			if(relay6_state == 1){honeySwitch.showOn("#relay6");}else{honeySwitch.showOff("#relay6");}

		});

		//JSON取溫溼度值
		var h_air,t_air;heat_air,t_water;
		$.getJSON("data/thr.txt", function (thr) { //讀取json資料,把資料放進data裡
			var point;
			h_air = parseFloat(thr.h_air);
		    t_air = parseFloat(thr.t_air);
			heat_air = parseFloat(thr.heat_air);
			t_water = parseFloat(thr.t_water);


			if (chart1) {point = chart1.series[0].points[0];point.update(h_air);}
			if (chart2) {point = chart2.series[0].points[0];point.update(t_air);}
			if (chart3) {point = chart3.series[0].points[0];point.update(heat_air);}
			if (chart4) {point = chart4.series[0].points[0];point.update(t_water);
			}

		});


	}, 1800);


      //////
});

</script>


</head>

<body>
<?php
//讀取目前資料
$thr_file = file_get_contents("data/thr.txt"); //溫溼度
$relay_file = file_get_contents("data/relay.txt"); //開關狀態
//Json解碼
$thr_json = json_decode($thr_file, true);
$relay_json = json_decode($relay_file, true);
//溫溼度變數定義
$h_air = $thr_json['h_air'];
$t_air = $thr_json['t_air'];
$heat_air = $thr_json['heat_air'];
$t_water = $thr_json['t_water'];
$datetime = $thr_json['datetime'];
//開關變數定義
$relay1_state = $relay_json['relay1'];
$relay2_state = $relay_json['relay2'];
$relay3_state = $relay_json['relay3'];
$relay4_state = $relay_json['relay4'];
$relay5_state = $relay_json['relay5'];
$relay6_state = $relay_json['relay6'];
//回報所有值(測試用)
echo $relay1_state, $relay2_state, $relay3_state, $relay4_state, $relay5_state, $relay6_state . '<br/>';
echo $h_air, $t_air, $heat_air, $t_water, $datetime;

?>



  <h2>測試頁面</h2>
  <!--<on>開</on>
  <off>關</off>-->
  <div id="1" style="width: 800px; height: 200px; margin: 0 auto">
    <div id="h_air" style="width: 200px; height: 200px; float: left"></div>
	<div id="t_air" style="width: 200px; height: 200px; float: left"></div>
	<div id="heat_air" style="width: 200px; height: 200px; float: left"></div>
	<div id="t_water" style="width: 200px; height: 200px; float: left"></div>
  </div>

  <div id="2" style="width: 500px; height: 100px; margin: 0 auto">
  	<div style="float:left"><p>電器一號：</p><span class="switch-off" themeColor="gold" id="relay1"></span></div>
  	<div style="float:left"><p>電器二號：</p><span class="switch-off" themeColor="gold" id="relay2"></span></div>
  	<div style="float:left"><p>電器三號：</p><span class="switch-off" themeColor="gold" id="relay3"></span></div>
    <div style="float:left"><p>電器四號：</p><span class="switch-off" themeColor="gold" id="relay4"></span></div>
    <div style="float:left"><p>電器五號：</p><span class="switch-off" themeColor="gold" id="relay5"></span></div>
    <div style="float:left"><p>電器六號：</p><span class="switch-off" themeColor="gold" id="relay6"></span></div>
  </div>





</body>

</html>




<!--暫存區
<iframe width="450" height="260" style="border: 1px solid #cccccc;" src="https://thingspeak.com/channels/507442/charts/1?bgcolor=%23ffffff&color=%23d62020&dynamic=true&results=60&title=%E9%AD%9A%E7%BC%B8%E6%B0%B4%E6%BA%AB&type=line&xaxis=%E6%99%82%E9%96%93&yaxis=%E6%BA%AB%E5%BA%A6&yaxismax=35&yaxismin=25">
</iframe>

<iframe width="450" height="260" style="border: 1px solid #cccccc;" src="https://thingspeak.com/channels/507442/charts/2?bgcolor=%23ffffff&color=%23d62020&dynamic=true&results=60&title=%E5%AE%A4%E5%85%A7%E6%BA%AB%E5%BA%A6&type=line&xaxis=%E6%99%82%E9%96%93&yaxis=%E6%BA%AB%E5%BA%A6&yaxismax=35&yaxismin=25">
</iframe>

<iframe width="450" height="260" style="border: 1px solid #cccccc;" src="https://thingspeak.com/channels/507442/charts/3?bgcolor=%23ffffff&color=%23d62020&dynamic=true&results=60&title=%E5%AE%A4%E5%85%A7%E6%BA%BC%E5%BA%A6&type=line&xaxis=%E6%99%82%E9%96%93&yaxis=%E6%BF%95%E5%BA%A6&yaxismax=100&yaxismin=30"></iframe>
-->