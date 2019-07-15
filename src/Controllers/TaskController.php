<?php
namespace Web\FrontController\Controllers;

use Web\FrontController\Repository\TaskRepository;

class TaskController
{
    private $taskRepository;
    public function __construct()
    {
        $this->taskRepository=new TaskRepository();
    }

    public function postAction(){
        //$taskData-это просто json строка
        //считали данные из тела сообщения, так как js передает кривой формат, тут приняли данные переданные методом post
        $taskData=file_get_contents('php://input');
        echo $this->taskRepository->addTask($taskData)===false?'Ошибка':'Задача добавлена';
    }

    public function getAction(){
        //getAllTasks - соединится с базой и вернет массив задач, преобразуем в json строку и вернем на клиент
        echo json_encode($this->taskRepository->getAllTasks());
    }

    public function deleteAction(){
        $taskData=file_get_contents('php://input');
        echo $this->taskRepository->deleteTasks($taskData)===false?'Ошибка удаления':'Задача удалена';
    }
}