<?php
/**
 * Created by PhpStorm.
 * User: Gama
 * Date: 2016/5/19
 * Time: 下午 12:11
 */

include_once "connection.php";

// 取得資料
$tid = $_POST["tid"];
$room_code = $_POST["room_code"];
$debug = $_GET["debug"];

// 偵錯模式
if ($debug == "GAMAISHANDSOME") {
    $tid = 0;
    $room_code = "PUBLICRM";
}

// 檢查是否不完整
if ($tid == "") $tid = 0;
if ($room_code == "") $room_code = "PUBLICRM";

// 儲存資料結構
$data = array();

if ($stmt = $mysqli->prepare("SELECT tid, roomcode, nick, content, ip, timestamp FROM (SELECT tid, roomcode, nick, content, ip, timestamp FROM talk WHERE roomcode = ? AND tid > ? ORDER BY timestamp DESC LIMIT 50) trimview ORDER BY timestamp ASC;")) {
    $stmt->bind_param("si", $room_code, $tid);
    $stmt->execute();
    $stmt->bind_result($result_tid, $result_room_code, $result_nick,$result_content, $result_ip, $result_timestamp);


    while ($stmt->fetch()) {
        $data[] = array ("tid"=>$result_tid, "room_code"=>$result_room_code, "nick"=> $result_nick,
            "content"=> $result_content, "ip"=>$result_ip, "timestamp"=>$result_timestamp);
    }
    $stmt->close();
}
mysqli_close($mysqli);

echo json_encode($data);

