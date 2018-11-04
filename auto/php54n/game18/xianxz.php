<?php
global $Room;
$id = $connection->user['room'];
if ($data2['time'] > $Room[$id]['time'] || $Room[$id]['user'][$connection->user['id']]->user['beishu'] != '-1' || $data2['time'] < $Room[$id]['timexx']) {
	return false;
}
$roomInfo = $db->getOne("SELECT rule,uid FROM jz_room WHERE id='{$id}'");
$rules = json_decode($roomInfo["rule"], true);
$credits = $Room[$id]['user'][$connection->user['id']]->user['dqjf'];
$mem = $db->getOne("SELECT * FROM jz_qun WHERE open='{$roomInfo["uid"]}' AND uid='{$connection->user["id"]}'");
if($rules["mode"]) {
  	$msg = false;
  	if($roomInfo["uid"] == $connection->user["id"]) {
    	if(0 >= ($connection->user['credits'] + $credits)) {
        	$msg = "积分不足，请联系客服上分！";
        }
    } else {
    	if(0 >= ($mem['credits'] + $credits)) {
        	$msg = "积分不足，请联系群主上分！";
        }
    }
  	if($msg) {
        $msg = array("msg" =>  $msg, "isBackHome" => false);
        act('tipAlert',$msg, $connection);
        act('operationButton', '4', $connection);
        return false;
    }
}
$connection->user['beishu'] = $data2['bs'];
$Room[$id]['user'][$connection->user['id']]->user['beishu'] = $data2['bs'];
$zbsl = 0;
$qbsl = 0;
foreach ($Room[$id]['user'] as $connection3) {
	if ($connection3->user['zt'] == '1') {
		$zbsl = $zbsl + 1;
	}
	if ($connection3->user['beishu'] != '-1' && $connection3->user['zt'] == '1' && $connection3->user['index'] != $Room[$id]['bank']['index']) {
		$qbsl = $qbsl + 1;
	}
	if ($connection3->user['online'] != '-1') {
		$msg = array();
		$msg['index'] = $connection->user['index'];
		$msg['zt'] = $data2['bs'];
		act('showxian', $msg, $connection3);
	}
}
if ($zbsl == $qbsl + 1 && $Room[$id]['xx']['zt'] == '4') {
	$Room[$id]['xx']['zt'] = 5;
	$data = array();
	$data['act'] = 'setxian';
	$data['time'] = $Room[$id]['timexx'];
	$data['room'] = $id;
	reqact($data, '');
} 