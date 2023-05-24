<?php

namespace App\Http\Controllers;

use App\Http\Requests\Task\TaskNoteRequest;
use App\Repositories\Task\TaskNoteRepository;

class TaskNoteController extends Controller
{
    protected $repository;

    public function __construct()
    {
        $this->repository = new TaskNoteRepository();
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
    public function create(TaskNoteRequest $request)
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TaskNoteRequest $request)
    {
        $request->validated();

        $data = [
            'taskId' => $request->taskId,
            'content' => $request->content
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
    public function update(TaskNoteRequest $request, $id)
    {
        $request->validated();

        $data = [
            'taskId' => $request->taskId,
            'content' => $request->content,
            'status' => $request->status
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
}
