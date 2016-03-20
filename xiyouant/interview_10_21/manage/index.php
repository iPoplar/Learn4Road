<?php
/**
 * Created by PhpStorm.
 * User: zh
 * Date: 15-10-16
 * Time: 上午12:09
 */

session_start();
include_once('../bin/Mysql.php');
include_once('output.php');
//$_SESSION['valid_user'] = "safe";
if (!isset($_SESSION['valid_user'])) {
    do_html_URL("../login/index.php", "未登陆");
    exit;
}
$sql = new Mysql();

$players = $sql->getDate("SELECT * FROM player");

//$count_safe;
//$count_safe_first_one_waiting;
//$count_safe_first_two_waiting;
//$count_safe_second_waiting;
//$count_safe_first_one_ing;
//$count_safe_first_two_ing;
//$count_safe_second_ing;
//$count_safe_first_end;
//$count_safe_second_end;
//$count_safe_first_pass;
//$count_safe_second_pass;
//$count_safe_first_no_pass;
//$count_safe_second_no_pass;
//
//$count_web;
//$count_web_first_one_waiting;
//$count_web_first_two_waiting;
//$count_web_second_waiting;
//$count_web_first_one_ing;
//$count_web_first_two_ing;
//$count_web_second_ing;
//$count_web_first_end;
//$count_web_second_end;
//$count_web_first_pass;
//$count_web_second_pass;
//$count_web_first_no_pass;
//$count_web_second_no_pass;
//
//$count_operate;
//$count_operate_first_one_waiting;
//$count_operate_first_two_waiting;
//$count_operate_second_waiting;
//$count_operate_first_one_ing;
//$count_operate_first_two_ing;
//$count_operate_second_ing;
//$count_operate_first_end;
//$count_operate_second_end;
//$count_operate_first_pass;
//$count_operate_second_pass;
//$count_operate_first_no_pass;
//$count_operate_second_no_pass;
//
//$count_art;
//$count_art_first_one_waiting;
//$count_art_first_two_waiting;
//$count_art_second_waiting;
//$count_art_first_one_ing;
//$count_art_first_two_ing;
//$count_art_second_ing;
//$count_art_first_end;
//$count_art_second_end;
//$count_art_first_pass;
//$count_art_second_pass;
//$count_art_first_no_pass;
//$count_art_second_no_pass;
//
//$first_one_waiting = 0;
//$first_two_waiting = 0;
//$second_waiting = 0;
//$first_one_ing = 0;
//$first_two_ing = 0;
//$second_ing = 0;
//$first_end = 0;
//$second_end = 0;
//$first_pass = 0;
//$second_pass = 0;
//$first_no_pass = 0;
//$second_no_pass = 0;
////array("first_one_waiting"=>$first_one_waiting,"first_two_waiting"=>$first_two_waiting,"second_waiting"=>$second_waiting,"first_one_ing"=>$first_one_ing
////,"first_two_ing"=>$first_two_ing,"second_ing"=>$second_ing,"second_end"=>$second_end
////,"first_end"=>$first_end,"first_pass"=>$first_pass,"second_pass"=>$second_pass,"first_no_pass"=>$first_no_pass,"second_no_pass"=>$second_no_pass);

