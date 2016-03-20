<?php
/**
 * Created by PhpStorm.
 * User: zh
 * Date: 15-10-17
 * Time: 下午12:44
 *
 * 给 数据库添加一个通知
 */
include_once('../bin/notice.php');

$name = "输入学生姓名";
$student_id = "输入学生 id ";
$message = "输入要通知的信息, 例如 白孟毅同学请到WEB一组面试";

make_notice($student_id,$name,STATUS_FIRST_ONE_WAIT,DIRECTION_SAFE,$message);

echo "建立通知成功";
