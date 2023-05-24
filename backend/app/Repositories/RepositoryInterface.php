<?php

namespace App\Repositories;

interface RepositoryInterface {
    public function getAll();
    public function find($id);
    public function create($attr = []);
    public function update($id, $attr = []);
    public function delete($id);

}
