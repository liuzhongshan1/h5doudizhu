<?php
global $Room;
$id = ceil($data2['room']);
if ($data2['time'] != $Room[$id]['timexx']) {
	return false;
}
$Room[$id]['timexx'] = time();
$Room[$id]['xx']['zt'] = 6;
cleardjs($Room[$id]['djs'], $id);
$time_interval = 15;
$Room[$id]['time'] = time() + $time_interval;
$Room[$id]['timexx'] = time();
djs($time_interval, 'setfanpai', $id, $Room[$id]['timexx']);
foreach ($Room[$id]['user'] as $connection3) {
	if ($connection3->user['zt'] == '1' && $connection3->user['index'] < 4) {
		act('operationButton', 12, $connection3);
	}
	if ($connection3->user['online'] != '-1') {
		act('djs', $Room[$id]['time'], $connection3);
		act('divRobBankerText', 4, $connection3);
	}
}