<html>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <title>魚缸生態主控台</title>
  <script type="text/javascript" src="js/jquery.min.js"></script>
  <script type="text/javascript" src="js/highcharts.js"></script>
  <script type="text/javascript" src="js/highcharts-more.js"></script>
  <script type="text/javascript" src="js/solid-gauge.js"></script>



  <script type="text/javascript">
    $(document).ready(function () {
      //////
      $("on").click(function () {
        $.get("GetData_relay.php", { relay1: "1" });
      });

      $("off").click(function () {
        $.get("GetData_relay.php", { relay1: "0" });
      });

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
						[0.5, '#DDDF0D'], // yellow
						[0.9, '#DF5353'] // red
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
		var h_air,t_air;heat_air,t_water;
		$.getJSON("data/thr.txt", function (data) { //讀取json資料,把資料放進data裡
			var point;
			h_air = parseInt(data.h_air);
		    t_air = parseInt(data.t_air);
			heat_air = parseInt(data.heat_air);
			t_water = parseInt(data.t_water);
		
		
			if (chart1) {
				point = chart1.series[0].points[0];
				point.update(h_air);
			}
			if (chart2) {
				point = chart2.series[0].points[0];
				point.update(t_air);
			}
			if (chart3) {
				point = chart3.series[0].points[0];
				point.update(heat_air);
			}
			if (chart4) {
				point = chart4.series[0].points[0];
				point.update(t_water);
			}

		});
	}, 1000);


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
	//開關變數定義
	$relay1_state = $relay_json['relay1'];
	$relay2_state = $relay_json['relay2'];
	$relay3_state = $relay_json['relay3'];
	$relay4_state = $relay_json['relay4'];
	$relay5_state = $relay_json['relay5'];
	$relay6_state = $relay_json['relay6'];
	//回報所有值(測試用)
	echo $relay1_state, $relay2_state, $relay3_state, $relay4_state, $relay5_state;
	echo $h_air, $t_air, $heat_air, $t_water;

	?>


  <h2>測試頁面</h2>
  <on>開</on>
  <off>關</off>
    
  <div style="width: 1200px; height: 200px; margin: 0 auto">
    <div id="h_air" style="width: 200px; height: 200px; float: left"></div>
	<div id="t_air" style="width: 200px; height: 200px; float: left"></div>
	<div id="heat_air" style="width: 200px; height: 200px; float: left"></div>
	<div id="t_water" style="width: 200px; height: 200px; float: left"></div>
  </div>
  <div id="jsonTip"></div>


</body>

</html>




<!--暫存區
<iframe width="450" height="260" style="border: 1px solid #cccccc;" src="https://thingspeak.com/channels/507442/charts/1?bgcolor=%23ffffff&color=%23d62020&dynamic=true&results=60&title=%E9%AD%9A%E7%BC%B8%E6%B0%B4%E6%BA%AB&type=line&xaxis=%E6%99%82%E9%96%93&yaxis=%E6%BA%AB%E5%BA%A6&yaxismax=35&yaxismin=25">
</iframe>

<iframe width="450" height="260" style="border: 1px solid #cccccc;" src="https://thingspeak.com/channels/507442/charts/2?bgcolor=%23ffffff&color=%23d62020&dynamic=true&results=60&title=%E5%AE%A4%E5%85%A7%E6%BA%AB%E5%BA%A6&type=line&xaxis=%E6%99%82%E9%96%93&yaxis=%E6%BA%AB%E5%BA%A6&yaxismax=35&yaxismin=25">
</iframe>

<iframe width="450" height="260" style="border: 1px solid #cccccc;" src="https://thingspeak.com/channels/507442/charts/3?bgcolor=%23ffffff&color=%23d62020&dynamic=true&results=60&title=%E5%AE%A4%E5%85%A7%E6%BA%BC%E5%BA%A6&type=line&xaxis=%E6%99%82%E9%96%93&yaxis=%E6%BF%95%E5%BA%A6&yaxismax=100&yaxismin=30"></iframe>
-->