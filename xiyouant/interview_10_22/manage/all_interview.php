<?php
/**
 * Created by PhpStorm.
 * User: zh
 * Date: 15-10-17
 * Time: 上午2:05
 * 优化数据库读取
 */

include_once('../bin/judge.php');
include_once('../bin/base.php');
include_once('output.php');
include_once('../bin/interview.php');
include_once('../bin/Mysql.php');

session_start();
//$_SESSION['valid_user'] = 'safe';
if (!isset($_SESSION['valid_user'])) {
    do_html_URL("../login/index.php", "未登陆");
    exit;
}
$judge = new judge(array("name" => $_SESSION['valid_user']));

$query = "SELECT interview.id AS id ,name, interview.interview_status  AS status
         , student_id , player.direction AS direction FROM interview JOIN player ON interview.player_id=player.id  ";
switch ($judge->get_direction()) {
    case DIRECTION_OPERATE:
        $direction = DIRECTION_OPERATE;
        $query = $query . " WHERE player.direction=$direction  ORDER BY interview.id ASC";
        break;
    case DIRECTION_SAFE:
        $direction = DIRECTION_SAFE;
        $query = $query . " WHERE player.direction=$direction  ORDER BY interview.id ASC";
        break;
    case DIRECTION_ART:
        $direction = DIRECTION_ART;
        $query = $query . "WHERE player.direction=$direction  ORDER BY interview.id ASC";
        break;
    case DIRECTION_WEB: // 处理 web 和 art 两组情况
        $direction = DIRECTION_WEB;
        $direction2 = DIRECTION_ART;
        $query = $query . " WHERE player.direction=$direction OR player.direction=$direction2  ORDER BY interview.id ASC";
        break;
    default;

        $query = $query."  ORDER BY interview.id ASC";
        break;
}
$mysql = new Mysql();
$date = $mysql->getDate($query);
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

                        <th class="th_test"></th>
                    </tr>
                    <?php
                    if ($date) {
                        foreach ($date as $row) {
                            ?>
                            <tr>
                                <td><?php echo $row['name']; ?>  </td>
                                <td><?php echo $row['student_id']; ?> </td>
                                <td><?php echo change_direction_to_string($row['direction']); ?> </td>
                                <td><?php echo change_status_to_string($row['status']); ?> </td>
                                <td><a class="btn btn-large btn-block btn-info test"
                                       href="manage.php?<?php echo $row['id'] ?>">管理</a></td>
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
