<?php
/**
 * Created by PhpStorm.
 * User: Gama
 * Date: 2016/5/19
 * Time: 下午 12:06
 */

// 連線資訊
$db_host = '192.168.0.101';
$db_user = 'talkuser';
$db_pass = 'ggininder';
$db_name = 'talkroom';

// 連線資料庫
$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);

// 檢查資料庫連線
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

// 使用 UTF8模式
mysqli_set_charset($mysqli,"utf8");

// 選擇使用的資料庫
mysqli_select_db($mysqli, $db_name);

/*
        Binds variables to prepared statement

        i    corresponding variable has type integer
        d    corresponding variable has type double
        s    corresponding variable has type string
        b    corresponding variable is a blob and will be sent in packets
   */