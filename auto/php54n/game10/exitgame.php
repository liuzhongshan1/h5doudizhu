<?php
         global $Room;




        
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


        //房间id
        $id=$connection->user['room'];


        echo "\r\n----------------------------------退出游戏加入观战";
        var_dump($Room[$id]['xx']['js']);
        echo "----------------------------------\r\n";
        if($Room[$id]['xx']['js']<1)
        {
                unset($Room[$id]["user"][$connection->user['id']]);

                $msg=$connection->user['index'];
        
        
                foreach ($Room[$id]['user'] as $connection3) {
                        act('removeuser2',$msg,$connection3,false);
                }

                act_send_lookgame('removeuser2',$msg,$connection);

                $Room[$id]['index'][]=$connection->user['index'];
                sort($Room[$id]['index']);


                //移除userlist
                foreach ($Room[$id]['user'] as $connection3) {
                        $userlist[$connection3->user['id']]=1;
                }
                //unset($userlist[$connection->user['id']]);
                $save['user']=json_encode($userlist);
                $db->update('jz_room',$save,'id='.$db->s($id));
        }
        else
        {
               
        }
        
        // if(isset($connection->user['index']))
        // {
               
        // }


        // $roomInfo = $db->getOne("SELECT rule,uid FROM jz_room WHERE id='{$id}'");

        // $qunJf = $db->getOne("SELECT * FROM jz_qun WHERE open='{$roomInfo['uid']}' AND uid='{$uid}'");
        // $qunJf["credits"] +=  $connection->user['credits'];
        // $db->update("jz_qun", $qunJf, "open='{$roomInfo['uid']}' AND uid='{$connection->user['credits']}'");
        //unset($connection->user['index']);

        $Room[$id]["islookgame"][$connection->user['id']] = true;
        $Room[$id]["backjf"][$connection->user['id']] = $connection->user['dqjf'];
        // echo "\r\n----------------------------------退出游戏加入观战";
        // var_dump($Room[$id]["backjf"][$connection->user['id']]);
        // echo "----------------------------------\r\n";
       // output("清除游戏中数据:".$id);

     
        act('exitgamesuccess',$msg,$connection);

        // act('exitlookgamesucess',"{}",$connection);