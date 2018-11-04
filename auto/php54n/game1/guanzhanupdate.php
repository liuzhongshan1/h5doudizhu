<?php
         global $Room;

        //房间id
        $id=$connection->user['room'];
       
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
        act('guanzhanupdate',$msg,$connection);