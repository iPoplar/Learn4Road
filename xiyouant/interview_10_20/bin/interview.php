<?php

/**
 * Created by PhpStorm.
 * User: zh
 * Date: 15-10-10
 * Time: 下午10:17
 *  面试类　或者说是任务类
 */
include_once('Mysql.php');
include_once('macro.php');
include_once('player.php');
include_once('judge.php');

class interview
{
    private $id=null;
    private $player_id=null;
    private $judge_id=null;


    public $interview_attitude = null;
    public $group_attitude = null;
    public $life_attitude = null;
    public $base_knowledge = null;
    public $direction_knowledge = null;
    public $comment = null;

    public $player;
    public $judge;

    private $interview_status = null;
    private $score = null;
    private $flag = null;

    private $sql = null;

    function __construct($id)
    {
        if(is_array($id))
        {
            $row = $id; // 转化一下，代码重用
            $this->id = $row['id'];
            $this->interview_attitude = $row['interview_attitude'];
            $this->group_attitude = $row['group_attitude'];
            $this->life_attitude = $row['life_attitude'];
            $this->base_knowledge = $row['base_knowledge'];
            $this->direction_knowledge = $row['direction_knowledge'];
            $this->player_id = $row['player_id'];
            $this->comment = $row['comment'];

            $this->judge_id = $row['judge_id'];

            $this->interview_status = $row['interview_status'];
            $this->score = $row['score'];
            $this->flag = $row['flag'];


            $row['id'] = $row['player_id'];// 将 id 改 为 player_id 为 player 的初始化提供条件
            $this->player = new player($row);

          // $this->player = new player(array("id"=>$row['player_id']));

            if($this->judge_id)
            {
                $this->judge = new judge(array("id"=>$this->judge_id));
                //print_r($this->judge);
            }// 在不为　0  的进行

        }else{
            $this->sql = new Mysql();
            $row = $this->sql->getLine("SELECT * FROM interview WHERE id=$id");
            if ($row) {
                $this->id = $id;
                $this->interview_attitude = $row['interview_attitude'];
                $this->group_attitude = $row['group_attitude'];
                $this->life_attitude = $row['life_attitude'];
                $this->base_knowledge = $row['base_knowledge'];
                $this->direction_knowledge = $row['direction_knowledge'];
                $this->player_id = $row['player_id'];
                $this->comment = $row['comment'];

                $this->judge_id = $row['judge_id'];

                $this->interview_status = $row['interview_status'];
                $this->score = $row['score'];
                $this->flag = $row['flag'];

                $this->player = new player(array('id' => $this->player_id));

                if($this->judge_id)
                {
                    $this->judge = new judge(array("id"=>$this->judge_id));
                    //print_r($this->judge);
                }// 在不为　0  的进行
            }
        }

    }


    function  get_player_id()
    {
        return $this->player_id;
    }
    function get_interview_id()
    {
        return $this->id;
    }
    function  get_judge_id()
    {
        return $this->judge_id;
    }
    function get_interview_status()
    {
        return $this->interview_status;
    }
    function get_interview_direction()
    {
        return $this->player->direction;
    }
    function get_score()
    {
        return $this->score;
    }

    function  change_judge_id($judge_id)
    {
        $this->judge_id = $judge_id;
        $this->judge = new judge(array("id"=>$this->judge_id));
        $this->save();
    }

    // 统一修改　interview 和　player 两个状态
    function change_status($new_status)
    {
        $this->interview_status = $new_status;
        $this->player->change_status($new_status);
        $this->save();
    }

    function change_all_score($interview_attitude, $group_attitude, $life_attitude, $base_knowledge, $direction_knowledge,$comment)
    {
        $this->interview_attitude = $interview_attitude;
        $this->group_attitude = $group_attitude;
        $this->life_attitude = $life_attitude;
        $this->base_knowledge = $base_knowledge;
        $this->direction_knowledge = $direction_knowledge;
        $this->comment = $comment;

        $this->score = $interview_attitude + $base_knowledge + $group_attitude + $direction_knowledge + $life_attitude;
        // 计算的得分　　

        $this->save();
    }


    function  save()
    {
        if(!$this->sql) // 如果为空
        {
            $this->sql = new Mysql();

        }
        $query = "UPDATE interview SET
interview_attitude=$this->interview_attitude,group_attitude=$this->group_attitude,life_attitude=$this->life_attitude,
base_knowledge=$this->base_knowledge,direction_knowledge=$this->direction_knowledge,comment='$this->comment',
score = $this->score,flag = $this->flag,interview_status = $this->interview_status,
judge_id = $this->judge_id,player_id = $this->player_id WHERE id = $this->id";

        $this->sql->run($query);
    }

    // 添加一个任务，并返回该任务的　id
    static function add_interview($player_id, $status)
    {
        $flag = $player_id . time();// 获得　flag

        $sql = new Mysql();

        $sql->run("INSERT INTO interview (player_id,interview_status,flag) VALUE ($player_id,$status,'$flag')");

        return $sql->getValue("SELECT id FROM interview WHERE flag = $flag");

    }

    // 返回具有相同的　status 的　interview 对象
    static function get_same_status_interview($array)
    {
//        $query = "SELECT * FROM interview JOIN player ON interview.player_id=player.id WHERE  ";
      $query =  " select interview.id as id ,
player_id,
judge_id,
interview_status
,interview_attitude
,group_attitude
,life_attitude
,base_knowledge
,direction_knowledge
,comment, score,flag
,name,student_id, grade,class,tel,direction, status
from interview  join player on interview.player_id = player.id WHERE ";
        foreach ($array as $value) {
            $query = $query . " interview_status=$value OR ";
        }
        $query = $query . " interview_status=0 ORDER BY interview.id ASC  ";// 用不存在的情况结尾


        $sql = new Mysql();
        $ret = $sql->getDate($query);
        if (!$ret) {
            return null;
        }

        $count = count($ret);
        $return_array = null;
        for ($i = 0; $i < $count; $i++) {
            $return_array[$i] = new interview($ret[$i]);
        }

        return $return_array;


    }


}