<?php

namespace App\Http\Controllers;

use App\Http\Requests\Task\TaskRequest;
use App\Jobs\SendMail;
use App\Repositories\Task\TaskRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{

    protected $repository;

    public function __construct()
    {
        $this->repository = new TaskRepository();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = $this->repository->getAllTaskWithSubTask();

        return response()->json(['items' => $result], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(TaskRequest $request)
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TaskRequest $request)
    {
        $request->validated();

        $data = [
            'userId' => $request->userId,
            'name' => $request->name,
            'description' => $request->description,
            'startDate' => $request->startDate,
            'endDate' => $request->endDate
        ];
        return $this->repository->create($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->repository->getTasknSubTaskByTaskId($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TaskRequest $request, $id)
    {
        $request->validated();

        $data = [
            'userId' => $request->userId,
            'name' => $request->name,
            'description' => $request->description,
            'status' => $request->status,
            'startDate' => $request->startDate,
            'endDate' => $request->endDate
        ];

        $this->repository->update($id, $data);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->repository->delete($id);
    }

    public function complete($id) {
        $user = Auth::user();
        $message = [
            'type' => 'Create task',
            'task' => 'Test send mail',
            'content' => 'has been created!',
        ];
        SendMail::dispatch('complete_task',$message, $user);
        return $this->repository->complete($id);
    }
}
