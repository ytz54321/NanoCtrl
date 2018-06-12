<?php
//取得GET參數
$relay1_GET = $_GET['relay1'];
$relay2_GET = $_GET['relay2'];
$relay3_GET = $_GET['relay3'];
$relay4_GET = $_GET['relay4'];
$relay5_GET = $_GET['relay5'];
$relay6_GET = $_GET['relay6'];

//讀取目前狀況
$file = file_get_contents("data/relay.txt"); //讀取檔案
$m_json = json_decode($file, true); //json解碼

$relay1_state = $m_json['relay1'];
$relay2_state = $m_json['relay2'];
$relay3_state = $m_json['relay3'];
$relay4_state = $m_json['relay4'];
$relay5_state = $m_json['relay5'];
$relay6_state = $m_json['relay6'];

//運算開關狀態
if ($relay1_GET == 1) {if ($relay1_state == 0) {$relay1_state = 1;}} else {if ($relay1_state == 1) {$relay1_state = 0;}}
if ($relay2_GET == 1) {if ($relay2_state == 0) {$relay2_state = 1;}} else {if ($relay2_state == 1) {$relay2_state = 0;}}
if ($relay3_GET == 1) {if ($relay3_state == 0) {$relay3_state = 1;}} else {if ($relay3_state == 1) {$relay3_state = 0;}}
if ($relay4_GET == 1) {if ($relay4_state == 0) {$relay4_state = 1;}} else {if ($relay4_state == 1) {$relay4_state = 0;}}
if ($relay5_GET == 1) {if ($relay5_state == 0) {$relay5_state = 1;}} else {if ($relay5_state == 1) {$relay5_state = 0;}}
if ($relay6_GET == 1) {if ($relay6_state == 0) {$relay6_state = 1;}} else {if ($relay6_state == 1) {$relay6_state = 0;}}

//建立JSON清單
$data_relay_arr = [
    "relay1" => "$relay1_state",
    "relay2" => "$relay2_state",
    "relay3" => "$relay3_state",
    "relay4" => "$relay4_state",
    "relay5" => "$relay5_state",
    "relay6" => "$relay6_state",
];

//顯示編碼後狀態
echo "編碼後:" . '<br/>';
$data_relay_en = json_encode($data_relay_arr);
echo $data_relay_en;

//存檔開關狀態
$file = fopen('data/relay.txt', "w");
fwrite($file, "$data_relay_en");
fclose($file);
