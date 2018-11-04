<?php
$connection->rule['js'];
$jsxx = explode(',', $connection->rule['play']['js']);
preg_match_all("/\d+/", $jsxx[$connection->rule['js']], $js);
$connection->user = $db->getOne("select * from jz_user where id='" . $db->s($connection->user['id']) . "'");
if ($connection->user['fk'] < $js['0']['1']) {
            return  act('alert2v', '房卡不足', $connection);
}

$mode = $connection->rule["mode"];
$admittances = explode(',', $connection->rule['play']['admittance']);
preg_match_all('/\d+/', $admittances[$connection->rule['admittance']], $admittance);
if($mode)
{
  	if(0 == $connection->user["sfgl"]) {
    	return act('alert2v',"积分模式需要开启管理功能！", $connection);
    }
  	if($admittance['0']['0'] > $connection->user['credits']) {
  		return tip('积分不足' . $admittance['0']['0'] . '，请联系群主上分！', $connection);
    }
}
$server = $db->getOne("select * from jz_server where type='" . $db->s($connection->rule['play']['type']) . "' and zt=1 order by num asc");
if (!$server) {
            return  act('alert2v', '游戏维护中，请稍后再试', $connection);
}
$add = array();
$add['type'] = $connection->rule['play']['type'];
if ($add['type'] == 27) {
	$connection->rule['px'][0] = 1;
}
$add['dk'] = $server['dk'];
$add['rule'] = json_encode($connection->rule, JSON_UNESCAPED_UNICODE);
$add['user'] = json_encode(array(), JSON_UNESCAPED_UNICODE);
$add['time'] = time();
$add['online'] = 0;
$add['zt'] = 0;
$add['zjs'] = $js['0']['0'];
$add['js'] = 0;
$add['fk'] = $js['0']['1'];
$add['uid'] = $connection->user['id'];
$add['roomid'] = in_array($add['type'], [1, 2]) ? rand(5000000, 5999999) : rand(14200000, 14299999);
$roomid = $db->insert('jz_room', $add);
$save['fk'] = $connection->user['fk'] - $js['0']['1'];
$db->update('jz_user', $save, 'id="' . $db->s($connection->user['id']) . '"');
$msg = array();
$msg['game'] = $connection->rule['play']['type'];
$msg['room'] = $roomid;
$msg['dk'] = $server['dk'];
act('goroom', $msg, $connection); 