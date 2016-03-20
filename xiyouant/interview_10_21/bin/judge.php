<?php

/**
 * Created by PhpStorm.
 * User: zh
 * Date: 15-10-10
 * Time: 下午11:13
 */
include_once('Mysql.php');
class judge
{
    private $id = null;
    private $name = null;
    private $password = null;
    private $direction = null;

    private $member_id = null;

    private $sql = null;





    function __construct($array)
    {
        $this->sql = new Mysql();
        if(array_key_exists("id",$array))
        {
            $id = $array['id'];
            $query = "SELECT * FROM judge WHERE id=$id";
            $ret = $this->sql->getLine($query);
        }elseif(array_key_exists('name',$array)){
            $name = $array['name'];
            $query = "SELECT * FROM judge WHERE name='$name'";
            $ret = $this->sql->getLine($query);

        }else{
            $ret = null;
        }
        if($ret)
        {
            $this->id = $ret['id'];
            $this->name = $ret['name'];
            $this->password = $ret['password'];
            $this->direction = $ret['direction'];
            $this->member_id = $ret['member_id'];
        }
    }
    // 登陆检查，匹配返回　true 失败返回　false
    function check_login($password)
    {
        if($this->name == null || $password!=$this->password )
        {
            return false;
        }else{
            return true;
        }

    }

    function  get_name()
    {
        return $this->name;
    }
    function  get_id()
    {
        return $this->id;
    }
    function get_member_id()
    {
        return $this->member_id;
    }
    function get_direction()
    {
        return $this->direction;
    }
}