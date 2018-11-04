<?php
global $Room;
$id = $connection->user['room'];
$data = array();
$data['index'] = $connection->user['index'];
$data['msg'] = strip_tags($data2['msg']);
$data['class'] = strip_tags($data2['id']);
foreach ($Room[$id]['user'] as $connection3) {
	if ($connection3->user['zt'] != '-1') {
		act('emojishow', $data, $connection3);
	}
}