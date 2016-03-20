<?php
/**
 * Created by PhpStorm.
 * User: zh
 * Date: 15-9-19
 * Time: 上午10:55
 */



function do_html_header($title) {
    // print an HTML header
    ?>
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
    <?php
}
function do_html_top_bar()
{
?>
    <div class="navbar navbar-inverse navbar-fixed-top">
        <div class="navbar-inner">
            <div class="container-fluid">

                <a class="brand">网络科技协会面试系统-面试官</a>

            </div>
        </div>
    </div>
    <?php

}

function do_html_sidebar()
{
    ?>
    <div class="span3">
        <div class="well sidebar-nav">
            <ul class="nav nav-pills nav-stacked">

                    <li><a href="./index.php"><h5>面试</h5></a></li>
                    <li><a href="./interview_ing.php"><h5>面试未结束</h5></a></li>
                    <li><a href="./show_player.php"><h5>管理</h5></a></li>
                    <li><a href="./php_code/exit.php"><h5>退出</h5></a> </li>

            </ul>

        </div>
        <!--/.well -->
    </div>

    <?php
}

function do_html_URL($url, $name) {
    // output URL as link and br
    ?>
    <br /><a href="<?php echo $url;?>"><?php echo $name;?></a><br />
    <?php
}


?>