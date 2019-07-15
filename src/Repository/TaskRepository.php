<?php
namespace Web\FrontController\Repository;

use Web\FrontController\Core\DB;
class TaskRepository
{
    private $db;
    public function __construct()
    {
        $this->db=DB::getDB();
    }

    public function addTask($taskData){
        //приводим строку к ассоциативному массиву
        $taskData=json_decode($taskData,true);
        $sql='INSERT INTO Task (title,description,isDel) VALUE (:title, :description, :isDel)';
        return $this->db->nonSelectQuery($sql,$taskData);
    }

    public function getAllTasks(){
        $sql='SELECT * FROM task';
        return $this->db->getAll($sql);
    }

    public function deleteTasks($taskData){
        $taskData=json_decode($taskData);
        $sql='DELETE from task WHERE id IN (';
        foreach ($taskData as &$task){
            $task=(int)$task;
            $sql.='?,';
        };
        $sql = substr($sql, 0, -1);
        $sql.=')';

        return $this->db->nonSelectQuery($sql,$taskData);

    }
}