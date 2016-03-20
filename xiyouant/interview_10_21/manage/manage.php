<?php
/**
 * Created by PhpStorm.
 * User: zh
 * Date: 15-10-11
 * Time: 下午12:30
 * 显示该评分的信息，用来修改评分
 */
include_once('../bin/interview.php');
include_once('../bin/judge.php');
include_once('../bin/base.php');
include_once('output.php');
session_start();
if(!isset($_SESSION['valid_user']))
{
    do_html_URL("../login/index.php","未登陆");
    exit;
}
$flag = 0;
$judge = new judge(array("name"=>$_SESSION['valid_user']));

$interview_id =  $_SERVER["QUERY_STRING"];
$interview = new interview($interview_id);

$_SESSION['interview_id'] = $interview->get_interview_id();
?>

<!DOCTYPE html>
<!-- saved from url=(0065)http://docs.bootcss.com/bootstrap-2.3.2/docs/examples/fluid.html# -->
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title><?php echo $title ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="http://apps.bdimg.com/libs/bootstrap/2.3.2/css/bootstrap.css" rel="stylesheet">
    <link href="http://apps.bdimg.com/libs/bootstrap/2.3.2/css/bootstrap-responsive.css" rel="stylesheet">
    <link href="http://apps.bdimg.com/libs/bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet">

    <script src="http://apps.bdimg.com/libs/jquery/2.0.0/jquery.min.js"></script>
    <script src="http://apps.bdimg.com/libs/bootstrap/3.0.3/js/bootstrap.min.js"></script>
    <script src="http://apps.bdimg.com/libs/jquery/2.0.0/jquery.min.js"></script>
    <style type="text/css">

        body { padding-top: 60px; padding-bottom: 40px; }
        .sidebar-nav { padding: 9px 0; }
        @media (max-width: 980px) {
            /* Enable use of floated navbar text */
            .navbar-text.pull-right {
                float: none;
                padding-left: 5px;
                padding-right: 5px;
            }
        }
        .test { width: 120px;  height: inherit;}
        .th_test {  width: 120px; height: inherit;  }
        #COMMENT{ resize: none; }
        .mybtn{margin:10px 10px;}
        .rule{margin: 50px 10px 10px 10px; padding-top:50px; padding-bottom:20px;border-top: 3px double #e1e1e1;}
        #back{color:#7F7777; font-size:1.5em; opacity: 0.8; text-decoration: none; margin-bottom: 10px; }


    </style>

</head>
<body>

<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container-fluid">
            <a class="brand" href="index.php"> 网科协面试系统-管理员</a>
            <!--/.nav-collapse -->
        </div>
    </div>

</div>

<div class="container">
    <div class="row">
        <div class="col-md-3">
           <?php do_html_sidebar() ?>
            <!--/.well -->
        </div>
        <!--/span-->
        <div class="col-md-9  well">
            <form class="form-group" name="marksheet" role="form" id="Form1" action="./php_code/get_score.php" method="post" enctype="multipart/form-data" onSubmit="return InputCheck(this)">
                <fieldset>
                    <legend>面试评分</legend>
                    <div class="form-group" id="numcheck">
                        <label class="col-sm-2 control-label" for="ATT_1" >面试态度：</label>
                        <div class="col-sm-4">
                            <input class="form-control input-lg " id="ATT_1" type="text" placeholder="请输入0-10分" value="<?php echo $interview->interview_attitude;?>" name="att1" />
                        </div>
                        <label class="col-sm-2 control-label" for="ATT_2">团队态度：</label>
                        <div class="col-sm-4">
                            <input class="form-control" id="ATT_2" type="text" placeholder="请输入0-10分" value="<?php echo $interview->group_attitude;?>" name="att2"/>
                        </div>
                        <label class="col-sm-2 control-label" for="ATT_3">人生态度：</label>
                        <div class="col-sm-4">
                            <input class="form-control" id="ATT_3" type="text" placeholder="请输入0-10分" value="<?php echo $interview->life_attitude; ?>" name="att3"/>
                        </div>
                        <label class="col-sm-2 control-label" for="KNOW_1">基础知识：</label>
                        <div class="col-sm-4">
                            <input class="form-control" id="KNOW_1" type="text" placeholder="请输入0-10分" value="<?php echo $interview->base_knowledge; ?>"  name="know1"/>
                        </div>
                        <label class="col-sm-2 control-label" for="KNOW_2">方向知识：</label>
                        <div class="col-sm-4">
                            <input class="form-control" id="KNOW_2" type="text" placeholder="请输入0-10分" value="<?php echo $interview->direction_knowledge; ?>" name="know2" />
                        </div>
                    </div>
                </fieldset>
                <hr>
                <fieldset>
                    <legend>评价：</legend>
                    <textarea class="form-control" rows="5" id="COMMENT"  name="comment" ><?php echo $interview->comment;?></textarea>
                    <!-- <input class="form-control" id="COMMENT" type="textarea" rows="3" placeholder="请输入对被面试者的评价"/> -->
                </fieldset>
                <input type="submit" class="btn btn-info mybtn"  value="修改">

                <a href="#showRule">点击查看评分规则</a>
            </form>

        </div>
        <!-- end of right part -->
    </div>
    <!--/row-->
    <h1></h1>
    <div class="col-md-12  rule">
        <a name="showRule">
            <img src="pic.png" width="70%" height="70%">
        </a>

    </div>
    <!-- end of container -->

    <a href="#marksheet" id="back">返回评分表</a>
    <hr>
    <hr>
    <footer>
        <p>© Company 2013</p>
    </footer>

</div>
<!--/.fluid-container-->


<script type="text/javascript">

    /*表单验证*/
    function InputCheck(marksheet)
    {
        if (marksheet.att1.value == "")
        {
            alert("面试态度分数未录入!");
            marksheet.att1.value.focus();
            return (false);
        }
        if (marksheet.att2.value == "")
        {
            alert("团队态度分数未录入!");
            marksheet.att2.value.focus();
            return (false);
        }
        if (marksheet.att3.value == "")
        {
            alert("人生态度分数未录入!");
            marksheet.att3.value.focus();
            return (false);
        }
        if (marksheet.know1.value == "")
        {
            alert("基础知识分数未录入!");
            marksheet.know1.value.focus();
            return (false);
        }
        if (marksheet.know2.value == "")
        {
            alert("方向知识分数未录入!");
            marksheet.know2.value.focus();
            return (false);
        }
        if (marksheet.group1.value > 10 || marksheet.group1.value < 0)
        {
            alert("请输入0-10分");
            RegForm.password.focus();
            return (false);
        }

        var oInput = document.getElementById("numcheck").getElementsByTagName('input');
        for ( var i = 0 ; i < oInput.length;i++ )
        {
            if (parseFloat(oInput[i].value) < 0 || parseFloat(oInput[i].value) > 10) {
                alert("输入为非法值，请输入0-10分");
            };
        }
    }


</script>



</body>
<div></div>
<div></div>
</html>
