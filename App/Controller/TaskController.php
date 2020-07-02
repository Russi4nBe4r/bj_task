<?php


namespace App\Controller;


use App\Core\TaskValidator;
use App\Model\TaskModel;

class TaskController extends Controller
{
    public function taskList()
    {
        $taskModel = new TaskModel();
        $tasks = $taskModel->getAll();

        echo $this->twig->load('index.html')->render(['taskList' => $tasks, 'admin' => $_SESSION['isAdmin']]);
    }

    public function taskGetById($id)
    {
        $taskModel = new TaskModel();
        $task = $taskModel->getByPrimary($id);

        echo $this->twig->load('edit.html')->render(['task' => $task, 'admin' => $_SESSION['isAdmin']]);
    }

    public function taskAdd()
    {
        $taskModel = new TaskModel();
        $errors = TaskValidator::validate($_POST);

        if (!empty($errors))
        {
            $tasks = $taskModel->getAll();

            echo $this->twig->load('index.html')->render(['errors' => $errors, 'taskList' => $tasks, 'admin' => $_SESSION['isAdmin']]);
            exit();
        }

        $taskModel->create();

        header('Location: /');
    }

    public function taskUpdate($id)
    {
        $taskModel = new TaskModel();
        $errors = TaskValidator::validate($_POST);

        if (!empty($errors))
        {
            $task = $taskModel->getByPrimary($id);

            echo $this->twig->load('edit.html')->render(['errors' => $errors, 'task' => $task, 'admin' => $_SESSION['isAdmin']]);
            exit();
        }

        $taskModel->update($id);

        header("Location: /tasks/{$id}");
    }

    public function taskComplete($id)
    {
        $taskModel = new TaskModel();
        $taskModel->complete($id);

        $response = [];

        switch ($_POST['completed'])
        {
            case 1:
                $response['completed'] = 1;
                $response['message'] = 'Task matched as completed';
                break;
            case 0:
                $response['completed'] = 0;
                $response['message'] = 'Task matched as uncompleted';
                break;
        }

        echo \json_encode($response);
    }
}