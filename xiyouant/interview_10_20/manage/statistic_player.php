<?php
/**
 * Created by PhpStorm.
 * User: zh
 * Date: 15-10-15
 * Time: 下午7:09
以 player 为一个单位显示数据
 */
include_once('../bin/player.php');
include_once('../bin/judge.php');
include_once('../bin/Mysql.php');
include_once('../bin/base.php');
include_once('output.php');
session_start();
//$_SESSION['valid_user']="safe";
if (!isset($_SESSION['valid_user'])) {
    do_html_URL("../login/index.php", "未登陆");
    exit;
}
$judge = new judge(array("name"=>$_SESSION['valid_user']));
$judge_direction = $judge->get_direction();
$sql  = new Mysql();
if($judge_direction==DIRECTION_WEB)
{
    $art = DIRECTION_ART;
    $players = $sql->getDate("SELECT * FROM player WHERE direction='$judge_direction' OR direction=$art "); // art 组 归于 web 组
}else if($judge_direction == 0 ){
    $players = $sql->getDate("SELECT * FROM player "); // root 权限
}else{
    $players = $sql->getDate("SELECT * FROM player WHERE direction='$judge_direction'");
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
                <table class="table table-hover">
                    <tr>
                        <th>名字</th>
                        <th>学号</th>
                        <th>状态</th>
                        <th class="th_test"></th>
                    </tr>
                    <?php
                    if ($players) {
                        foreach ($players as $player) {


                                ?>
                                <tr>
                                    <td><?php echo $player['name']; ?>  </td>
                                    <td><?php echo $player['student_id']; ?> </td>
                                    <td><?php echo change_direction_to_string($player['direction']); ?> </td>
                                    <td><?php echo change_status_to_string($player['status']); ?> </td>
                                    <td><a class="btn btn-large btn-block btn-info test"
                                           href="all_info.php?<?php echo $player['id']; ?>">更多信息</a></td>
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


