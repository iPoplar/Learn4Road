<?php
/**
 * Created by PhpStorm.
 * User: zh
 * Date: 15-10-12
 * Time: 下午4:18
 * 获取分数,修改分数
 * 需要改变状态改变状态,并且　让一面一　跳转到一面二　
 */

include_once('../../bin/interview.php');
include_once('../../bin/judge.php');
include_once('../../bin/base.php');
session_start();

if (!isset($_SESSION['valid_user'])) {
    do_html_URL("../login/index.php", "未登陆");
    exit;
}
$judge = new judge(array("name"=>$_SESSION['valid_user']));
$interview_id =  $_SESSION["interview_id"];

$interview = new interview($interview_id);

$interview_attitude = $_POST['att1'];
$group_attitude = $_POST['att2'];
$life_attitude = $_POST['att3'];
$base_knowledge = $_POST['know1'];
$direction_knowledge = $_POST['know2'];
$comment = $_POST['comment'];

$interview->change_all_score($interview_attitude,$group_attitude,$life_attitude,$base_knowledge,$direction_knowledge,$comment);
$flag = 0;// 用以判断是否为评分请求
switch($interview->get_interview_status())
{
    case STATUS_FIRST_ONE_ING:
        $new = STATUS_FIRST_ONE_END;
        break;
    case STATUS_FIRST_SECOND_ING:
        $new = STATUS_FIRST_END;
        break;
    case STATUS_SECOND_ING:
        $new = STATUS_SECOND_END;
        break;
    default:
        $flag = 1;// 为修改请求

}
if(!$flag)// 为评分请求
{
    $interview->change_status($new);

    if($new == STATUS_FIRST_ONE_END)// 由一面一结束　跳转　到一面二等待
    {
        print_r("new:$new");
        $interview->player->change_status(STATUS_FIRST_SECOND_WAIT);
        interview::add_interview($interview->player->id,STATUS_FIRST_SECOND_WAIT);
    }
}
?>
<html>
<head>
    <script>location.href='../index.php';</script>
</head>
</html>


