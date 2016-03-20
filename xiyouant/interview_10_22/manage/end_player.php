<?php
/**
 * Created by PhpStorm.
 * User: zh
 * Date: 15-10-12
 * Time: 下午6:01
 * 显示面试结果
 */


include_once('../bin/judge.php');
include_once('../bin/base.php');
include_once('output.php');
include_once('../bin/player.php');
include_once('../bin/interview.php');
include_once('php_code/function.php');


session_start();
//$_SESSION['valid_user']="safe";
if (!isset($_SESSION['valid_user'])) {
    do_html_URL("../login/index.php", "未登陆");
    exit;
}
$judge = new judge(array("name" => $_SESSION['valid_user']));
//$judge = new judge(array("name" => 'safe'));
$players_first_pass = player::get_same_status_player(array(STATUS_FIRST_PASS, STATUS_SECOND_WAIT,STATUS_SECOND_ING,STATUS_SECOND_END, STATUS_SECOND_PASS, STATUS_SECOND_NO_PASS));
$players_second_pass = player::get_same_status_player(array(STATUS_SECOND_PASS));
$players_second_no_pass = player::get_same_status_player(array(STATUS_SECOND_NO_PASS));
$players_first_no_pass = player::get_same_status_player(array(STATUS_FIRST_NO_PASS));

?>

<!DOCTYPE html>
<!-- saved from url=(0065)http://docs.bootcss.com/bootstrap-2.3.2/docs/examples/fluid.html# -->
<html lang="en" xmlns="http://www.w3.org/1999/html">
<?php do_html_header("面试官") ?>
<body>

<?php do_html_top_bar() ?>

