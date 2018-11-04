<?php
global $Room;
$id = ceil($data2['room']);
if ($Room[$id] && count($Room[$id]['index']) <= 0 && !$Room[$id]['user'][$connection->user['id']]) {
	act('over', '该房间已经满员了', $connection);
	return false;
}
$roomInfo = $db->getOne("SELECT rule,uid FROM jz_room WHERE id='{$id}'");
$rules = json_decode($roomInfo["rule"], true);
$admittances = explode(',', $rules['play']['admittance']);
preg_match_all('/\d+/', $admittances[$rules['admittance']], $admittance);
if($rules["mode"])
{
  	$isQunZhu = $roomInfo["uid"] == $connection->user["id"];
  	$mem = $db->getOne("SELECT * FROM jz_qun WHERE open='{$roomInfo["uid"]}' AND uid='{$connection->user["id"]}'");
  	if(!$isQunZhu && (!$mem || 0 == count($mem))) {
    	return tip("加入积分模式游戏需要先加入群组，请联系群主邀请加入！", $connection);
    }
  	if(($isQunZhu && $admittance['0']['0'] > $connection->user['credits']) || (!$isQunZhu && $admittance['0']['0'] > $mem['credits'])) {
  		return tip('积分不足' . $admittance['0']['0'] . '，请联系' .  ($isQunZhu ? '客服' : '群主') . '上分！', $connection);
    }
}
if (!$Room[$id]) {
	$Room[$id]['xx'] = $db->getOne("select * from jz_room where id='" . $id . "'");
	if ($Room[$id]['xx']['endtime'] > 0) {
		act('over', '房间已关闭', $connection);
		unset($Room[$id]);
		return false;
	}
	$dkxx = $db->getOne("select * from jz_server where dk='" . $Room[$id]['xx']['dk'] . "'");
	$save = array();
	$save['num'] = $dkxx['num'] + 1;
	$db->update('jz_server', $save, 'id=' . $dkxx['id']);
	global $connection2;
	$dataxx = array();
	$dataxx['act'] = 'creatroom';
	$connection2->send(json_encode($dataxx));
	$Room[$id]['index'] = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11);
	$rule = json_decode($Room[$id]['xx']['rule'], true);
	$dfxx = explode(',', $rule['play']['df']);
  	$bsxx = explode(',', $rule['play']['bs']);
	$gzxx = explode(',', $rule['play']['gz']);
	$pxxx = explode(',', $rule['play']['px']);
	$szxx = explode(',', $rule['play']['sz']);
	preg_match_all("/\d+/", $gzxx[$rule['gz']], $gz);
	preg_match_all("/\d+/", $dfxx[$rule['df']], $df);
  	preg_match_all("/\d+/", $bsxx[$rule['bs']], $bs);
	for ($i = 0; $i < 11; $i++) {
		$niuniu[$i] = 1;
	}
	foreach ($gz[0] as $key => $value) {
		$niuniu[(10 - $key)] = $value;
	}
	foreach ($pxxx as $key => $value) {
		if ($rule['px'][$key] == 1) {
			preg_match_all("/\d+/", $value, $px);
			$dkxx['px'][] = $value;
			$niuniu[(11 + $key)] = $px['0']['0'];
			$Room[$id]['pai' . $key] = 1;
		}
	}
             $Room[$id]['ruletime']['zb'] = $rule['time']['zb'];
			$Room[$id]['ruletime']['qz'] = $rule['time']['qz'];
			$Room[$id]['ruletime']['xz'] = $rule['time']['xz'];
			$Room[$id]['ruletime']['tp'] = $rule['time']['tp'];	
	$Room[$id]['type'] = $rule['play']['id'];
	$Room[$id]['lx'] = $rule['play']['type'];
	$Room[$id]['df'] = $df['0']['0'];
  	$Room[$id]['bs'] = $bs['0']['0'];
	$Room[$id]['niuniu'] = $niuniu;
	$Room[$id]['sz'] = $szxx[$rule['sz']];
	$Room[$id]['djszt'] = 0;
	$Room[$id]['beishu'] = 1;
	if ($Room[$id]['type'] == 7) {
		$Room[$id]['bank']['id'] = $Room[$id]['uid'];
	}
}
if ($Room[$id]['xx']['zt'] == '-1') {
	$Room[$id]['xx']['zt'] = 0;
	cleardjs($Room[$id]['djs'], $id);
	$Room[$id]['timeover'] = time();
}
$connection->user['online'] = 1;
$connection->user['zt'] = 0;
if (!$Room[$id]['user'][$connection->user['id']]) {
	$connection->user['room'] = $id;
	$index = 0;
	$connection->user['index'] = $Room[$id]['index'][$index];
	$connection->user['dqjf'] = 0;
	foreach ($Room[$id]['user'] as $connection3) {
		$userlist[$connection3->user['id']] = 1;
	}
	$userlist[$connection->user['id']] = 1;
	$save['user'] = json_encode($userlist);
	$db->update('jz_room', $save, 'id=' . $id);
	array_splice($Room[$id]['index'], $index, 1);
} else {
	$connection->user['room'] = $id;
	$connection->user['card'] = $Room[$id]['user'][$connection->user['id']]->user['card'];
	$connection->user['cardmax'] = $Room[$id]['user'][$connection->user['id']]->user['cardmax'];
	$connection->user['index'] = $Room[$id]['user'][$connection->user['id']]->user['index'];
	$connection->user['dqjf'] = $Room[$id]['user'][$connection->user['id']]->user['dqjf'];
	$connection->user['zt'] = $Room[$id]['user'][$connection->user['id']]->user['zt'];
	$connection->user['tpzt'] = $Room[$id]['user'][$connection->user['id']]->user['tpzt'];
	$connection->user['beishu'] = $Room[$id]['user'][$connection->user['id']]->user['beishu'];
	$connection->user['qbank'] = $Room[$id]['user'][$connection->user['id']]->user['qbank'];
	$connection->user['niu'] = $Room[$id]['user'][$connection->user['id']]->user['niu'];
	$connection->user['sfniu'] = $Room[$id]['user'][$connection->user['id']]->user['sfniu'];
	$connection->user['newcard'] = $Room[$id]['user'][$connection->user['id']]->user['newcard'];
}
act('gxindex', $connection->user['index'], $connection,false);
$Room[$id]['user'][$connection->user['id']] = $connection;
foreach ($Room[$id]['user'] as $connection3) {
  	$mem = $db->getOne("SELECT * FROM jz_qun WHERE open='{$roomInfo["uid"]}' AND uid='{$connection->user["id"]}'");
	$mem3 = $db->getOne("SELECT * FROM jz_qun WHERE open='{$roomInfo["uid"]}' AND uid='{$connection3->user["id"]}'");
	if ($connection3->user['online'] == '-1' && $Room[$id]['xx']['zt'] < 2) {
		$Room[$id]['user'][$connection3->user['id']]->user['zt'] = 0;
	}
	if ($connection->user['id'] != $connection3->user['id'] && $connection3->user['online'] != '-1') {
		$msg = array();
		$msg['user']['id'] = $connection->user['id'];
		$msg['user']['nickname'] = $connection->user['nickname'];
		$msg['user']['img'] = $connection->user['img'];
		$msg['user']['index'] = $connection->user['index'];
		$msg['user']['dqjf'] = $connection->user['dqjf'];
		$msg['user']['online'] = $connection->user['online'];
		$msg['user']['zt'] = $connection->user['zt'];
      	if($roomInfo["uid"] == $connection->user["id"]) {
            $msg['user']['credits'] = $connection->user['credits'];
        } else {
            $msg['user']['credits'] = $mem['credits'];
        }
      	$msg['mode'] = $rules["mode"];
		act('adduser', $msg, $connection3);
	}
	$msg = array();
	$msg = array();
	$msg['user']['id'] = $connection3->user['id'];
	$msg['user']['nickname'] = $connection3->user['nickname'];
	$msg['user']['img'] = $connection3->user['img'];
	$msg['user']['index'] = $connection3->user['index'];
	$msg['user']['dqjf'] = $connection3->user['dqjf'];
	$msg['user']['online'] = $connection3->user['online'];
	$msg['user']['zt'] = $connection3->user['zt'];
  	if($roomInfo["uid"] == $connection3->user["id"]) {
        $msg['user']['credits'] = $connection3->user['credits'];
    } else {
        $msg['user']['credits'] = $mem3['credits'];
    }
  	$msg['mode'] = $rules["mode"];
    reqact(['act'=> 'guanzhanupdate'], $connection3);
	act('adduser', $msg, $connection);
}

if(!isset($Room[$id]['xx']['zt']))
{
	 $Room[$id]['xx']['zt'] = 0;
}
$data = array();
$data['act'] = 'step' . $Room[$id]['xx']['zt'];
reqact($data, $connection); 