<?php
/**
 * Created by PhpStorm.
 * User: zh
 * Date: 15-10-12
 * Time: 下午6:00
 * 面试结束，但还未表决的
 */

include_once('../bin/judge.php');
include_once('../bin/base.php');
include_once('output.php');
include_once('../bin/interview.php');
include_once('./php_code/function.php');

session_start();
//$_SESSION['valid_user']="safe";
if (!isset($_SESSION['valid_user'])) {
    do_html_URL("../login/index.php", "未登陆");
    exit;
}
$judge = new judge(array("name" => $_SESSION['valid_user']));
//$judge = new judge(array("name" => 'safe'));
$interviews = interview::get_same_status_interview(array(STATUS_FIRST_END));//一面结束

$interviews_second =  interview::get_same_status_interview(array(STATUS_SECOND_END)); // 二面结束
usort($interviews,function($a,$b)
{
    if($a->get_score()==$b->get_score())
        return 0;
    return $a->get_score()>$b->get_score()?-1:1;
});// 根据 一面二 成绩排序
usort($interviews_second,function($a,$b)
{
    if($a->get_score()==$b->get_score())
        return 0;
    return $a->get_score()>$b->get_score()?-1:1;
}); // 根据 二面成绩排序
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
                <ul id="myTab" class="nav nav-tabs">
                    <li class="active">
                        <a href="#first" data-toggle="tab">一面
                        </a>
                    </li>
                    <li><a href="#second" data-toggle="tab">二面</a></li>
                </ul>

                <div class="tab-pane fade in active" id="first">

                    <table class="table table-hover" id="table_first">
                        <tr>
                            <th>名字</th>
                            <th>学号</th>
                            <th>方向</th>
                            <th>状态</th>
                            <th>一面均分</th>
                            <th class="th_test">更多信息</th>
                            <th>表决</th>
                        </tr>
                        <?php
                        if ($interviews) {
                            foreach ($interviews as $interview) {


                                if (($interview->get_interview_direction() == $judge->get_direction() OR // 显示所有与面试官方向相同的可选面试
                                        ($interview->get_interview_direction() == DIRECTION_ART AND $judge->get_direction() == DIRECTION_WEB) OR // ART 归属于　WEB 组
                                        ($judge->get_direction() == 0)) AND //root 权限
                                    ($interview->player->get_status() <=8 )// 用户状态还是未被表决
                                ) {

                                    ?>
                                    <tr>
                                        <td>
                                            <?php echo $interview->player->name;  ?>
                                        </td>
                                        <td>
                                            <?php echo $interview->player->student_id; ?>
                                        </td>
                                        <td>
                                            <?php echo change_direction_to_string($interview->player->direction); ?>
                                        </td>
                                        <td>
                                            <?php echo change_status_to_string($interview->get_interview_status()); ?>
                                        </td>
                                        <td>
                                            <?php
                                            $first_one_interview = get_interview_by_player_id_and_status($interview->get_player_id(),STATUS_FIRST_ONE_END);
                                            $score1 = $first_one_interview->get_score(); //获取一面一的分数
                                            $score2 = $interview->get_score(); // 获取一面二的分数

                                            echo ($score1+$score2)/2; ?>
                                        </td>
                                        <td><a class="btn btn-large btn-block btn-info test"
                                               href="all_info.php?<?php echo $interview->player->id; ?>">更多信息</a></td>
                                        <td>
                                            <form name="<?php echo $interview->get_interview_id() ?>" action="#"
                                                  method="post">
                                                <label>暂定：
                                                    <input type="radio" name="status" value="wait" checked="checked">
                                                </label>
                                                <label>通过：
                                                    <input type="radio" name="status" value="pass">
                                                </label>
                                                <label>不通过：
                                                    <input type="radio" name="status" value="no_pass">
                                                </label>
                                            </form>

                                        </td>
                                        <td hidden>
                                            <?php echo  $interview->get_interview_id() ?>
                                        </td>

                                    </tr>
                                    <?php
                                }
                            }
                        }


                        ?>


                    </table>
                    <button class="btn btn-primary" id="PostStatusBtn">确认</button>

                </div>

                <div class="tab-pane fade " id="second">
                    <table class="table table-hover" id="table_second">
                        <tr>
                            <th>名字</th>
                            <th>学号</th>
                            <th>方向</th>
                            <th>状态</th>
                            <th>二面分数</th>
                            <th class="th_test">更多信息</th>
                            <th>表决</th>
                        </tr>
                        <?php
                        if ($interviews_second) {
                            foreach ($interviews_second as $interview) {


                                if (($interview->get_interview_direction() == $judge->get_direction() OR // 显示所有与面试官方向相同的可选面试
                                        ($interview->get_interview_direction() == DIRECTION_ART AND $judge->get_direction() == DIRECTION_WEB) OR // ART 归属于　WEB 组
                                        ($judge->get_direction() == 0)) AND //root 权限
                                    $interview->player->get_status() == STATUS_SECOND_END // 用户状态还是未被表决
                                ) {
                                    ?>
                                    <tr>
                                        <td>
                                            <?php echo $interview->player->name; ?>
                                        </td>
                                        <td>
                                            <?php echo $interview->player->student_id; ?>
                                        </td>
                                        <td>
                                            <?php echo change_direction_to_string($interview->player->direction); ?>
                                        </td>
                                        <td>
                                            <?php echo change_direction_to_string($interview->get_interview_status()); ?>
                                        </td>
                                        <td>
                                            <?php echo $interview->get_score(); ?>
                                        </td>
                                        <td><a class="btn btn-large btn-block btn-info test"
                                               href="all_info.php?<?php $interview->player->id ?>">更多信息</a></td>
                                        <td>
                                            <form name="<?php echo $interview->get_interview_id() ?>" action="#"
                                                  method="post">
                                                <label>暂定：
                                                    <input type="radio" name="status" value="wait" checked="checked">
                                                </label>
                                                <label>通过：
                                                    <input type="radio" name="status" value="pass">
                                                </label>
                                                <label>不通过：
                                                    <input type="radio" name="status" value="no_pass">
                                                </label>
                                            </form>

                                        </td>
                                        <td hidden>
                                            <?php echo  $interview->get_interview_id() ?>
                                        </td>

                                    </tr>
                                    <?php
                                }
                            }
                        }


                        ?>


                    </table>
                    <button class="btn btn-primary" id="PostStatusBtn2">确认</button>

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
<script>
    $(function () {
        $('#PostStatusBtn').click(function () {
            var resault = [];
            var a = $('#table_first tr').length;
            for (var i = 1; i < a; i++) {
                var value = {};
                $('#table_first tr:eq(' + i + ')').find("td").each(function (i) {

                    if (i == 6) {
                       // value['interview_id'] = $.trim($(this).attr("name"));
                        value['choose'] = $(this).find("input:checked").val();
                    }else if(i==7)
                    {
                        value['interview_id'] = $.trim($(this).text());
                    }


                })
                resault.push(value);
            }

            // alert(JSON.stringify(resault));
            //alert(resault[0].interview_id);
            $.ajax({
                type: "post",
                url: "./php_code/make_choice.php",
                data: {
                    num: a-1,
                    result: resault
                },
                dataType: "json",

                success: function (json) {
                  //  alert(json.test);
                    alert("更改成功");
                },
                error: function () {
                    alert('请求错误');
                }
            });

            document.location.reload(); // 页面刷新

        });
    })
    $(function () {
        $('#PostStatusBtn2').click(function () {
            var resault = [];
            var a = $('#table_second tr').length;
            for (var i = 1; i < a; i++) {
                var value = {};
                $('#table_second tr:eq(' + i + ')').find("td").each(function (i) {

                    if (i == 6) {
                        // value['interview_id'] = $.trim($(this).attr("name"));
                        value['choose'] = $(this).find("input:checked").val();
                    }else if(i==7)
                    {
                        value['interview_id'] = $.trim($(this).text());
                    }


                })
                resault.push(value);
            }

            // alert(JSON.stringify(resault));
            //alert(resault[0].interview_id);
            $.ajax({
                type: "post",
                url: "./php_code/make_choice.php",
                data: {
                    num: a-1,
                    result: resault
                },
                dataType: "json",

                success: function (json) {
                      alert(json.test);
                    alert("更改成功");
                },
                error: function () {
                    alert('请求错误');
                }
            });

            document.location.reload();// 页面刷新

        });
    })


</script>
<div></div>
<div></div>

</html>