<?php
/**
 * Created by PhpStorm.
 * User: zh
 * Date: 15-10-13
 * Time: 上午1:48
 * 提供一些功能性函数
 */
// 找不到，返回　null
function get_interview_by_player_id_and_status($player_id, $interview_status)
{
    $mysql = new Mysql();
    $ret = $mysql->getLine("SELECT * FROM interview WHERE player_id=$player_id AND interview_status=$interview_status");
    if(!$ret)
    {
        return null;
    }
    $return = new interview($ret['id']);
    return $return;
}