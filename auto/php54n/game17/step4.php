<?php
global $Room;
$id = $connection->user['room'];
act('initroom', $msg, $connection);
$msg = array();
$msg['id'] = 'jsxx';
$msg['html'] = $Room[$id]['xx']['js'] . '&nbsp;/&nbsp;' . $Room[$id]['xx']['zjs'] . '&nbsp;局';
act('html', $msg, $connection);
$index = array();
foreach ($Room[$id]['user'] as $key => $connection3) {
	if ($connection3->user['zt'] == 1) {
		$index[] = array('index' => $connection3->user['index'], 'id' => $connection3->user['id']);
	}
}
$msg = array();
$msg['user'] = $index;
if ($Room[$id]['user'][$connection->user['id']]->user['zt'] == '1') {
	$msg['card'] = $connection->user['card'];
	for ($i = 0; $i < 5; $i++) {
		if ($msg['card'][$i]['zt'] == 0) {
			unset($msg['card'][$i]);
		}
	}
}
if ($connection->user['is_grade'] == 1) {
	$msg['allcard'] = $Room[$id]['allcard'];
}
act('allfapai', $msg, $connection);
act('mp3play', 'fapai', $connection);
act('operationButton', -1, $connection);
act('sss', $Room[$id]['bank']['index'], $connection);
if ($Room[$id]['time'] > 0) {
	act('djs', $Room[$id]['time'], $connection);
	act('divRobBankerText', 3, $connection);
	if ($Room[$id]['user'][$connection->user['id']]->user['zt'] == '1' && $Room[$id]['user'][$connection->user['id']]->user['beishu'] == '-1') {
		if ($connection->user['index'] != $Room[$id]['bank']['index']) {
			act('operationButton', 4, $connection);
		} else {
			act('operationButton', 5, $connection);
		}
	}
}
if ($Room[$id]['type'] == 4) {
	$msg = array();
	$img = '/app/img/X-' . $Room[$id]['beishu'] . '.png';
	$msg['index'] = $Room[$id]['bank']['index'];
	$msg['img'] = $img;
	act('showmemberTimesText', $msg, $connection);
}
if ($Room[$id]['type'] != '5') {
	foreach ($Room[$id]['user'] as $connection3) {
		if ($connection3->user['beishu'] != '-1' && $connection3->user['zt'] == '1') {
			$msg = array();
			$msg['index'] = $connection3->user['index'];
			$msg['zt'] = $connection3->user['beishu'];
			act('showxian', $msg, $connection);
		}
	}
}