<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TaskGroup extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'task_group';

    protected $fillable = [
        'name',
        'description',
        'not_started_count',
        'ongoing_count',
        'completed_count',
    ];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