<div class="container-fluid">

    <div class="row-fluid">
        　　　　　<?php do_html_sidebar() ?>
        <!--/span-->

        <div class="span9">
            <div class="hero-unit">

                <ul id="myTab" class="nav nav-tabs">
                    <li class="active">
                        <a href="#first_pass" data-toggle="tab">一面通过
                        </a>
                    </li>
                    <li><a href="#second_pass" data-toggle="tab">二面通过</a></li>
                    <li><a href="#first_no_pass" data-toggle="tab">一面未通过</a></li>
                    <li><a href="#second_no_pass" data-toggle="tab">二面未通过</a></li>


                </ul>
                <div id="myTabContent" class="tab-content">
                    <div class="tab-pane fade in active" id="first_pass">
                        <table class="table table-hover">
                            <tr>
                                <th>名字</th>
                                <th>学号</th>
                                <th>方向</th>
                                <th>一面一</th>
                                <th>一面二</th>
                                <th>所有信息</th>
                            </tr>

                            <?php

                            if ($players_first_pass) {
                                foreach ($players_first_pass as $player) {


                                    if (($player->direction == $judge->get_direction() //方向对的
                                            OR ($player->direction == DIRECTION_ART AND $judge->get_direction() == DIRECTION_WEB)// art 组归到　web 组
                                            OR $judge->get_direction() == 0) // root权限
                                       //AND ($player->get_status() > STATUS_FIRST_END AND $player->get_status()!= STATUS_FIRST_NO_PASS  ) // 通过一面
                                    ) {
                                        $interview_first_one = get_interview_by_player_id_and_status($player->id, STATUS_FIRST_ONE_END);
                                        $interview_first_two = get_interview_by_player_id_and_status($player->id, STATUS_FIRST_END);
                                        ?>
                                        <tr>
                                            <td><?php echo $player->name; ?></td>
                                            <td><?php echo $player->student_id; ?></td>
                                            <td><?php echo change_direction_to_string($player->direction); ?> </td>
                                            <td><?php echo $interview_first_one->get_score() ?></td>
                                            <td><?php echo $interview_first_two->get_score() ?></td>
                                            <td><a class="btn btn-large btn-block btn-info test"
                                                   href="all_info.php?<?php echo $player->id; ?>">更多信息</a></td>
                                        </tr>
                                        <?php


                                    }

                                }
                            }

                            ?>
                        </table>
                    </div>

                    <div class="tab-pane fade" id="second_pass">
                        <table class="table table-hover">
                            <tr>
                                <th>名字</th>
                                <th>学号</th>
                                <th>方向</th>
                                <th>一面一分数</th>
                                <th>一面二分数</th>
                                <th>二面分数</th>
                                <th>所有信息</th>
                            </tr>
                            <?php

                            if($players_second_pass) {

                                foreach ($players_second_pass as $player) {

                                    if (($player->direction == $judge->get_direction() //方向对的
                                            OR ($player->direction == DIRECTION_ART AND $judge->get_direction() == DIRECTION_WEB)// art 组归到　web 组
                                            OR $judge->get_direction() == 0) // root权限
                                        //AND $player->get_status() == STATUS_SECOND_PASS
                                    ) {
                                        $interview_first_one = get_interview_by_player_id_and_status($player->id, STATUS_FIRST_ONE_END);
                                        $interview_first_two = get_interview_by_player_id_and_status($player->id, STATUS_FIRST_END);
                                        $interview_two = get_interview_by_player_id_and_status($player->id, STATUS_SECOND_END);
                                        ?>
                                        <tr>
                                            <td><?php echo $player->name; ?></td>
                                            <td><?php echo $player->student_id; ?></td>
                                            <td><?php echo change_direction_to_string($player->direction); ?> </td>
                                            <td><?php echo $interview_first_one->get_score() ?></td>
                                            <td><?php echo $interview_first_two->get_score() ?></td>
                                            <td><?php echo $interview_two->get_score() ?></td>
                                            <td><a class="btn btn-large btn-block btn-info test"
                                                   href="all_info.php?<?php echo $player->id; ?>">更多信息</a></td>
                                        </tr>

                                        <?php
                                    }
                                }
                            }

                            ?>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="first_no_pass">
                        <table class="table table-hover">
                            <tr>
                                <th>名字</th>
                                <th>学号</th>
                                <th>方向</th>
                                <th>一面一</th>
                                <th>一面二</th>
                                <th>所有信息</th>
                            </tr>
                            <?php

                            if($players_first_no_pass)
                            {
                                foreach ($players_first_no_pass as $player) {


                                    if (($player->direction == $judge->get_direction() //方向对的
                                            OR ($player->direction == DIRECTION_ART AND $judge->get_direction() == DIRECTION_WEB)// art 组归到　web 组
                                            OR $judge->get_direction() == 0) // root权限
                                       // AND $player->get_status() == STATUS_FIRST_NO_PASS
                                    ) {
                                        $interview_first_one = get_interview_by_player_id_and_status($player->id, STATUS_FIRST_ONE_END);
                                        $interview_first_two = get_interview_by_player_id_and_status($player->id, STATUS_FIRST_END);
                                        ?>
                                        <tr>
                                            <td><?php echo $player->name; ?></td>
                                            <td><?php echo $player->student_id; ?></td>
                                            <td><?php echo change_direction_to_string($player->direction); ?> </td>
                                            <td><?php echo $interview_first_one->get_score() ?></td>
                                            <td><?php echo $interview_first_two->get_score() ?></td>
                                            <td><a class="btn btn-large btn-block btn-info test"
                                                   href="all_info.php?<?php echo $player->id; ?>">更多信息</a></td>
                                        </tr>
                                        <?php
                                    }
                                }
                            }

                             ?>
                        </table>
                    </div>

                    <div class="tab-pane fade" id="second_no_pass">
                        <table class="table table-hover">
                            <tr>
                                <th>名字</th>
                                <th>学号</th>
                                <th>方向</th>
                                <th>一面一分数</th>
                                <th>一面二分数</th>
                                <th>二面分数</th>
                                <th>所有信息</th>
                            </tr>

                            <?php

                            if($players_second_no_pass) {

                                foreach ($players_second_no_pass as $player) {

                                    if (($player->direction == $judge->get_direction() //方向对的
                                            OR ($player->direction == DIRECTION_ART AND $judge->get_direction() == DIRECTION_WEB)// art 组归到　web 组
                                            OR $judge->get_direction() == 0) // root权限
                                        //AND $player->get_status() == STATUS_SECOND_NO_PASS
                                    ) {
                                        $interview_first_one = get_interview_by_player_id_and_status($player->id, STATUS_FIRST_ONE_END);
                                        $interview_first_two = get_interview_by_player_id_and_status($player->id, STATUS_FIRST_END);
                                        $interview_two = get_interview_by_player_id_and_status($player->id, STATUS_SECOND_END);
                                        ?>
                                        <tr>
                                            <td><?php echo $player->name; ?></td>
                                            <td><?php echo $player->student_id; ?></td>
                                            <td><?php echo change_direction_to_string($player->direction); ?> </td>
                                            <td><?php echo $interview_first_one->get_score() ?></td>
                                            <td><?php echo $interview_first_two->get_score() ?></td>
                                            <td><?php echo $interview_two->get_score() ?></td>
                                            <td><a class="btn btn-large btn-block btn-info test"
                                                   href="all_info.php?<?php echo $player->id; ?>">更多信息</a></td>
                                        </tr>

                                        <?php
                                    }
                                }
                            }
                            ?>
                        </table>
                    </div>

                </div>


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


