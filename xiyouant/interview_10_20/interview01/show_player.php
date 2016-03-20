<?php
/**
 * Created by PhpStorm.
 * User: zh
 * Date: 15-10-12
 * Time: 下午4:05
 */
include_once('../bin/interview.php');
include_once('../bin/judge.php');
include_once('../bin/base.php');
include_once('output.php');

session_start();
//$_SESSION['valid_user']='safe_1';
if (!isset($_SESSION['valid_user'])) {
    do_html_URL("../login/index.php", "未登陆");
    exit;
}
$interviews = interview::get_same_status_interview(array(STATUS_FIRST_ONE_END, STATUS_FIRST_END, STATUS_SECOND_END));
$judge = new judge(array("name" => $_SESSION['valid_user']));
//print_r($judge);
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
                        <th>总分</th>
                        <th>选择</th>
                    </tr>
                    <?php
                    if ($interviews) {
                        foreach ($interviews as $interview) {

                            if ($interview->judge->get_id() == $judge->get_id())// 显示所有与面试官方向相同的可选面试
                            {
                                ?>
                                <tr>
                                    <td><?php echo $interview->player->name; ?>  </td>
                                    <td><?php echo $interview->player->student_id; ?> </td>
                                    <td><?php echo change_direction_to_string($interview->player->direction); ?> </td>
                                    <td><?php echo change_status_to_string($interview->get_interview_status()); ?> </td>
                                    <td><?php echo $interview->get_score(); ?> </td>
                                    <td><a class="btn  btn-info"
                                           href="manage.php?<?php echo $interview->get_interview_id()?>">管理</a></td>

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
