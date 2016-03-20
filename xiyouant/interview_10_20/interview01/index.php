<?php
/**
 * Created by PhpStorm.
 * User: zh
 * Date: 15-10-10
 * Time: 下午8:22
 * 面试者首页
 */

include_once('../bin/judge.php');
include_once('../bin/base.php');
include_once('output.php');
include_once('../bin/interview.php');
include_once('./php_code/function.php');

session_start();
//$_SESSION['valid_user']='safe_1';
if (!isset($_SESSION['valid_user'])) {
    do_html_URL("../login/index.php", "未登陆");
    exit;
}
$judge = new judge(array("name" => $_SESSION['valid_user']));
//$judge = new judge(array("name" => 'safe'));
$players = interview::get_same_status_interview(array(STATUS_FIRST_ONE_WAIT, STATUS_FIRST_SECOND_WAIT, STATUS_SECOND_WAIT));


?>
<!DOCTYPE html>
<!-- saved from url=(0065)http://docs.bootcss.com/bootstrap-2.3.2/docs/examples/fluid.html# -->
<html lang="en">
<?php do_html_header("面试官") ?>
<body>

<?php do_html_top_bar() ?>

<div class="container-fluid">

    <div class="row-fluid">
        　　　　　<?php do_html_sidebar() ?>
        <!--/span-->

        <div class="span9">
            <div class="hero-unit">
                <table class="table table-hover">
                    <tr>
                        <th>名字</th>
                        <th>学号</th>
                        <th>方向</th>
                        <th>状态</th>
                        <th class="th_test"></th>
                    </tr>
                    <?php
                    if ($players) {
                        foreach ($players as $interview) {


                            if ($interview->get_interview_direction() == $judge->get_direction() OR ($interview->get_interview_direction() == DIRECTION_ART AND $judge->get_direction() == DIRECTION_WEB))// 显示所有与面试官方向相同的可选面试
                            {
                                ?>
                                <tr>
                                    <td><?php echo $interview->player->name;
                                        if($interview->get_interview_status()==STATUS_FIRST_SECOND_WAIT)
                                        {
                                            $interview_first_one    = get_interview_by_player_id_and_status($interview->player->id,STATUS_FIRST_ONE_END);// 获得该 player 的一面一的信息

                                            if($interview_first_one->judge->get_id() == $judge->get_id())// 查看一面一是否同一个面试官
                                            {
                                                echo "(已面试)";
                                            }
                                        }

                                        ?>  </td>
                                    <td><?php echo $interview->player->student_id; ?> </td>
                                    <td><?php echo change_direction_to_string($interview->player->direction); ?> </td>
                                    <td><?php echo change_status_to_string($interview->get_interview_status()); ?> </td>
                                    <td><a class="btn btn-large btn-block btn-info test"
                                           href="interview.php?<?php echo $interview->get_interview_id() ?>">面试</a></td>
                                </tr>
                                <?php
                            }
                        }
                    }


                    ?>

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