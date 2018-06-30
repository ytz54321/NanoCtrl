<html>
<?php
if (!isset($_COOKIE["login"])) {
    header("Location: login.php"); //將網址改為要導入的登入頁面
} else {    
}
?>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no" />
  
  <title>魚缸生態主控台</title>

  <link rel="Shortcut Icon" type="image/x-icon" href="img/ico.ico"/>
  <link rel="stylesheet" href="css/honeySwitch.css">
  <link rel="stylesheet" href="css/m_main.css">

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
	  switchEvent("#ITmode",function(){$("#IT").slideDown();},function(){$("#IT").slideUp();});

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
					$("#h_air").text(h_air);
					$("#t_air").text(t_air);
					$("#heat_air").text(heat_air);
					$("#t_water").text(t_water);
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
<div class="page">
	
	<h2>魚缸生態主控台</h2>
	<div class="common-row">
	    <div class="thr-left">空氣溫度：<a id="t_air">---</a>°C</div>
		<div class="thr-right">空氣濕度：<a id="h_air">---</a>%</div>
	</div>
	<div class="common-row">
		<div class="thr-left">體感溫度：<a id="heat_air">---</a>°C</div>
		<div class="thr-right">水中溫度：<a id="t_water">---</a>°C</div>		
	</div>
	<div class="common-row">
		<div class="cell-left">一號燈具(5W白+藍光)</div>
		<div class="cell-right"><span class="switch-off" themeColor="gold" id="relay1"></span></div>		
	</div>
	<div class="common-row">
		<div class="cell-left">二號燈具(3W紅+白+藍)</div>
		<div class="cell-right"><span class="switch-off" themeColor="gold" id="relay2"></span></div>
	</div>
	<div class="common-row">
		<div class="cell-left">降溫風扇</div>
		<div class="cell-right"><span class="switch-off" themeColor="gold" id="relay3"></span></div>
	</div>
	<div class="common-row">
		<div class="cell-left">加溫棒</div>
		<div class="cell-right"><span class="switch-off" themeColor="gold" id="relay4"></span></div>
	</div>
	<div class="common-row">
		<div class="cell-left">打氣幫浦</div>
		<div class="cell-right"><span class="switch-off" themeColor="gold" id="relay5"></span></div>
	</div>
	<div class="common-row">
		<div class="cell-left">環境照明</div>
		<div class="cell-right"><span class="switch-off" themeColor="gold" id="relay6"></span></div>
	</div>
	
	<div class="common-row" style="line-height: 50px;">
	<a>資料更新時間：</a><a id="time">顯示時間在此</a></br>
	</div>
	
	
	<div class="common-row">
		<div class="cell-left">開發人員模式</div>
		<div class="cell-right"><span class="switch-off" themeColor="gold" id="ITmode"></span></div>
	</div>
	<div class="common-row hidden" id="IT">
	
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
			echo $relay1_state, $relay2_state, $relay3_state, $relay4_state, $relay5_state, $relay6_state;
			echo "  ",$h_air,"  ",$t_air,"  ",$heat_air,"  ",$t_water,"  ",$datetime;
		 ?>
</div>

</div>
</body>

</html>
