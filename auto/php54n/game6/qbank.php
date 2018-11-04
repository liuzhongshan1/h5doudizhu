<?php
global $Room;
$id = ceil($connection->user['room']);
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
        act('operationButton', '4', $connection);
        return false;
    }
}
if ($data2['time'] > $Room[$id]['time'] || $Room[$id]['user'][$connection->user['id']]->user['qbank'] != '-1' || $data2['time'] < $Room[$id]['timexx']) {
	return false;
}
$connection->user['qbank'] = $data2['zt'];
$Room[$id]['user'][$connection->user['id']]->user['qbank'] = $data2['zt'];
if ($data2['zt'] > $Room[$id]['beishu']) {
	$Room[$id]['beishu'] = $data2['zt'];
}
if ($data2['zt']) {
	$Room[$id]['start'][$connection->user['id']] = 1;
}
$zbsl = 0;
$qbsl = 0;
foreach ($Room[$id]['user'] as $connection3) {
	if ($connection3->user['zt'] == '1' && $connection3->user['index'] < 4) {
		$zbsl = $zbsl + 1;
	}
	if ($connection3->user['qbank'] != '-1' && $connection3->user['zt'] == '1' && $connection3->user['index'] < 4) {
		$qbsl = $qbsl + 1;
	}
	$msg = array();
	$msg['index'] = $connection->user['index'];
	$msg['zt'] = $data2['zt'];
	if ($connection->user['id'] != $connection3->user['id'] && $connection3->user['online'] != '-1') {
		act('qbankshow', $msg, $connection3);
	}
}
if ($zbsl == $qbsl && $Room[$id]['xx']['zt'] == '2') {
	$Room[$id]['xx']['zt'] = '3';
	$data = array();
	$data['act'] = 'setbank';
	$data['time'] = $Room[$id]['timexx'];
	$data['room'] = $id;
	reqact($data, '');
} 