<?php
/**
 * Created by PhpStorm.
 * User: zh
 * Date: 15-10-17
 * Time: 下午5:12
 * 将面试 结束 ，需要继续面试的 player
 */
include_once('../bin/interview.php');
include_once('../bin/judge.php');
include_once('../bin/base.php');
include_once('output.php');

session_start();
//$_SESSION['valid_user'] = 'safe_1';
if (!isset($_SESSION['valid_user'])) {
    do_html_URL("../login/index.php", "未登陆");
    exit;
}
$judge = new judge(array("name" => $_SESSION['valid_user']));
$judge_id = $judge->get_id();
$sql = new Mysql();
$status1 = STATUS_FIRST_END;
$status2 = STATUS_FIRST_ONE_END;
$status3 = STATUS_SECOND_END;
$interviews = $sql->getDate("SELECT interview.id AS id,name,student_id,interview_status AS status , direction FROM interview JOIN player ON interview.player_id=player.id WHERE judge_id=$judge_id  AND
                    ( interview_status!=$status1 AND interview_status!=$status2 AND interview_status!=$status3 )");

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
                    if ($interviews) {
                        foreach ($interviews as $interview) {
                            ?>
                            <tr>
                                <td><?php echo $interview['name']
                                    ?>  </td>
                                <td><?php echo $interview['student_id']; ?> </td>
                                <td><?php echo change_direction_to_string($interview['direction']); ?> </td>
                                <td><?php echo change_status_to_string($interview['status']); ?> </td>
                                <td><a class="btn btn-large btn-block btn-info test"
                                       href="interview.php?<?php echo $interview['id'] ?>">面试</a></td>
                            </tr>
                            <?php
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