$safe_all_count = 0;
$web_all_count = 0;
$operator_all_count = 0;
$art_all_count = 0;
$safe = array("sign_up" => 0, "sign_in" => 0, "first_one_waiting" => 0, "first_two_waiting" => 0, "second_waiting" => 0, "first_one_ing" => 0
, "first_two_ing" => 0, "second_ing" => 0, "second_end" => 0
, "first_end" => 0, "first_pass" => 0, "second_pass" => 0, "first_no_pass" => 0, "second_no_pass" => 0);
$web = array("sign_up" => 0, "sign_in" => 0, "first_one_waiting" => 0, "first_two_waiting" => 0, "second_waiting" => 0, "first_one_ing" => 0
, "first_two_ing" => 0, "second_ing" => 0, "second_end" => 0
, "first_end" => 0, "first_pass" => 0, "second_pass" => 0, "first_no_pass" => 0, "second_no_pass" => 0);
$operator = array("sign_up" => 0, "sign_in" => 0, "first_one_waiting" => 0, "first_two_waiting" => 0, "second_waiting" => 0, "first_one_ing" => 0
, "first_two_ing" => 0, "second_ing" => 0, "second_end" => 0
, "first_end" => 0, "first_pass" => 0, "second_pass" => 0, "first_no_pass" => 0, "second_no_pass" => 0);
$art = array("sign_up" => 0, "sign_in" => 0, "first_one_waiting" => 0, "first_two_waiting" => 0, "second_waiting" => 0, "first_one_ing" => 0
, "first_two_ing" => 0, "second_ing" => 0, "second_end" => 0
, "first_end" => 0, "first_pass" => 0, "second_pass" => 0, "first_no_pass" => 0, "second_no_pass" => 0);

foreach ($players as $player) {

    switch ($player['direction']) {
        case DIRECTION_ART:
            $art_all_count++;
            each_player_statistic($player['status'], $art);
            break;
        case DIRECTION_WEB:
            $web_all_count++;
            each_player_statistic($player['status'], $web);
            break;
        case DIRECTION_SAFE:
            $safe_all_count++;
            each_player_statistic($player['status'], $safe);
            break;
        case DIRECTION_OPERATE:
            $operator_all_count++;
            each_player_statistic($player['status'], $operator);
            break;
        default :
            die("statistic 遇到 未知的 direction");

    }

}
$all = add($safe, $web, $operator, $art);


function each_player_statistic($player_status, &$array)
{
//    $array = array("first_one_waiting" => 0, "first_two_waiting" => 0, "second_waiting" => 0, "first_one_ing" => 0
//    , "first_two_ing" => 0, "second_ing" => 0, "second_end" => 0
//    , "first_end" => 0, "first_pass" => 0, "second_pass" => 0, "first_no_pass" => 0, "second_no_pass" => 0);

    switch ($player_status) {
        case STATUS_SECOND_NO_PASS:
            $array['second_no_pass']++;
            $array['first_pass']++;
            $array['sign_in']++;
            break;
        case STATUS_SECOND_PASS:
            $array['second_pass']++;
            $array['first_pass']++;
            $array['sign_in']++;
            break;

        case STATUS_SECOND_WAIT:
            $array['second_waiting']++;
            $array['first_pass']++;
            $array['sign_in']++;
            break;
        case STATUS_SECOND_ING:
            $array['second_ing']++;
            $array['first_pass']++;
            $array['sign_in']++;
            break;
        case STATUS_SECOND_END:
            $array['second_end']++;
            $array['first_pass']++;
            $array['sign_in']++;
            break;
        case STATUS_FIRST_PASS:
            $array['first_pass']++; // 一面通过的总人数
            $array['sign_in']++;
            break;
        case STATUS_FIRST_NO_PASS:
            $array['first_no_pass']++; // 一面 未通过的总人数
            $array['sign_in']++;
            break;
        case STATUS_FIRST_END:
            $array['first_end']++; // 一面结束，但没有表决的
            $array['sign_in']++;
            break;
        case STATUS_FIRST_SECOND_ING:
        case STATUS_FIRST_ONE_ING:
        case STATUS_FIRST_ONE_END:
            $array['sign_in']++;
            $array['first_two_ing']++;// 将一面的进行状态合并\
            break;
        case STATUS_FIRST_SECOND_WAIT:
        case STATUS_FIRST_ONE_WAIT:
            $array['sign_in']++;  // 签到的总人数
            $array['first_two_waiting']++;// 将一面的等待状态合并
            break;
        case STATUS_SIGN_UP:
            $array['sign_up']++; // 仍然是报名状态的
            break;
        default:
            die("统计函数 遗漏状态 " . $player_status);
    }
}

