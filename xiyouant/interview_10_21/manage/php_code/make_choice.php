<?php
/**
 * Created by PhpStorm.
 * User: zh
 * Date: 15-10-14
 * Time: 上午12:22
 * 根剧传送过来的数据进行选择通过或者未通过
 */

include_once('../../bin/base.php');
include_once('../../bin/player.php');
include_once('../../bin/interview.php');
include_once('../output.php');

session_start();

if (!isset($_SESSION['valid_user'])) {
    do_html_URL("../login/index.php", "未登陆");
    exit;
}

$result = $_POST['result'];
$count  = $_POST['num'];


foreach($result as $var )
{
    $interview_id = $var['interview_id'];


    switch($var['choose'])
    {
        case "wait":
            break;
        case "pass":

            $interview = new interview($interview_id);

            switch($interview->get_interview_status())
            {
                case STATUS_FIRST_END:
                    $interview->player->change_status(STATUS_FIRST_PASS);
                    // 用以返回值，保证正确

                    break;
                case STATUS_SECOND_END:

                    $interview->player->change_status(STATUS_SECOND_PASS);
                    break;
            }
            break;
        case "no_pass":
            $interview = new interview($interview_id);
            switch($interview->get_interview_status())
            {
                case STATUS_FIRST_END:
                    $interview->player->change_status(STATUS_FIRST_NO_PASS);
                    break;
                case STATUS_SECOND_END:
                    $interview->player->change_status(STATUS_SECOND_NO_PASS);
                    break;
            }
            break;
        default:
            break;
    }
}
// 用以返回值，保证正确
$return_array = array("test"=>"结束");
$demo_json = json_encode($return_array, JSON_UNESCAPED_UNICODE);
echo $demo_json;
exit;

