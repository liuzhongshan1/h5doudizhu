<?php
$id = ceil($data2['id']);
$server = $db->getOne("select * from jz_server where type='" . $db->s($id) . "' and zt=1 order by num asc");
$playlist = $db->getAll("select * from jz_rule where type='" . $db->s($id) . "' and zt=1 order by `sort` desc");
$msg = array();
$msg['id'] = 'room';
$msg['html'] = ' <div class="createRoomBack"></div>
    <div class="mainPart" style="height: auto;">            
        <div class="createB"></div>
        <div class="createTitle">
            <img src="/app/files/d_11/images/common/createroom2.png">
        </div>              
        <img src="/app/files/d_11/images/common/cancel.png" class="cancelCreate" onclick="cancelCreate();$(\'.nicescroll-rails\').remove();">';
$playlist[0]['name'] = trim($playlist[0]['name']);
if (!empty($playlist[0]['name'])) {
	$msg['html'] .= '<div  class="scope xuanzefj-nav">';
	foreach ($playlist as $key => $value) {
		$msg['html'] .= '<div  id="selectBanker' . strip_tags($value[id]) . '"   onclick="send(\'xzplay\',{id:' . strip_tags($value[id]) . '})" class="selectBanker' . ($key + 1) . ' bankerUnSelected">
                    <img  class="img niuniusz niuniuselect"  src="/app/img/banker_selected.png">
                    <img  class="img niuniusz niuniuunselect"  src="/app/img/banker_unselected.png">
                    <p class="xuanzefj-nav-1">' . mb_substr(strip_tags($value['name']), 0, 2, 'utf-8') . '</p>
                    <p class="xuanzefj-nav-2" style="">' . mb_substr(strip_tags($value['name']), 2, 2, 'utf-8') . '</p>
                </div>';
	}
	$msg['html'] .= '</div>';
}
$msg['html'] .= '<div class="blueBack" style="height: auto;">
            <div class="selectPart xuanzefj-top-zt" style="">
                <div class="selectTitle xuanzefj-top">
                    创建房间,游戏未进行,不消耗房卡
                </div>
            </div>
            <div class="bullRull scope" id="setting"><div id="open-wrap"></div></div>
        </div>
        <div class="createCommmit" onclick="send(\'openroom\',{})"></div>';
$msg["html"] .= "<script type=\"text/javascript\">
			$(\"#setting\").niceScroll(\"#open-wrap\", {
                cursorcolor: \"#ccc\",//#CC0071 光标颜色
                cursoropacitymax: 0.7, //改变不透明度非常光标处于活动状态（scrollabar“可见”状态），范围从1到0
                touchbehavior: true, //使光标拖动滚动像在台式电脑触摸设备
                cursorwidth: \"1px\", //像素光标的宽度
                //boxzoom: true
            });
            function notifyNiceScroll() {
            	$(\"#setting\").getNiceScroll().resize();
            }
		</script>";
act('html', $msg, $connection);
$msg = array();
$msg['id'] = 'room';
act('showid', $msg, $connection);
$last_id = $playlist['0']['id'];
if (isset($connection->user['history_select'])) {
	$history_select = $db->getOne('SELECT `history_select` FROM `jz_user` WHERE `id` = ' . ceil($connection->user['id']));
	$history_select = !empty($history_select['history_select']) ? json_decode($history_select['history_select'], true) : [];
	$last_id = !empty($history_select[$id]) ? ceil($history_select[$id]['id']) : $playlist['0']['id'];
}
$data['act'] = 'xzplay10';
$data['id'] = $last_id;
reqact($data, $connection); 

           