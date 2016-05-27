<?php
/**
 * Created by PhpStorm.
 * User: Gama
 * Date: 2016/5/19
 * Time: 上午 11:26
 */

    include_once "connection.php";

    // 取得資料
    $nick = $_POST["nick"];
    $room_code = $_POST["room_code"];
    $content = $_POST['content'];
    $debug = $_GET["debug"];

    // 若是測資
    if ($debug == "GAMAISHANDSOME") {
        $nick = "TEST_USER";
        $room_code = "PUBLICRM";
        $content = "TEST_CONTENT";
    }

    // 如果空資料，不發言
    if ($room_code == NULL && $nick == NULL && $content == NULL) exit();

    // 若沒有指定房間代號，使用公開預設
    if ($room_code == "") $room_code = "PUBLICRM";

    // 沒有名子
    if ($nick == "") $nick = "無名氏";

    // 取得用戶 IP
    if(!empty($_SERVER['HTTP_CLIENT_IP'])) $ip = $_SERVER['HTTP_CLIENT_IP'];
    else if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else $ip= $_SERVER['REMOTE_ADDR'];

    // 若無法取得IP，不予許發言
    if ($ip == "") exit();

    if ($stmt = $mysqli->prepare("INSERT INTO talk (roomcode, nick, content, ip)VALUES(?,?,?,?);")) {
        $stmt->bind_param("ssss", $room_code, $nick, $content, $ip);
        $stmt->execute();
        $stmt->close();
    }

    mysqli_close($mysqli);