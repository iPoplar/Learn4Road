<?php

/**
 * Created by PhpStorm.
 * User: zh
 * Date: 15-10-10
 * Time: 下午9:27
 * 选手的信息
 * 构造函数 ，如果 没有找到对应的值， 所有的变量都为 null
 */
include_once("Mysql.php");
class player
{
    public $id = null;
    public $name = null;
    public $student_id = null;
    public $grade = null;
    public $class = null;
    public $tel = null;
    public $direction = null;
    public $sex = null;


    private $sql;
    private $status = null; // 比较重要

   function __construct($array)
   {

       if( array_key_exists("name",$array) AND array_key_exists('grade',$array) ) // 节省
       {

           $this->id = $array['id'];
           $this->name = $array['name'];
           $this->student_id = $array['student_id'];
           $this->grade = $array['grade'];
           $this->class = $array['class'];
           $this->tel = $array['tel'];
           $this->direction = $array['direction'];

           $this->status = $array['status'];

           $ret = false; // 时之后的初始化语句不被调用

       }else if(array_key_exists("id",$array))
       {
           $this->sql = new Mysql();

           $id = $array['id'];
           $ret = $this->sql->getLine("SELECT * FROM player WHERE id=$id");
       }else if(array_key_exists("student_id",$array)){
           $this->sql = new Mysql();
           $student_id = $array['student_id'];
           $ret = $this->sql->getLine("SELECT * FROM player WHERE student_id='$student_id'");
       }else{
           $ret = false;
       }

       if($ret)
       {
           $this->id = $ret['id'];
           $this->name = $ret['name'];
           $this->student_id = $ret['student_id'];
           $this->grade = $ret['grade'];
           $this->class = $ret['class'];
           $this->tel = $ret['tel'];
           $this->direction = $ret['direction'];
           $this->status = $ret['status'];
       }
   }

    // change_ 开头的方法都需要调用　save 函数　
    function change_status($new_status)
    {
        $this->status = $new_status;
        $this->save();
    }
    function get_status()
    {
        return $this->status;
    }
    function  save()
    {
        if($this->sql == null )
        {
            $this->sql = new Mysql();
        } // 检查数据库链接是否被初始化
        $this->sql->run("UPDATE `player` SET `name`='$this->name',`grade`='$this->grade',
       `class`='$this->class',`tel`='$this->tel',`direction`='$this->direction',`status`=$this->status WHERE student_id = $this->student_id");
    }

    function check_ok()
    {

        if($this->name==null )
        {
            return false;
        }else if($this->get_status() == STATUS_FIRST_PASS){
            return true;
        }else if($this->get_status() == STATUS_SIGN_UP)
        {
            return true;
        }else{
            return false;
        }
    }

    // 返回具有相同的　status 的　player 对象
    static function get_same_status_player($array)
    {
        $query = "SELECT * FROM player WHERE ";
        foreach ($array as $value) {
            $query = $query . " status=$value OR ";
        }
        $query = $query . " status=0 ";// 用不存在的情况结尾

        $sql = new Mysql();
        $ret = $sql->getDate($query);
        if (!$ret) {
            return null;
        }

        $count = count($ret);
        $return_array = null;
        for ($i = 0; $i < $count; $i++) {
           //$return_array[$i] = new player(array("id"=>$ret[$i]['id']));
           $return_array[$i] = new player($ret[$i]);
        }

        return $return_array;

    }





}