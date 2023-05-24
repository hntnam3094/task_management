<?php
namespace App\Repositories\Task;
use App\Repositories\BaseRepository;

class TaskNoteRepository extends BaseRepository {

    public function getModel()
    {
        return \App\Models\Note::class;
    }
}
