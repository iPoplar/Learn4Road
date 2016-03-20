<?php
/**
 * Created by PhpStorm.
 * User: zh
 * Date: 15-10-11
 * Time: 上午10:39
 */
include_once('../bin/judge.php');
$user_name = $_POST['name'];
$password = $_POST['password'];

$judge = new judge(array("name"=>$user_name));
$ret = $judge->check_login($password);
if($ret)
{
    session_start();
    $_SESSION['valid_user']=$user_name;

    if($judge->get_member_id()==0)
    {
        ?>
        <html>
        <head>
            <script>location.href='../manage';</script>
        </head>
        </html>
        <?php
        exit;

    }else{
        ?>
        <html>
        <head>
            <script>location.href='../interview';</script>
        </head>
        </html>
        <?php
        exit;
    }


}else{
    ?>
    <html>
    <head>
        <script>location.href='index.php';</script>
    </head>
    </html>
    <?php

}