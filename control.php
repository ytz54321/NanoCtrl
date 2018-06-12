<html>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <title>魚缸生態主控台</title>
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>

  <script type="text/javascript">
    $(document).ready(function () {
      //////
      $("on").click(function () {
        $.get("GetData_relay.php", { relay1: "1" });
      });

      $("off").click(function () {
        $.get("GetData_relay.php", { relay1: "0" });
      });




      //////
    });

  </script>
  

</head>

<body>
    <?php
    //讀取目前資料
    $thr_file = file_get_contents("data/thr.txt");//溫溼度
    $relay_file = file_get_contents("data/relay.txt");//開關狀態
    //Json解碼
    $thr_json = json_decode($thr_file, true);
    $relay_json = json_decode($relay_file, true);
    //溫溼度變數定義
    $h_air = $thr_json['空氣濕度'];
    $t_air = $thr_json['空氣溫度'];
    $heat_air = $thr_json['體感溫度'];
    $t_water = $thr_json['水中溫度'];
    //開關變數定義
    $relay1_state = $relay_json['relay1'];
    $relay2_state = $relay_json['relay2'];
    $relay3_state = $relay_json['relay3'];
    $relay4_state = $relay_json['relay4'];
    $relay5_state = $relay_json['relay5'];
    $relay6_state = $relay_json['relay6'];
    //回報所有值(測試用)
    echo $relay1_state,$relay2_state,$relay3_state,$relay4_state,$relay5_state;
    echo $h_air,$t_air,$heat_air,$t_water;

    ?>
  
  
  <h2>測試頁面</h2>
  <on>開</on>
  <off>關</off>
  
</body>

</html>




<!--暫存區
<iframe width="450" height="260" style="border: 1px solid #cccccc;" src="https://thingspeak.com/channels/507442/charts/1?bgcolor=%23ffffff&color=%23d62020&dynamic=true&results=60&title=%E9%AD%9A%E7%BC%B8%E6%B0%B4%E6%BA%AB&type=line&xaxis=%E6%99%82%E9%96%93&yaxis=%E6%BA%AB%E5%BA%A6&yaxismax=35&yaxismin=25">
</iframe>

<iframe width="450" height="260" style="border: 1px solid #cccccc;" src="https://thingspeak.com/channels/507442/charts/2?bgcolor=%23ffffff&color=%23d62020&dynamic=true&results=60&title=%E5%AE%A4%E5%85%A7%E6%BA%AB%E5%BA%A6&type=line&xaxis=%E6%99%82%E9%96%93&yaxis=%E6%BA%AB%E5%BA%A6&yaxismax=35&yaxismin=25">
</iframe>

<iframe width="450" height="260" style="border: 1px solid #cccccc;" src="https://thingspeak.com/channels/507442/charts/3?bgcolor=%23ffffff&color=%23d62020&dynamic=true&results=60&title=%E5%AE%A4%E5%85%A7%E6%BA%BC%E5%BA%A6&type=line&xaxis=%E6%99%82%E9%96%93&yaxis=%E6%BF%95%E5%BA%A6&yaxismax=100&yaxismin=30"></iframe>
-->