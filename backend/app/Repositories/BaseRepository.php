<?php

namespace App\Repositories;
use App\Repositories\RepositoryInterface;
use Illuminate\Support\Facades\Auth;

abstract class BaseRepository implements RepositoryInterface {
    protected $model;

    public function __construct()
    {
        $this->setModel();
    }

    public function setModel () {
        $this->model = app()->make($this->getModel());
    }

    abstract public function getModel();

    public function getAll()
    {
        return $this->model->all();
    }

    public function find($id)
    {
        $result = $this->model->find($id);
        return $result;
    }

    public function create($attr = [])
    {
        return $this->model->create($attr);
    }

    public function update($id, $attr = [])
    {
        $result = $this->model->find($id);
        if ($result) {
            $result->update($attr);
            return $result;
        }
        return false;
    }

    public function delete($id)
    {
        $result = $this->find($id);
        if ($result) {
            $result->delete();

            return true;
        }

        return false;
    }

}
