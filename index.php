<?php

if (!isset($_COOKIE["login"])) {
    header("Location: login.php"); //將網址改為要導入的登入頁面
} else {
    header("Location: control.php");
}
