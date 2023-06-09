<?php

namespace App\Repositories\Task;

use App\Jobs\SendMail;
use App\Models\TaskChilren;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class TaskRepository extends BaseRepository {

    public function getModel()
    {
        return \App\Models\Task::class;
    }

    public function getAll()
    {
        $user = Auth::user();
        if ($user) {
            return $this->model->where('userId', $user->id)->get();
        }
        return [];
    }

    public function getTasknSubTaskByTaskId ($id) {

        $data = $this->find($id);
        if ($data) {
            $subTask = TaskChilren::query()->where('taskId', $id)->get();
            $data['subTask'] = $subTask;
        }

        return $data;
    }

    public function getAllTaskWithSubTask () {
        $data = $this->getAll();

        if ($data) {
            foreach ($data  as $item) {
                $subTask = TaskChilren::query()->where('taskId', $item->id)->get();
                $item['subTask'] = $subTask;
            }
        }

        return $data;
    }

    public function complete ($id) {
        $data = $this->find($id);

        if ($data) {
            $status = $data->status == 1 ? 0 : 1;

            if ($status == 1) {
                $user = Auth::user();
                $message = [
                    'type' => 'Complete task',
                    'task' => $data->name,
                    'content' => 'Congratulations, you completed a task for the day! Come back and do more of your planned work',
                ];

                SendMail::dispatch('complete_task',$message, $user);
            }

            $attr['status'] = $status;
            $data->update($attr);
            return $data;
        }
        return false;
    }
}
