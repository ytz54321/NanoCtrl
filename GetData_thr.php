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
    "h_air" => "$h_air",
    "t_air" => "$t_air",
    "heat_air" => "$heat_air",
    "t_water" => "$t_water",
    "datetime" => "$datetime",
];

//Json編碼
$data_THR_en = json_encode($data_THR_arr);
echo $data_THR_en;

//寫入數據
$file = fopen('data/thr.txt', "w");
fwrite($file, "$data_THR_en");
fclose($file);

