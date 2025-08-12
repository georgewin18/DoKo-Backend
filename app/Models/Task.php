<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory;
    protected $table = 'task';

    protected $fillable = [
        'name',
        'description',
        'attachment',
        'date',
        'time',
        'progress',
        'task_group_id',
    ];

    public function taskGroup(): BelongsTo
    {
        return $this->belongsTo(TaskGroup::class);
    }

    //Task Status
    public function getStatusAttribute()
    {
        if ($this->progress == 0) {
            return 'not_started';
        } elseif ($this->progress > 0 && $this->progress < 100) {
            return 'ongoing';
        } elseif ($this->progress == 100) {
            return 'completed';
        }

        return null;
    }
}