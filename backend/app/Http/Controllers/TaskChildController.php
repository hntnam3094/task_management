<?php

namespace App\Http\Controllers;

use App\Http\Requests\Task\TaskChilRequest;
use Illuminate\Http\Request;
use App\Repositories\Task\TaskChildRepository;
class TaskChildController extends Controller
{
    protected $repository;

    public function __construct()
    {
        $this->repository = new TaskChildRepository();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->repository->getAll();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TaskChilRequest $request)
    {
        $request->validated();
        $data = [
            'taskId' => $request->taskId,
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
        return $this->repository->find($id);
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
    public function update(TaskChilRequest $request, $id)
    {
        $request->validated();
        $data = [
            'taskId' => $request->taskId,
            'name' => $request->name,
            'description' => $request->description,
            'status' => $request->status,
            'startDate' => $request->startDate,
            'endDate' => $request->endDate
        ];

        return $this->repository->update($id, $data);
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

    public function doneStatus ($id) {
        return $this->repository->updateStatus($id);
    }
}
