<?php
    //step0 游戏准备阶段
        global $Room;
       if($data2['isjoinlook'])
        {
            act('initroom',$msg,$connection,false);
        }
        else
        {
            act('initroom',$msg,$connection);
        }

