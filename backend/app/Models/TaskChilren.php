<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskChilren extends Model
{
    use HasFactory;

    protected $table = 'task_children';
    protected $primaryKey = 'id';
    protected $fillable = ['id','taskId','name','description','status','startDate','endDate'];
}
