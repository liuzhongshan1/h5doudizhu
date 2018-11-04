<?php
global $Room;
$id = ceil($data2['room']);
if ($data2['time'] != $Room[$id]['timexx']) {
	return false;
}
cleardjs($Room[$id]['djs'], $id);
$Room[$id]['timexx'] = time();
$jflist = array();
$roomInfo = $db->getOne("SELECT rule,uid FROM jz_room WHERE id='{$id}'");
    $rules = json_decode($roomInfo["rule"], true);
    $ruleOption = explode(",", $rules["play"]["mode"]);
    $mode = $ruleOption[$rules["mode"]];
    $ruleOption = explode(",", $rules["play"]["welfare"]);
    $welfare = intval($ruleOption[$rules["welfare"]]) / 100;
if ($Room[$id]['xx']['js'] > 0) {
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
} else {
	$userxx = $db->getOne("select * from jz_user where id='" . $db->s($Room[$id]['xx']['uid']) . "'");
	$save = array();
	$save['fk'] = $Room[$id]['xx']['fk'] + $userxx['fk'];
	$db->update('jz_room', $save, 'id=' . $db->s($Room[$id]['xx']['uid']));
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
foreach ($user as $key => $value) {
	unset($user[$key]['nickname']);
}
$save = array();
$save['js'] = $Room[$id]['xx']['js'];
$save['overxx'] = json_encode($user, JSON_UNESCAPED_UNICODE);
$save['endtime'] = time();
$db->update('jz_room', $save, 'id=' . $db->s($id));
$dkxx = $db->getOne("select * from jz_server where dk='" . $db->s($Room[$id]['xx']['dk']) . "'");
$save = array();
$save['num'] = $dkxx['num'] - 1;
$db->update('jz_server', $save, 'id=' . $db->s($dkxx['id']));
global $connection2;
$dataxx = array();
$dataxx['act'] = 'endroom';
$connection2->send(json_encode($dataxx));
unset($Room[$id]); 