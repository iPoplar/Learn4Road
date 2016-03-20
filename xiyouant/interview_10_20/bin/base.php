<?php
/**
 * Created by PhpStorm.
 * User: zh
 * Date: 15-10-10
 * Time: 下午9:28
 * 做一些字符串转换的工作

 */
include_once('macro.php');
function change_direction_to_string( $direction )
{
    switch($direction)
    {
        case DIRECTION_WEB:
            return "WEB组";
        case DIRECTION_SAFE:
            return "安全组";
        case DIRECTION_OPERATE:
            return "技术运营组";
        case DIRECTION_ART:
            return "视觉设计组";
        default:
            return "未知分组";
    }
}
function change_status_to_string($status)
{
    switch($status)
    {

        case STATUS_SIGN_UP:
            return "注册";
            break;
        case STATUS_SIGN_IN:
            return "签到";
            break;
        case STATUS_FIRST_ONE_WAIT:
            return "一面一等待";
            break;
        case STATUS_FIRST_ONE_ING:
            return "一面一中";
            break;
        case
        STATUS_FIRST_SECOND_WAIT:
            return "一面二等待";
            break;
        case STATUS_FIRST_SECOND_ING:
            return "一面二中";
            break;
        case STATUS_FIRST_ONE_END:
            return "一面一结束";
            break;
        case STATUS_FIRST_END:
            return "一面结束";
            break;
        case STATUS_SECOND_WAIT:
            return "二面等待";
            break;
        case STATUS_SECOND_ING:
            return "二面进行中";
            break;
        case STATUS_SECOND_END:
            return "二面结束";
            break;
        case STATUS_END:
            return "结束";
        case STATUS_WAIT:
            return "等待";
        case STATUS_FIRST_PASS:
            return "一面通过";
        case STATUS_FIRST_NO_PASS:
            return "一面未通过";
        case STATUS_SECOND_PASS:
            return "二面通过";
        case STATUS_SECOND_NO_PASS:
            return "二面未通过";
        default:
            return "未知状态";
    }
}