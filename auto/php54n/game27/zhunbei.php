<?php
global $Room;
$id = $connection->user['room'];
$roomInfo = $db->getOne("SELECT rule,uid FROM jz_room WHERE id='{$id}'");
$rules = json_decode($roomInfo["rule"], true);
if($rules["mode"]) {
  	$admittances = explode(',', $rules['play']['admittance']);
    preg_match_all('/\d+/', $admittances[$rules['admittance']], $admittance);
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
        act('operationButton', '8', $connection);
        return false;
    }
}
if ($Room[$id]['xx']['zt'] > 1) {
	return false;
}
$connection->user['zt'] = 1;
$Room[$id]['user'][$connection->user['id']]->user['zt'] = 1;
$zbsl = 0;
$zrs = 0;
foreach ($Room[$id]['user'] as $connection3) {
	if ($connection3->user['online'] == '-1' && $Room[$id]['xx']['zt'] < 2) {
		$Room[$id]['user'][$connection3->user['id']]->user['zt'] = 0;
	}
	if ($connection3->user['zt'] == '1') {
		$zbsl = $zbsl + 1;
	}
	if ($connection3->user['online'] == '1') {
		$zrs = $zrs + 1;
	}
	if ($connection->user['id'] != $connection3->user['id'] && $connection3->user['online'] != '-1') {
		$msg = $connection->user['index'];
		act('zbuser', $msg, $connection3);
	}
}
if ($zrs == $zbsl && $zrs >= 2) {
	$data = array();
	$data['act'] = 'startroom';
	$data['time'] = $Room[$id]['timexx'];
	$data['room'] = $id;
	reqact($data, '');
	return false;
}
if ($zbsl >= 2 && $Room[$id]['xx']['zt'] == 0) {
	$Room[$id]['xx']['zt'] = 1;
	if ($zrs == $zbsl) {
		$time_interval = 0;
	} else {
		$time_interval = 10;
	}
	if ($Room[$id]['xx']['js'] == '0') {
		$time_interval = 30;
	}
	$Room[$id]['time'] = time() + $time_interval;
	$Room[$id]['timexx'] = time();
	djs($time_interval, 'startroom', $id, $Room[$id]['timexx']);
	foreach ($Room[$id]['user'] as $connection3) {
		if ($connection3->user['online'] != '-1') {
			act('djs', $Room[$id]['time'], $connection3);
			act('divRobBankerText', 0, $connection3);
		}
	}
} 