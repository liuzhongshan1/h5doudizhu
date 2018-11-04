<?php
         global $Room;

         //房间id
        $id=ceil($data2['room']);
        $roomInfo = $db->getOne("SELECT rule,uid FROM jz_room WHERE id='{$id}'");
        $rules = json_decode($roomInfo["rule"], true);
        $admittances = explode(',', $rules['play']['admittance']);
        preg_match_all('/\d+/', $admittances[$rules['admittance']], $admittance);
        if($rules["mode"])
{
  	$isQunZhu = $roomInfo["uid"] == $connection->user["id"];
  	$mem = $db->getOne("SELECT * FROM jz_qun WHERE open='{$roomInfo["uid"]}' AND uid='{$connection->user["id"]}'");
  	if(!$isQunZhu && (!$mem || 0 == count($mem))) {
    	return tip("加入积分模式游戏需要先加入群组，请联系群主邀请加入！", $connection);
    }
  	if(($isQunZhu && $admittance['0']['0'] > $connection->user['credits']) || (!$isQunZhu && $admittance['0']['0'] > $mem['credits'])) {
  		return tip('积分不足' . $admittance['0']['0'] . '，请联系' .  ($isQunZhu ? '客服' : '群主') . '上分！', $connection);
    }
}
          
         if(!$Room[$id]){
          $Room[$id]['xx']=$db->getOne("select * from jz_room where id='".$db->s($id)."'");
         
          $dkxx=$db->getOne("select * from jz_server where dk='".$db->s($Room[$id]['xx']['dk'])."'");
          $save=array();
          $save['num']=$dkxx['num']+1;
          $db->update('jz_server',$save,'id='.$db->s($dkxx['id']));

          global $connection2;
          $dataxx=array();
          $dataxx['act']='creatroom';
          $connection2->send(json_encode($dataxx));
          
          $Room[$id]['index']=array(0,1,2,3,4,5,7,8);
          $rule=json_decode($Room[$id]['xx']['rule'],true);

          $dfxx=explode(',',$rule['play']['df']);
          $bsxx=explode(',',$rule['play']['bs']);
          $gzxx=explode(',',$rule['play']['gz']);
          $pxxx=explode(',',$rule['play']['px']);
          $szxx=explode(',',$rule['play']['sz']);

          preg_match_all("/\d+/",$gzxx[$rule['gz']],$gz);

          preg_match_all("/\d+/",$dfxx[$rule['df']],$df);
         
           preg_match_all("/\d+/",$bsxx[$rule['bs']],$bsf);

          for($i=0;$i<11;$i++){
              $niuniu[$i]=1;
          }
          foreach ($gz[0] as $key => $value) {
              $niuniu[(10-$key)]=$value;
          }

          foreach ($pxxx as $key => $value) {
              if($rule['px'][$key]==1){
                  preg_match_all("/\d+/",$value,$px);
                  $dkxx['px'][]=$value;
                  $niuniu[(11+$key)]=$px['0']['0'];
                  $Room[$id]['pai'.$key]=1;
              }
          }
                      $Room[$id]['ruletime']['zb'] = $rule['time']['zb'];
			$Room[$id]['ruletime']['qz'] = $rule['time']['qz'];
			$Room[$id]['ruletime']['xz'] = $rule['time']['xz'];
			$Room[$id]['ruletime']['tp'] = $rule['time']['tp'];	
          $Room[$id]['type']=$rule['play']['id'];
          $Room[$id]['lx']=$rule['play']['type'];
          $Room[$id]['df']=$df['0']['0'];
           $Room[$id]['bs']=$bs['0']['0'];
          $Room[$id]['niuniu']=$niuniu;
          $Room[$id]['sz']=$szxx[$rule['sz']];
          $Room[$id]['djszt']=0;
          $Room[$id]['beishu']=1;
          if($Room[$id]['type']==2){
              $Room[$id]['bank']['id']=$Room[$id]['uid'];
          }
      }
        
        if(!$Room[$id]["lookgame"])
        {
            $Room[$id]["lookgame"] = array();
        }


      

        echo "--------------------------------------------------------------执行观战逻辑。。。。=============================================。";


        $connection->user['room'] = $id;
        $Room[$id]["lookgame"][$connection->user['id']] = $connection;


        echo "--------------------------------------------------------------执行观战逻辑。。。。=============================================。dqjf".$connection->user['dqjf'];

        
    

        //自己
        foreach ($Room[$id]['user'] as $connection3) {
            $mem = $db->getOne("SELECT * FROM jz_qun WHERE open='{$roomInfo["uid"]}' AND uid='{$connection->user["id"]}'");
            $mem3 = $db->getOne("SELECT * FROM jz_qun WHERE open='{$roomInfo["uid"]}' AND uid='{$connection3->user["id"]}'");
          
              $msg=array();
              $msg['user']['id']=$connection3->user['id'];
              $msg['user']['nickname']=$connection3->user['nickname'];
              $msg['user']['img']=$connection3->user['img'];
              $msg['user']['index']=$connection3->user['index'];


              
              if($connection3->user['id']==$connection->user['id'])
            {
             
              $msg['user']['dqjf'] =  $Room[$id]["backjf"][$connection->user['id']];
            }
            else
            {
              $msg['user']['dqjf'] =  $connection3->user['dqjf'];
            }
              $msg['user']['online']=$connection3->user['online'];
              $msg['user']['zt']=$connection3->user['zt'];
                if($roomInfo["uid"] == $connection3->user["id"]) {
                  $msg['user']['credits'] = $connection3->user['credits'];
              } else {
                  $msg['user']['credits'] = $mem3['credits'];
              }
                $msg['mode'] = $rules["mode"];
              reqact(['act'=> 'guanzhanupdate'], $connection3);
              act('adduser',$msg,$connection,false);
      }

      //别人

     
        $data=array();
        $data['act'] = 'step' . $Room[$id]['xx']['zt'];
        $data['isjoinlook'] = true;
        reqact($data,$connection);
        /*

        总逻辑：
        1.加入观战
        2.退出观战
        3.观战视图同步

        加入观战逻辑，
        1.发送消息给房间里面的人我进来了
        2.加入到集合里面
        3.通知一下房间里面的人(可以发也可以不发)
        4.玩一局后，可以选择加入
        */


        if ($Room[$id]['xx']['zt'] == 1) {
      
        //如果人数够了就开始游戏吧

        $zbsl=0;
        $zrs=0;
        foreach ($Room[$id]['user'] as $connection3) {
             if($connection3->user['online']=='-1' && $Room[$id]['xx']['zt']<2){
                    $Room[$id]['user'][$connection3->user['id']]->user['zt']=0;
             }
            if($connection3->user['zt']=='1'){
                $zbsl=$zbsl+1;
            }
            if($connection3->user['online']=='1'){
                $zrs=$zrs+1;
            }


            //如果是观战，直接++
            if($Room[$id]["lookgame"][$connection3->user['id']])
            {
                $zrs=$zrs-1;
            }
            
            if($connection3->user['online']!='-1'){
                $msg=$connection->user['index'];
                act('zbuser',$msg,$connection3);
            }
        }

        if($zrs==$zbsl && $zrs>=2){
                $data=array();
                $data['act']='startroom';
                $data['time']=$Room[$id]['timexx'];
                $data['room']=$id;
                reqact($data,'');
                return false;
        }
    }