<?php
if (!$data2['play']) {
	if (($data2['id'] == 'gz2') || ($data2['id'] == 'px') || ($data2['id'] == 'target')) {
		if ($connection->rule[$data2['id']][$data2['key']]) {
			$connection->rule[$data2['id']][$data2['key']] = 0;
			$msg = array();
			$msg['id'] = $data2['id'] . $data2['key'];
			$msg['html'] = 'active';
			act('removeid', $msg, $connection);
		} else {
			$connection->rule[$data2['id']][$data2['key']] = 1;
          	$msg = array();
			$msg['id'] = $data2['id'] . $data2['key'];
			$msg['html'] = 'active';
			act('addid', $msg, $connection);
		}
      	if($data2['id'] == 'target') {
        	$msg = array('html' => 'active');
          	if($data2['key'] == 2 && $connection->rule[$data2['id']][$data2['key']] == 1) {
                if($connection->rule[$data2['id']][0] == 1) {
                    $connection->rule[$data2['id']][0] = 0;
                    $msg['id'] = $data2['id'] . '0';
                    act('removeid', $msg, $connection);
                }
                if($connection->rule[$data2['id']][1] == 1) {
                    $connection->rule[$data2['id']][1] = 0;
                    $msg['id'] = $data2['id'] . '1';
                    act('removeid', $msg, $connection);
                }
            }
          	if($data2['key'] == 0 || $data2['key'] == 1) {
              	$connection->rule[$data2['id']][2] = 0;
            	$msg['id'] = $data2['id'] . '2';
              	act('removeid', $msg, $connection);
            }
          	if($connection->rule[$data2['id']][0] == 0 && $connection->rule[$data2['id']][1] == 0 && $connection->rule[$data2['id']][2] == 0) {
            	$connection->rule[$data2['id']][$data2['key']] = 1;
                $msg['id'] = $data2['id'] . $data2['key'];
              	act('addid', $msg, $connection);
            }
        }
	} else {
		$connection->rule[$data2['id']] = $data2['key'];
		$msg = array();
      	if($data2['id'] == 'mode') {
          	if($data2['key'] == '1') {
                $msg['id'] = 'welfare';
                $msg['html'] = 'hidee';
                act('removeid', $msg, $connection);
                $msg['html'] = 'showw';
                act('addid', $msg, $connection);
              	$msg['id'] .= $connection->rule['welfare'];
              	$msg['html'] = 'active';
              	act('active', $msg, $connection);
                $msg['id'] = 'target';
                $msg['html'] = 'hidee';
                act('removeid', $msg, $connection);
                $msg['html'] = 'showw';
                act('addid', $msg, $connection);
              	foreach($connection->rule['target'] as $key => $val) {
              		if($val == 1) {
                  		$msg['id'] = 'target' . $key;
                      	$msg['html'] = 'active';
                      	act('removeid', $msg, $connection);
              			act('addid', $msg, $connection);
                    }
                }
              	$msg['id'] = 'admittance';
                $msg['html'] = 'hidee';
                act('removeid', $msg, $connection);
                $msg['html'] = 'showw';
                act('addid', $msg, $connection);
              	$msg['id'] .= $connection->rule['admittance'];
              	$msg['html'] = 'active';
              	act('active', $msg, $connection);
            } else if($data2['key'] == '0') {
            	$msg['id'] = 'welfare';
                $msg['html'] = 'showw';
                act('removeid', $msg, $connection);
                $msg['html'] = 'hidee';
                act('addid', $msg, $connection);
                $msg['id'] = 'target';
                $msg['html'] = 'showw';
                act('removeid', $msg, $connection);
                $msg['html'] = 'hidee';
                act('addid', $msg, $connection);
              	$msg['id'] = 'admittance';
                $msg['html'] = 'showw';
                act('removeid', $msg, $connection);
                $msg['html'] = 'hidee';
                act('addid', $msg, $connection);
            }
          	act('notifyNiceScroll', '', $connection);
        }
      	if($data2['id'] == 'target') {
          foreach($connection->rule['target'] as $key => $val) {
               if($val == 1) {
                 $msg['id'] = 'target' . $key;
                 $msg['html'] = 'active';
                 act('removeid', $msg, $connection);
                 act('addid', $msg, $connection);
                }        
          }
        }
		$msg['id'] = $data2['id'] . $data2['key'];
		$msg['html'] = 'active';
		act('active', $msg, $connection);
	}
} else {
	$play = $data2['play'];
	$connection->rule = array();
	$connection->rule['play'] = $play;
  	if($play['mode']){
      $connection->rule['mode']=0;
      $msg=array();
      $msg['id']='mode0';
      $msg['html']='active';
      act('active',$msg,$connection);
    }
  if($play['welfare']){
    $connection->rule['welfare'] = 0;
    $msg=array();
    $msg['id']='welfare';
    $msg['html']='hidee';
    act('addid',$msg,$connection);
  }
  if($play['target']){
    if(!isset($connection->rule['target'])) {
        $connection->rule['target'][0] = 1;
        $connection->rule['target'][1] = 0;
        $connection->rule['target'][2] = 0;
    }
    $msg=array();
    $msg['id']='target';
    act('addid',$msg,$connection);
  }
  if($play['admittance']){
    $connection->rule['admittance'] = 0;
    $msg=array();
    $msg['id']='admittance0';
    $msg['html']='active';
    act('active',$msg,$connection);
  }
	if ($play['df']) {
		$connection->rule['df'] = 0;
		$msg = array();
		$msg['id'] = 'df0';
		$msg['html'] = 'active';
		act('active', $msg, $connection);
	}
  	if ($play['bp']) {
		$connection->rule['bp'] = 0;
		$msg = array();
		$msg['id'] = 'bp0';
		$msg['html'] = 'active';
		act('active', $msg, $connection);
	}
    	if ($play['kp']) {
		$connection->rule['kp'] = 0;
		$msg = array();
		$msg['id'] = 'kp0';
		$msg['html'] = 'active';
		act('active', $msg, $connection);
	}
	if ($play['gz']) {
		$connection->rule['gz'] = 0;
		$msg = array();
		$msg['id'] = 'gz0';
		$msg['html'] = 'active';
		act('active', $msg, $connection);
	}
	if ($play['js']) {
		$connection->rule['js'] = 0;
		$msg = array();
		$msg['id'] = 'js0';
		$msg['html'] = 'active';
		act('active', $msg, $connection);
	}
	if ($play['sz']) {
		$connection->rule['sz'] = 0;
		$msg = array();
		$msg['id'] = 'sz0';
		$msg['html'] = 'active';
		act('active', $msg, $connection);
	}
	if ($play['cm']) {
		$connection->rule['cm'] = 0;
		$msg = array();
		$msg['id'] = 'cm0';
		$msg['html'] = 'active';
		act('active', $msg, $connection);
	}
	if ($play['sx']) {
		$connection->rule['sx'] = 0;
		$msg = array();
		$msg['id'] = 'sx0';
		$msg['html'] = 'active';
		act('active', $msg, $connection);
	}
	if ($play['zm']) {
		$connection->rule['zm'] = 0;
		$msg = array();
		$msg['id'] = 'zm0';
		$msg['html'] = 'active';
		act('active', $msg, $connection);
	}
	if ($play['gp']) {
		$connection->rule['gp'] = 0;
		$msg = array();
		$msg['id'] = 'gp0';
		$msg['html'] = 'active';
		act('active', $msg, $connection);
	}
	if ($play['gd']) {
		$connection->rule['gd'] = 0;
		$msg = array();
		$msg['id'] = 'gd0';
		$msg['html'] = 'active';
		act('active', $msg, $connection);
	}
	if ($play['zd']) {
		$connection->rule['zd'] = 0;
		$msg = array();
		$msg['id'] = 'zd0';
		$msg['html'] = 'active';
		act('active', $msg, $connection);
	}
}
if (isset($connection->user['history_select'])) {
	$history_select = $db->getOne('SELECT `history_select` FROM `jz_user` WHERE `id` = ' . ceil($connection->user['id']));
	$history_select = !empty($history_select['history_select']) ? json_decode($history_select['history_select'], true) : [];
	$type = $connection->rule['play']['type'];
	if (empty($history_select[$type])) {
		$history_select[$type] = [];
	}
	$rule = $connection->rule;
	unset($rule['play']);
	$history_select[$type]['rule'] = $rule;
	$db->update('jz_user', ['history_select' => json_encode($history_select)], 'id=' . ceil($connection->user['id']));
} 