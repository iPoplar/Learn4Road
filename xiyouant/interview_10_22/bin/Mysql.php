<?php

/**
 * Created by PhpStorm.
 * User: zh
 * Date: 15-10-10
 * Time: 下午8:18
 */
include_once("macro.php");
class Mysql
{
    private $host = null;
    private $port = null;
    private $name = null;
    private $password = null;
    private $ret;
    private $basename = null;
    private $sql_con;
    function __construct(){
        $this->host = HOST;
        $this->port = 3306;
        $this->name = USER;
        $this->password = PASSWORD ;
        $this->basename = DATABASE_NAME;
        $this->sql_con = mysqli_connect($this->host,$this->name,$this->password);

        if(!$this->sql_con)
        {
            die("链接远程数据库失败".mysqli_error($this->sql_con));
        }
        mysqli_select_db($this->sql_con,$this->basename);
        mysqli_set_charset($this->sql_con, "utf8");

    }
    function __destruct()
    {
        if (!empty ($this->result)) {
            $this->ret->free();
        }
        mysqli_close($this->sql_con);
    }
    // 获取一行数据,找不到返回 null
    function getLine($query)
    {
        $this->ret = mysqli_query($this->sql_con,$query);
        if(!$this->ret)
        {
            die("getLine 函数执行".$query."失败 ".mysqli_error($this->sql_con));
        }
        $count = mysqli_num_rows($this->ret);
        if(!$count)
        {
            return false;
        }
        $return_val = mysqli_fetch_assoc($this->ret);
        return $return_val;
    }

    /*
     * 运行Sql,以多维数组方式返回结果集
        成功返回数组，没有查找到返回false
    */
    function getDate($query)
    {
        $this->ret = mysqli_query($this->sql_con,$query);
        if(!$this->ret)
        {
            die("getDate 函数执行".$query."失败 ".mysqli_error($this->sql_con));
        }
        $return_array =null;
        $count = mysqli_num_rows($this->ret);
        if(!$count)
        {
            return false;
        }
        for($i=0; $i<$count; $i++)
        {
            $return_array[$i] = mysqli_fetch_assoc($this->ret);
        }
        return $return_array;

    }
    /*
  * 运行Sql,以一个元素方式返回结果
     成功返回数组，没有查找到返回false
 */
    function  getValue($query)
    {
        $this->ret = mysqli_query($this->sql_con,$query);
        if(!$this->ret)
        {
            die("getDate 函数执行".$query."失败 ".mysqli_error($this->sql_con));
        }

        $count = mysqli_num_rows($this->ret);
        if(!$count)
        {
            return false;
        }

        $return_array = mysqli_fetch_row($this->ret);

        return $return_array[0];

    }
    // 执行非查询语句, 返回值为 为影响的行数
    function run($query)
    {
        $ret = mysqli_query($this->sql_con,$query);
        if(!$ret)
        {
            die("run 函数执行".$query."失败 ".mysqli_error($this->sql_con));
        }
        $count = mysqli_affected_rows($this->sql_con);

        return $count;
    }


}
