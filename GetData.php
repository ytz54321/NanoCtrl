<?php

//判斷是否為讀取或接收資料
if(isset($_GET['read'])){
    echo file_get_contents("data/data.txt");
}else if(isset($_GET['upload'])){
//GET溫溼度數據
$h_air_GET = $_GET['h_air'];
$t_air_GET = $_GET['t_air'];
$heat_air_GET = $_GET['heat_air'];
$t_water_GET = $_GET['t_water'];

//GET繼電器數據
$relay1_GET = $_GET['relay1'];
$relay2_GET = $_GET['relay2'];
$relay3_GET = $_GET['relay3'];
$relay4_GET = $_GET['relay4'];
$relay5_GET = $_GET['relay5'];
$relay6_GET = $_GET['relay6'];

//取得現在的DATA資料
$file = file_get_contents("data/data.txt"); //讀取檔案
$m_json = json_decode($file, true); //json解碼

//從JSON中取得目前THR狀態到變數。
$h_air = $m_json['h_air'];
$t_air = $m_json['t_air'];
$heat_air = $m_json['heat_air'];
$t_water = $m_json['t_water'];
$datetime = $m_json['datetime'];

//從JSON中取得最後的Relay狀態到變數。
$relay1_state = $m_json['relay1'];
$relay2_state = $m_json['relay2'];
$relay3_state = $m_json['relay3'];
$relay4_state = $m_json['relay4'];
$relay5_state = $m_json['relay5'];
$relay6_state = $m_json['relay6'];

//判斷THR是否有GET資料變動，如果有則寫入變數。
if (isset($h_air_GET)) {$h_air = $h_air_GET;}
if (isset($t_air_GET)) {$t_air = $t_air_GET;}
if (isset($heat_air_GET)) {$heat_air = $heat_air_GET;}
if (isset($t_water_GET)) {$t_water = $t_water_GET;}
if (isset($h_air_GET)||isset($t_air_GET)||isset($heat_air_GET)||isset($t_water_GET)){ $datetime = date("Y-m-d H:i:s"); }

//判斷Relay是否有資料變動，如果有則寫入變數。
if (isset($relay1_GET)) {if ($relay1_GET == 1) {if ($relay1_state == 0) {$relay1_state = 1;}} else {if ($relay1_state == 1) {$relay1_state = 0;}}}
if (isset($relay2_GET)) {if ($relay2_GET == 1) {if ($relay2_state == 0) {$relay2_state = 1;}} else {if ($relay2_state == 1) {$relay2_state = 0;}}}
if (isset($relay3_GET)) {if ($relay3_GET == 1) {if ($relay3_state == 0) {$relay3_state = 1;}} else {if ($relay3_state == 1) {$relay3_state = 0;}}}
if (isset($relay4_GET)) {if ($relay4_GET == 1) {if ($relay4_state == 0) {$relay4_state = 1;}} else {if ($relay4_state == 1) {$relay4_state = 0;}}}
if (isset($relay5_GET)) {if ($relay5_GET == 1) {if ($relay5_state == 0) {$relay5_state = 1;}} else {if ($relay5_state == 1) {$relay5_state = 0;}}}
if (isset($relay6_GET)) {if ($relay6_GET == 1) {if ($relay6_state == 0) {$relay6_state = 1;}} else {if ($relay6_state == 1) {$relay6_state = 0;}}}

//建立JSON資料表單
$data_arr = [
    "h_air" => "$h_air",
    "t_air" => "$t_air",
    "heat_air" => "$heat_air",
    "t_water" => "$t_water",
    "datetime" => "$datetime",
    "relay1" => "$relay1_state",
    "relay2" => "$relay2_state",
    "relay3" => "$relay3_state",
    "relay4" => "$relay4_state",
    "relay5" => "$relay5_state",
    "relay6" => "$relay6_state",
];

//進行JSON編碼
$data_en = json_encode($data_arr);
echo $data_en;

//存入檔案
$file = fopen('data/data.txt', "w");
fwrite($file, "$data_en");
fclose($file);
}else{
    echo "想幹嘛?";
}