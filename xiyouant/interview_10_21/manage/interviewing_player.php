<?php
/**
 * Created by PhpStorm.
 * User: zh
 * Date: 15-10-12
 * Time: 下午6:00
 *　显示正在面试中的
 */
include_once('../bin/judge.php');
include_once('../bin/base.php');
include_once('output.php');
include_once('../bin/interview.php');

session_start();

if (!isset($_SESSION['valid_user'])) {
    do_html_URL("../login/index.php", "未登陆");
    exit;
}
$judge = new judge(array("name" => $_SESSION['valid_user']));

$interviews = interview::get_same_status_interview(array(STATUS_FIRST_ONE_ING, STATUS_FIRST_SECOND_ING, STATUS_SECOND_ING));//获取所有正在面试中的人员

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
                <table class="table table-hover">
                    <tr>
                        <th>名字</th>
                        <th>学号</th>
                        <th>方向</th>
                        <th>状态</th>
                        <th>评委</th>
                    </tr>


                    <?php
                    if ($interviews) {
                        foreach ($interviews as $interview) {


                            if ($interview->get_interview_direction() == $judge->get_direction() OR // 显示所有与面试官方向相同的可选面试
                                ($interview->get_interview_direction() == DIRECTION_ART AND $judge->get_direction() == DIRECTION_WEB) OR // ART 归属于　WEB 组
                                ($judge->get_direction() == 0) //root 权限
                            ) {
                                ?>
                                <tr>
                                    <td><?php echo $interview->player->name; ?>  </td>
                                    <td><?php echo $interview->player->student_id; ?> </td>
                                    <td><?php echo change_direction_to_string($interview->player->direction); ?> </td>
                                    <td><?php echo change_status_to_string($interview->get_interview_status()); ?> </td>
                                    <td><?php echo $interview->judge->get_name(); ?> </td>


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
