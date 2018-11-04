<?php
    //step1 游戏开始倒计数阶段
        global $Room;
        $id=$connection->user['room'];
       if($data2['isjoinlook'])
        {
            act('initroom',$msg,$connection,false);
            act('djs',$Room[$id]['time'],$connection,false);
            act('divRobBankerText',1,$connection,false);
        }
        else
        {
          act('initroom',$msg,$connection);
          act('djs',$Room[$id]['time'],$connection);
          act('divRobBankerText',1,$connection);
        }
       

