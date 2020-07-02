<?php


namespace App\Model;


class TaskModel extends Model
{
    protected $table = 'tasks';
    protected $primary = 'task_id';
    protected $fieldsList = [
        'username',
        'email',
        'description',
    ];

    public function getAll()
    {
        $tasks = parent::getAll();

        array_walk($tasks, function (&$value, $key) {
            $tags = [];
            if ($value['edited'])
            {
                $tags[] = 'edited';
            }

            if ($value['completed'])
            {
                $tags[] = 'completed';
            }

            if (empty($tags))
            {
                $tags[] = 'new';
            }

            $value['tags'] = implode('|', $tags);
        });

        return $tasks;
    }

    public function update($id)
    {
        parent::update($id);

        if ($this->dbConnection->affected_rows)
        {
            $sql = "UPDATE {$this->table} SET edited=1 WHERE {$this->primary}='{$id}'";
            $this->dbConnection->query($sql);
        }
    }

    public function complete($id)
    {
        $complated = $_POST['completed'];

        $sql = "UPDATE tasks SET completed={$complated} WHERE {$this->primary}='{$id}'";
        $this->dbConnection->query($sql);
    }
}