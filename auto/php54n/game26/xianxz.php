<?php
global $Room;
$id = ceil($connection->user['room']);
$roomInfo = $db->getOne("SELECT rule,uid FROM jz_room WHERE id='{$id}'");
$rules = json_decode($roomInfo["rule"], true);
if($rules["mode"]) {
  	$admittances = explode(',', $rules['play']['admittance']);
    preg_match_all('/\d+/', $admittances[$rules['admittance']], $admittance);
  	act('debugLog', $admittance['0']['0'], $connection);
    $credits = $Room[$id]['user'][$connection->user['id']]->user['dqjf'];
    $mem = $db->getOne("SELECT * FROM jz_qun WHERE open='{$roomInfo["uid"]}' AND uid='{$connection->user["id"]}'");
  	$msg = false;
  	if($roomInfo["uid"] == $connection->user["id"]) {
    	if($admittance['0']['0'] > ($connection->user['credits'] + $credits)) {
        	$msg = '积分不足' . $admittance['0']['0'] . '，请联系客服上分！';
        }
    } else {
    	if($admittance['0']['0'] > ($mem['credits'] + $credits)) {
        	$msg = '积分不足' . $admittance['0']['0'] . '，请联系群主上分！';
        }
    }
  	if($msg) {
        $msg = array("msg" =>  $msg, "isBackHome" => false);
        act('tipAlert',$msg, $connection);
        act('operationButton', '4', $connection);
        return false;
    }
}
if ($Room[$id]['xx']['zt'] != 5) {
	return false;
}
if ($data2['time'] > $Room[$id]['time'] || $data2['time'] < $Room[$id]['timexx']) {
	return false;
}
if (empty($Room[$id]['user'][$connection->user['id']]->user['fen'])) {
	$Room[$id]['user'][$connection->user['id']]->user['fen'] = [];
}
$xiazhuCount = 0;
foreach ($Room[$id]['user'][$connection->user['id']]->user['fen'] as $type => $v) {
	foreach ($v as $v2) {
		$xiazhuCount += $v2;
	}
}
if (ceil($xiazhuCount + $data2['fen']) > $Room[$id]['zd']) {
	act('xiazhuError', '超过最大下注', $connection);
	return false;
}
if (empty($Room[$id]['user'][$connection->user['id']]->user['fen'][$data2['type']])) {
	$Room[$id]['user'][$connection->user['id']]->user['fen'][$data2['type']] = [];
}
$Room[$id]['user'][$connection->user['id']]->user['fen'][$data2['type']][] = $data2['fen'];
$allTotal = [];
foreach ($Room[$id]['user'] as $connect3) {
	foreach ($connect3->user['fen'] as $type => $arr) {
		foreach ($arr as $v) {
			$allTotal[$type] = empty($allTotal[$type]) ? $v : $allTotal[$type] + $v;
		}
	}
}
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
		$msg['type'] = $data2['type'];
		$msg['fen'] = $data2['fen'];
		$msg['allTotal'] = $allTotal;
		$meTotal = [];
		foreach ($connection3->user['fen'] as $type => $arr) {
			foreach ($arr as $v) {
				$meTotal[$type] = empty($meTotal[$type]) ? $v : $meTotal[$type] + $v;
			}
		}
		$msg['meTotal'] = $meTotal;
		act('showxian', $msg, $connection3);
	}
}
if ($zbsl == $qbsl + 1 && $Room[$id]['xx']['zt'] == '4') {
	$data = array();
	$data['act'] = 'setxian';
	$data['time'] = $Room[$id]['timexx'];
	$data['room'] = $id;
} 