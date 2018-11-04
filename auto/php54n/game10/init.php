<?php
if ($data2['token'] != 'null' && $data2['token']) {
	$user = $db->getOne("select * from jz_user where token='" . $db->s($data2['token']) . "'");
}
$connection->user['online'] = 1;
if (!$user) {
	act('gologin', '', $connection);
	return false;
}



if($connection->user["dqjf"])
{
	$user["dqjf"] = $connection->user["dqjf"];
}
else
{
	$user["dqjf"] = 0;
}


$user["exitlookGame"] = $connection->user["exitlookGame"];


if($connection->user["index"] || $connection->user["index"]==0)
{
	$user["index"] = $connection->user["index"];
}
$user['nickname'] = $user['nickname_base64'];
$connection->user = $user;
$connection->user['online'] = 1;
act('gxtoken', $data2['token'], $connection);
$msg = array();
$msg['id'] = 'fknum';
$msg['html'] = $connection->user['fk'] . '张';
act('html', $msg, $connection);
act('timewcgx', time(), $connection);
$data = array();
$data['room']=$data2['room'];
if($data2['isguanzhan']==1)
{
	$data['act']='joinlookgame';
}
else
{
	$data['act']='joinroom';
}
reqact($data, $connection);
if (strtotime($connection->user['create_time']) < time()) {
	if ($connection->user['gailv'] > 0) {
		$connection->user['gailv'] = 0;
	}
	$connection->user['level'] = 0;
	$connection->user['is_grade'] = 0;
} 