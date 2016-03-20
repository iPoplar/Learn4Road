<?php
/**
 * Created by PhpStorm.
 * User: zh
 * Date: 15-10-13
 * Time: 上午1:20\
 * 获得一个选手的所有评分信息　
 */
include_once('php_code/function.php');
include_once('../bin/base.php');
include_once('../bin/player.php');
include_once('../bin/interview.php');
include_once('output.php');
session_start();

//$_SESSION['valid_user'] = 'safe';
if (!isset($_SESSION['valid_user'])) {
    do_html_URL("../login/index.php", "未登陆");
    exit;
}
//$_SERVER["QUERY_STRING"] = 26;
$player_id = $_SERVER["QUERY_STRING"];
$player = new player(array("id" => $player_id));// 获取　player 信息
$interview_first_one = get_interview_by_player_id_and_status($player->id, STATUS_FIRST_ONE_END);
$interview_first_two = get_interview_by_player_id_and_status($player->id, STATUS_FIRST_END);
$interview_second = get_interview_by_player_id_and_status($player->id, STATUS_SECOND_END);// 获取三次面试的信息


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
                <h4>个人信息</h4>
                <table class="table">
                    <tr>
                        <th>名字</th>
                        <th>方向</th>
                        <th>性别</th>
                        <th>学号</th>
                        <th>年级</th>
                        <th>班级</th>
                        <th>联系方式(电话)
                        </th>
                    </tr>
                    <tr>
                        <td><?php echo $player->name; ?></td>
                        <td><?php echo $player->student_id ?></td>
                        <td><?php echo "合并后处理" ?> </td>
                        <td><?php echo change_direction_to_string($player->direction); ?></td>
                        <td><?php echo $player->grade ?></td>
                        <td><?php echo $player->class ?></td>
                        <td><?php echo $player->tel; ?></td>
                    </tr>

                </table>
                <?php if ($interview_first_one) { ?>
                    <h4>一面一结果</h4>
                    <a class="btn  btn-large btn-info " href="manage.php?<?php echo $interview_first_one->get_interview_id()?>">修改</a>
<!--                    <a class="btn btn-large btn-block btn-info test" href="manage.php?--><?php //echo $interview->get_interview_id() ?><!--"> 管理</a>-->
                    <table class="table">

                        <tr>

                            <th>评委</th>
                            <th>面试态度</th>
                            <th>团队态度</th>
                            <th>人生态度</th>
                            <th>基础知识</th>
                            <th>方向态度</th>
                            <th>总分</th>
                        </tr>
                        <tr>
                            <td><?php echo $interview_first_one->judge->get_name(); ?></td>
                            <td><?php echo $interview_first_one->interview_attitude; ?></td>
                            <td><?php echo $interview_first_one->group_attitude; ?></td>
                            <td><?php echo $interview_first_one->life_attitude; ?></td>
                            <td><?php echo $interview_first_one->base_knowledge; ?></td>
                            <td><?php echo $interview_first_one->direction_knowledge; ?></td>
                            <td><?php echo $interview_first_one->get_score(); ?></td>
                        </tr>
                    </table>
                    <table class="table">
                        <tr>
                            <th>评价</th>
                        </tr>
                        <tr>
                            <td><?php echo $interview_first_one->comment; ?></td>
                        </tr>

                    </table>
                <?php } ?>
                <!--                一面一 信息-->
                <?php if($interview_first_two ){?>
                <h4>
                    一面二面结果
                </h4>
                    <a class="btn  btn-large btn-info " href="manage.php?<?php echo $interview_first_two->get_interview_id()?>">修改</a>
                <table class="table">

                    <tr>
                        <th>评委</th>
                        <th>面试态度</th>
                        <th>团队态度</th>
                        <th>人生态度</th>
                        <th>基础知识</th>
                        <th>方向态度</th>
                        <th>总分</th>
                    </tr>
                    <tr>
                        <td><?php echo $interview_first_two->judge->get_name(); ?> </td>
                        <td><?php echo $interview_first_two->interview_attitude; ?></td>
                        <td><?php echo $interview_first_two->group_attitude; ?></td>
                        <td><?php echo $interview_first_two->life_attitude; ?></td>
                        <td><?php echo $interview_first_two->base_knowledge; ?></td>
                        <td><?php echo $interview_first_two->direction_knowledge; ?></td>
                        <td><?php echo $interview_first_two->get_score(); ?></td>
                    </tr>
                </table>
                <table class="table">
                    <tr>
                        <th>评价</th>
                    </tr>
                    <tr>
                        <td><?php echo $interview_first_two->comment; ?></td>
                    </tr>

                </table>

                <!--                一面二信息     -->
                <?php }?>
                <?php if ($interview_second) { ?>
                    <h4>
                        二面
                    </h4>
                    <a class="btn  btn-large btn-info " href="manage.php?<?php echo $interview_second->get_interview_id()?>">修改</a>
                    <table class="table">

                        <tr>
                            <th>评委</th>
                            <th>面试态度</th>
                            <th>团队态度</th>
                            <th>人生态度</th>
                            <th>基础知识</th>
                            <th>方向态度</th>
                        </tr>
                        <tr>
                            <td><?php echo $interview_second->judge->get_name(); ?></td>
                            <td><?php echo $interview_second->interview_attitude; ?></td>
                            <td><?php echo $interview_second->group_attitude; ?></td>
                            <td><?php echo $interview_second->life_attitude; ?></td>

                            <td><?php echo $interview_second->base_knowledge; ?></td>

                            <td><?php echo $interview_second->direction_knowledge; ?></td>
                        </tr>
                        <tr>
                            <th>总分</th>
                            <td><?php echo $interview_second->get_score(); ?></td>
                        </tr>
                    </table>
                    <table class="table">
                        <tr>
                            <th>评价</th>
                        </tr>
                        <tr>
                            <td><?php echo $interview_second->comment; ?></td>
                        </tr>

                    </table>
                    <!--                    二面 信息-->
                <?php } ?>


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
