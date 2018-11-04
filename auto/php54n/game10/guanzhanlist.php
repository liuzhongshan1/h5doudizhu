<?php
         global $Room;

        //房间id
        $id=$connection->user['room'];


        /*

        总逻辑：
        1.加入观战
        2.退出观战
        3.观战视图同步
        加入观战逻辑，
        1.发送消息给房间里面的人我进来了
        2.加入到本房间观战集合里面
        3.如果已经在本房间观战，则是直接进入房间并观战
        4.如果已经加入了，广播情况的时候，观战也能收到原来的广播并且携带观战标识，前段不能操作可以用

        退出观战：
        从原来房间观战逻辑里面移除，并刷新
        */
       

        $plays = array();
        foreach ($Room[$id]['lookgame'] as $connection3) {
             
                  $p=array();
                  $p['id']=$connection3->user['id'];
                  $p['nickname']=$connection3->user['nickname'];
                  $p['img']=$connection3->user['img'];
                  $p['index']=$connection3->user['index'];
                  $p['dqjf']=$connection3->user['dqjf'];
                  $p['online']=$connection3->user['online'];
  
                  $plays[] = $p;
          }

          $zbsl = 0;

        foreach ($Room[$id]['user'] as $connection3) {
             
               if($connection3->user['zt']=='1'){
                   $zbsl=$zbsl+1;
               }


               
        }   
        $msg = array();

        $msg["plys"] = $plays;
        $msg["cstatus"] = $Room[$id]['xx']['zt'];

        $msg["zt"] = $connection->user['zt'];
        $msg["ztcount"] = $zbsl;
        //$msg["pcount"] = count($Room[$id]['user']);
        //var_dump($Room[$id]);
        act('guanzhanlist',$msg,$connection);