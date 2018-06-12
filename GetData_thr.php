<?php
//GET溫溼度數據
$h_air = $_GET['h_air'];
$t_air = $_GET['t_air'];
$heat_air = $_GET['heat_air'];
$t_water = $_GET['t_water'];

//取的現在時間
$datetime = date("Y-m-d H:i:s");

//建立Json資料
$data_THR_arr = [
    "空氣濕度" => "$h_air",
    "空氣溫度" => "$t_air",
    "體感溫度" => "$heat_air",
    "水中溫度" => "$t_water",
    "儲存時間" => "$datetime",
];

//Json編碼
$data_THR_en = json_encode($data_THR_arr,JSON_UNESCAPED_UNICODE);
echo $data_THR_en;

//寫入數據
$file = fopen('data/thr.txt', "w");
fwrite($file, "$data_THR_en");
fclose($file);

