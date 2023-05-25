<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

    protected $table = 'task_note';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'taskId', 'content', 'status'];
}
