<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Task;

class TaskGroup extends Model
{
    use HasFactory;
    
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

    public function updateTaskCounts()
    {
        $this->not_started_count = $this->tasks()->where('progress', 0)->count();
        $this->ongoing_count = $this->tasks()->whereBetween('progress', [1, 99])->count();
        $this->completed_count = $this->tasks()->where('progress', 100)->count();
        $this->save();
    }
}