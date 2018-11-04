<?php
global $Room;
        if($data2['isjoinlook'])
        {
            act('initroom',$msg,$connection,false);
        }
        else
        {
            act('initroom',$msg,$connection);
        }