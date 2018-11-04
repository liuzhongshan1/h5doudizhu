<?php
         global $Room;


         if($Room[$id]['xx']['zt']>0)
         {
                return tip("无法加入游戏，游戏已经开始，请重新刷新", $connection);
         }

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

        unset($Room[$id]["lookgame"][$connection->user['id']]);

        $connection->user['online'] = 1;

        $connection->user['exitlookGame'] =true;

        // act('exitlookgamesucess',"{}",$connection);
                //output("清除观战中数据:".$id);


        act('exitlookgamesuccess',$msg,$connection);