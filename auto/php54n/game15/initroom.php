<?php
global $Room;
$id = ceil($data2['room']);
if ($data2['time'] != $Room[$id]['timexx']) {
	return false;
}
$Room[$id]['timexx'] = time();
cleardjs($Room[$id]['djs'], $id);
if ($Room[$id]['xx']['js'] < $Room[$id]['xx']['zjs']) {
	foreach ($Room[$id]['user'] as $connection3) {
		if ($connection3->user['online'] == '1') {
			$Room[$id]['user'][$connection3->user['id']]->user['zt'] = 0;
			act('initroom', '', $connection3);
		}
	}
	if ($Room[$id]['type'] == '6') {
		$Room[$id]['bank']['id'] = $Room[$id]['maxuser'];
	}
	$Room[$id]['beishu'] = 1;
	$Room[$id]['xx']['zt'] = 0;
	$save = array();
	$save['js'] = $Room[$id]['xx']['js'];
	$db->update('jz_room', $save, 'id=' . $id);
	$online = 0;
	foreach ($Room[$id]['user'] as $connection3) {
		if ($connection3->user['online'] == '1') {
			$online = $online + 1;
		}
	}
	if ($online == 0 && $Room[$id]['xx']['zt'] == 0) {
		$time_interval = 600;
		$Room[$id]['xx']['zt'] = '-1';
		$Room[$id]['timexx'] = time();
		djs($time_interval, 'overroom', $id, $Room[$id]['timexx']);
	}
} else {
	$Room[$id]['xx']['zt'] = 7;
	$jflist = array();
  	$roomInfo = $db->getOne("SELECT rule,uid FROM jz_room WHERE id='{$id}'");
    $rules = json_decode($roomInfo["rule"], true);
    $ruleOption = explode(",", $rules["play"]["mode"]);
    $mode = $ruleOption[$rules["mode"]];
    $ruleOption = explode(",", $rules["play"]["welfare"]);
    $welfare = intval($ruleOption[$rules["welfare"]]) / 100;
	foreach ($Room[$id]['user'] as $connection3) {
      $jflist[$connection3->user['id']] = $connection3->user['dqjf'];
      $add = array();
      $add['uid'] = $connection3->user['id'];
      $add['room'] = $id;
      $add['overtime'] = time();
      $add['jifen'] = $connection3->user['dqjf'];
      $add['type'] = $Room[$id]['lx'];
      $add["settlementType"] = 1;
      $add["mode"] = $rules["mode"];
      $db->insert('jz_user_room', $add);
	}
	arsort($jflist);
  	if($mode && "积分模式" == $mode) {
        $credits = 0;
        $idx = 0;
        foreach ($jflist as $uid => $jifen) {
            if(0 < $jifen) {
                if(0 == $rules["target"][2] && 1 >= $idx) {
                    if(1 == $rules["target"][$idx]) {
                        $cdt = $jifen * $welfare;
                        $credits += $cdt;
                        $jifen -= $cdt;
                    }
                }
                if(1 == $rules["target"][2]) {
                    $cdt = $jifen * $welfare;
                    $credits += $cdt;
                    $jifen -= $cdt;
                }
            }
          	if($roomInfo['uid'] != $uid && ((0 == $rules["target"][2] && $idx <= 1 && 1 == $rules["target"][$idx]) || 1 == $rules["target"][2]) && $cdt > 0) {
                $add = array();
                $add['uid'] = $uid;
                $add['room'] = $id;
                $add['overtime'] = time();
                $add['jifen'] = 0 - $cdt;
                $add['type'] = $Room[$id]['lx'];
                $add["settlementType"] = 2;
                $add["mode"] = $rules["mode"];
                $db->insert('jz_user_room', $add);
            }
            $idx++;
            if($roomInfo['uid'] == $uid) {
                $userCredits = $db->getOne("SELECT * FROM jz_user WHERE id='{$uid}'");
                $userCredits['credits'] += (int)$jifen;
                $db->update("jz_user", $userCredits, "id='{$userCredits['id']}'");
            } else {
                $qunJf = $db->getOne("SELECT * FROM jz_qun WHERE open='{$roomInfo['uid']}' AND uid='{$uid}'");
                $qunJf["credits"] += (int)$jifen;
                $db->update("jz_qun", $qunJf, "open='{$roomInfo['uid']}' AND uid='{$uid}'");
            }
        }
        if($credits > 0) {
            $add = array();
            $add['uid'] = $roomInfo['uid'];
            $add['room'] = $id;
            $add['overtime'] = time();
            $add['jifen'] = $credits;
            $add['type'] = $Room[$id]['lx'];
            $add["settlementType"] = 2;
          	$add["mode"] = $rules["mode"];
            $db->insert('jz_user_room', $add);
        }
        $userCredits = $db->getOne("SELECT * FROM jz_user WHERE id='{$roomInfo['uid']}'");
        $userCredits['credits'] += $credits;
        $db->update("jz_user", $userCredits, "id='{$userCredits['id']}'");
    }
	$user = array();
	foreach ($jflist as $key => $value) {
		$user[] = $Room[$id]['user'][$key]->user;
	}
	$room['id'] = $Room[$id]['xx']['roomid'];
	$room['zjs'] = $Room[$id]['xx']['js'];
	$room['time'] = date('Y-m-d H:i:s', time());
	$room['user'] = $user;
	$room['fangzhu'] = $Room[$id]['user'][$Room[$id]['xx']['uid']]->user;
	foreach ($user as $key => $value) {
		unset($user[$key]['nickname']);
	}
	$save = array();
	$save['js'] = $Room[$id]['xx']['js'];
	$save['overxx'] = json_encode($user, JSON_UNESCAPED_UNICODE);
	$save['endtime'] = time();
	$db->update('jz_room', $save, 'id=' . $id);
	foreach ($Room[$id]['user'] as $connection3) {
		if ($connection3->user['online'] != -1) {
			act('overroom', $room, $connection3);
			$connection3->close();
		}
	}
	$dkxx = $db->getOne("select * from jz_server where dk='" . $Room[$id]['xx']['dk'] . "'");
	$save = array();
	$save['num'] = $dkxx['num'] - 1;
	$db->update('jz_server', $save, 'id=' . $dkxx['id']);
	global $connection2;
	$dataxx = array();
	$dataxx['act'] = 'endroom';
	$connection2->send(json_encode($dataxx));
	unset($Room[$id]);
}