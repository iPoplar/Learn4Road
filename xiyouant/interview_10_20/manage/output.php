<?php
/**
 * Created by PhpStorm.
 * User: zh
 * Date: 15-9-19
 * Time: 上午10:55
 *
 */


function do_html_header($title)
{
    // print an HTML header
    ?>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta charset="utf-8">
        <title><?php echo $title ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="http://apps.bdimg.com/libs/bootstrap/2.3.2/css/bootstrap.css" rel="stylesheet">
        <link href="http://apps.bdimg.com/libs/bootstrap/2.3.2/css/bootstrap-responsive.css" rel="stylesheet">

        <script src="http://apps.bdimg.com/libs/jquery/2.0.0/jquery.min.js"></script>
        <script src="http://apps.bdimg.com/libs/bootstrap/3.0.3/js/bootstrap.min.js"></script>
        <script src="http://apps.bdimg.com/libs/jquery/2.0.0/jquery.min.js"></script>
        <link href="./css/flat-ui.min.css" rel="stylesheet">

        <style type="text/css">
            body {
                padding-top: 60px;
                padding-bottom: 40px;
            }

            .sidebar-nav {
                padding: 9px 0;
            }

            @media (max-width: 980px) {
                /* Enable use of floated navbar text */
                .navbar-text.pull-right {
                    float: none;
                    padding-left: 5px;
                    padding-right: 5px;
                }
            }

            .test {
                width: 120px;
                height: inherit;
            }

            .th_test {
                width: 120px;
                height: inherit;
            }

        </style>

    </head>
    <?php
}

function do_html_top_bar()
{
    ?>
    <div class="navbar navbar-inverse navbar-fixed-top">
        <div class="navbar-inner">
            <div class="container-fluid">

                <a class="brand" href="index.php">网络科技协会面试系统-管理员</a>

            </div>
        </div>
    </div>
    <?php

}

function do_html_sidebar()
{
    ?>
    <div class="span3">
        <div class="well ">
            <ul class="nav nav-pills nav-stacked">

                <li><a href="./index.php">统计</a></li>
                <li><a href="./interviewing_player.php">正在面试</a></li>
                <li><a href="./statistic_player.php">小鲜肉</a></li>
                <li><a href="./pass_or_no_pass.php">面试未决</a></li>
                <li><a href="./end_player.php">面试结果</a></li>
                <li><a href="./all_interview.php">所有面试记录</a></li>
                <li><a href="./php_code/exit.php">退出</a></li>

            </ul>

        </div>
        <!--/.well -->
    </div>

    <?php
}

function do_html_URL($url, $name)
{
    // output URL as link and br
    ?>
    <br/><a href="<?php echo $url; ?>"><?php echo $name; ?></a><br/>
    <?php
}


?>