function add($safe, $web, $operator, $art)
{
    $all = array("sign_up" => 0, "sign_in" => 0, "first_one_waiting" => 0, "first_two_waiting" => 0, "second_waiting" => 0, "first_one_ing" => 0
    , "first_two_ing" => 0, "second_ing" => 0, "second_end" => 0
    , "first_end" => 0, "first_pass" => 0, "second_pass" => 0, "first_no_pass" => 0, "second_no_pass" => 0);
    $keys = array_keys($all);
    foreach ($keys as $key) {
        $all[$key] = $safe[$key] + $web[$key] + $operator[$key] + $art[$key];
    }
    return $all;
}

?>
<!DOCTYPE html>
<!-- saved from url=(0065)http://docs.bootcss.com/bootstrap-2.3.2/docs/examples/fluid.html# -->
<html lang="en">
<?php do_html_header("管理员") ?>
<body>

<?php do_html_top_bar() ?>

<div class="container-fluid">

    <div class="row-fluid">
        　　　　　<?php do_html_sidebar() ?>
        <!--/span-->

        <div class="span9">
            <div class="hero-unit">

                <h5>总记录</h5>
                <table class="table">
                    <tr>
                        <th>报名人数</th>
                        <th>面试人数</th>
                        <th>一面通过</th>
                        <th>二面通过</th>
                        <th>一面未通过</th>
                        <th>二面未通过</th>

                    </tr>
                    <tr>
                        <td><?php echo $all['sign_up'] + $all['sign_in']; ?></td>
                        <td><?php echo $all['sign_in']; ?></td>
                        <td><?php echo $all['first_pass']; ?></td>
                        <td><?php echo $all['second_pass']; ?></td>
                        <td><?php echo $all['first_no_pass']; ?></td>
                        <td><?php echo $all['second_no_pass']; ?></td>
                    </tr>
                </table>
                <table class="table">
                    <tr>
                        <th>一面未表决</th>
                        <th>二面未表决</th>
                        <th> 一面等待中</th>
                        <th> 二面等待中</th>
                    </tr>
                    <tr>
                        <td><?php echo $all['first_end']; ?></td>
                        <td><?php echo $all['second_end']; ?></td>
                        <td><?php echo $all['first_two_waiting']; ?></td>
                        <td><?php echo $all['second_waiting']; ?></td>
                    </tr>
                </table>

                <h5>安全组</h5>
                <table class="table">
                    <tr>
                        <th>报名人数</th>
                        <th>面试人数</th>
                        <th>一面通过</th>
                        <th>二面通过</th>
                        <th>一面未通过</th>
                        <th>二面未通过</th>

                    </tr>
                    <tr>
                        <td><?php echo $safe['sign_up'] + $safe['sign_in']; ?></td>
                        <td><?php echo $safe['sign_in']; ?></td>
                        <td><?php echo $safe['first_pass']; ?></td>
                        <td><?php echo $safe['second_pass']; ?></td>
                        <td><?php echo $safe['first_no_pass']; ?></td>
                        <td><?php echo $safe['second_no_pass']; ?></td>
                    </tr>
                </table>
                <table class="table">
                    <tr>
                        <th>一面未表决</th>
                        <th>二面未表决</th>
                        <th> 一面等待中</th>
                        <th> 二面等待中</th>
                    </tr>
                    <tr>
                        <td><?php echo $safe['first_end']; ?></td>
                        <td><?php echo $safe['second_end']; ?></td>
                        <td><?php echo $safe['first_two_waiting']; ?></td>
                        <td><?php echo $safe['second_waiting']; ?></td>
                    </tr>
                </table>

                <h5>WEB组</h5>
                <table class="table">
                    <tr>
                        <th>报名人数</th>
                        <th>面试人数</th>
                        <th>一面通过</th>
                        <th>二面通过</th>
                        <th>一面未通过</th>
                        <th>二面未通过</th>

                    </tr>
                    <tr>
                        <td><?php echo $web['sign_up'] + $web['sign_in']; ?></td>
                        <td><?php echo $web['sign_in']; ?></td>
                        <td><?php echo $web['first_pass']; ?></td>
                        <td><?php echo $web['second_pass']; ?></td>
                        <td><?php echo $web['first_no_pass']; ?></td>
                        <td><?php echo $web['second_no_pass']; ?></td>
                    </tr>
                </table>
                <table class="table">
                    <tr>
                        <th>一面未表决</th>
                        <th>二面未表决</th>
                        <th> 一面等待中</th>
                        <th> 二面等待中</th>
                    </tr>
                    <tr>
                        <td><?php echo $web['first_end']; ?></td>
                        <td><?php echo $web['second_end']; ?></td>
                        <td><?php echo $web['first_two_waiting']; ?></td>
                        <td><?php echo $web['second_waiting']; ?></td>
                    </tr>
                </table>


                <h5>视觉设计组</h5>
                <table class="table">
                    <tr>
                        <th>报名人数</th>
                        <th>面试人数</th>
                        <th>一面通过</th>
                        <th>二面通过</th>
                        <th>一面未通过</th>
                        <th>二面未通过</th>

                    </tr>
                    <tr>
                        <td><?php echo $art['sign_up'] + $art['sign_in']; ?></td>
                        <td><?php echo $art['sign_in']; ?></td>
                        <td><?php echo $art['first_pass']; ?></td>
                        <td><?php echo $art['second_pass']; ?></td>
                        <td><?php echo $art['first_no_pass']; ?></td>
                        <td><?php echo $art['second_no_pass']; ?></td>
                    </tr>
                </table>
                <table class="table">
                    <tr>
                        <th>一面未表决</th>
                        <th>二面未表决</th>
                        <th> 一面等待中</th>
                        <th> 二面等待中</th>
                    </tr>
                    <tr>
                        <td><?php echo $art['first_end']; ?></td>
                        <td><?php echo $art['second_end']; ?></td>
                        <td><?php echo $art['first_two_waiting']; ?></td>
                        <td><?php echo $art['second_waiting']; ?></td>
                    </tr>
                </table>
                <h5>技术运营组</h5>
                <table class="table">
                    <tr>
                        <th>报名人数</th>
                        <th>面试人数</th>
                        <th>一面通过</th>
                        <th>二面通过</th>
                        <th>一面未通过</th>
                        <th>二面未通过</th>

                    </tr>
                    <tr>
                        <td><?php echo $operator['sign_up'] + $operator['sign_in']; ?></td>
                        <td><?php echo $operator['sign_in']; ?></td>
                        <td><?php echo $operator['first_pass']; ?></td>
                        <td><?php echo $operator['second_pass']; ?></td>
                        <td><?php echo $operator['first_no_pass']; ?></td>
                        <td><?php echo $operator['second_no_pass']; ?></td>
                    </tr>

                </table>
                <table class="table">
                    <tr>
                        <th>一面未表决</th>
                        <th>二面未表决</th>
                        <th> 一面等待中</th>
                        <th> 二面等待中</th>
                    </tr>
                    <tr>
                        <td><?php echo $operator['first_end']; ?></td>
                        <td><?php echo $operator['second_end']; ?></td>
                        <td><?php echo $operator['first_two_waiting']; ?></td>
                        <td><?php echo $operator['second_waiting']; ?></td>
                    </tr>
                </table>

            </div>
        </div>
        <!--/span-->


    </div>
    <!--/row-->

    <hr>

    <footer>
        <p>© Company 2013</p>
    </footer>

</div>
<!--/.fluid-container-->


</body>
<div></div>
<div></div>
</html>
