<?php
$server = $db->getOne("select * from jz_server where id=" . $data2['id']);
if ($server['zt'] == 0) {
	return act('error', "服务器未启动", $connection);
}
$title = mb_convert_encoding($server[title] . '-' . $server[id], "GB2312", "UTF-8");
$zmm = popen('runend.bat ' . $title, "r");
act('success', "等待关闭", $connection);