<?php
/**
 * Created by PhpStorm.
 * User: zh
 * Date: 15-10-15
 * Time: 上午2:10
 * 建立通知和获取通知
 */
include_once("Mysql.php");
function make_notice($student_id,$name,$status,$direction,$message,$judge="**")
{
    $sql = new Mysql();
    $sql->run("INSERT INTO notice (student_id,name,status,direction,message,judge) VALUES ('$student_id','$name',$status,$direction,'$message','$judge')");

}
// 获取数据库的第一条信息，并返回值
function get_notice()
{
    $sql = new Mysql();
    $ret = $sql->getLine("SELECT * FROM notice ORDER BY id ASC LIMIT 0,1");

    if($ret)
    {
        $id = $ret['id'];
        $sql->run("DELETE FROM notice WHERE id=$id");
        return $ret;
    }else{
        return null;
    }
}


function send_notice($notice)
{
    if($notice)

    {
        $return_array = array("id"=>$notice['student_id'],"name"=>$notice['name']
        ,"status"=>$notice['status'],"direction"=>$notice['direction'],"message"=>$notice['message'],
            "judge"=>$notice['judge']);
    }else{
        $return_array = array("id"=>"000000","name"=>"000"
        ,"status"=>0,"direction"=>0,"message"=>"0",
            "judge"=>"**");
    }
    $demo_json = json_encode($return_array);
    echo $demo_json;
    exit;


}

function change_interview_name_to_unusual($name)
{
    return $name;
}
