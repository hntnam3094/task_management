<?php

namespace App\Repositories\Blog;


use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Auth;

class  BlogRepository extends BaseRepository {

    public function getModel()
    {
        return \App\Models\Blog::class;
    }

    public function getAll()
    {
        return $this->model->where('blog.status', 1)
            ->join('users', 'users.id', '=', 'blog.userId')
            ->select('blog.*', 'users.name as authorBlog')
            ->get();
    }

    public function getDetailBySlug ($slug) {
        $data = $this->model->where('slug', $slug)
                            ->join('users', 'users.id', '=', 'blog.userId')
                            ->select('blog.*', 'users.name as authorBlog')->first();
        if ($data) {
            $data->update(['view' => $data->view + 1]);
        }

        return $data;
    }

    public function getLatest()
    {
        return $this->model->where('blog.status', 1)
            ->join('users', 'users.id', '=', 'blog.userId')
            ->select('blog.*', 'users.name as authorBlog')
            ->orderBy('created_at', 'asc')->limit(5)->get();
    }

    public function getAllByUserLogged () {
        $user = Auth::user();
        if ($user) {
            return $this->model->where('userId', $user->id)->get();
        }
        return [];
    }


    public function find ($id) {
        $user = Auth::user();
        if ($user) {
            return $this->model->where('userId', $user->id)->where('id', $id)->first();
        }
        return [];
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
}
