<?php
namespace App\Repositories\Task;
use App\Repositories\BaseRepository;

class TaskChildRepository extends BaseRepository {

    public function getModel()
    {
        return \App\Models\TaskChilren::class;
    }

    public function updateStatus ($id) {
        $data = $this->find($id);

        if ($data) {
            $status = $data->status == 1 ? 0 : 1;
            $attr['status'] = $status;
            $data->update($attr);
            return $data;
        }
        return false;
    }
}
