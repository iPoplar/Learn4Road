<?php

/**
 * Created by PhpStorm.
 * User: zh
 * Date: 15-10-11
 * Time: 下午6:51
 */
include_once("../bin/player.php");
include_once("../bin/interview.php");
include_once("../bin/Mysql.php");
include_once("../bin/notice.php");

//$_GET['id'] = '04131097';
$id = trim($_GET['id']);
$player = new player(array('student_id'=>$id));




if(!$player->check_ok())
{
    $return  =  array("id"=>"000000","test"=>"你未注册，或已经结束面试");
    $demo_json = json_encode($return);
    $callback = isset($_GET['callback'])?trim($_GET['callback']):'';
    echo $callback.'('.$demo_json.')';
        exit;
}
else{


    switch($player->get_status())
    {
        case STATUS_SIGN_UP:
            $player->change_status(STATUS_FIRST_ONE_WAIT);
            $interview = interview::add_interview($player->id,STATUS_FIRST_ONE_WAIT);
            break;
        case STATUS_FIRST_PASS:
            $player->change_status(STATUS_SECOND_WAIT);
            $interview = interview::add_interview($player->id,STATUS_SECOND_WAIT);
            break;
        default:
            exit;// 其他情况，届拒绝签到

    }

    $return  =  array("id"=>$player->student_id,'name'=>$player->name,
        'status'=>$player->get_status(),'direction'=>$player->direction,"judge"=>'**');

    make_notice($player->student_id,$player->name,$player->get_status(),$player->direction,"签到，请等待通知");

    $demo_json = json_encode($return);
    $callback = isset($_GET['callback'])?trim($_GET['callback']):'';
    echo $callback.'('.$demo_json.')';
    exit;
}