<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory, SoftDeletes;

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

    public function taskGroup()
    {
        return $this->belongsTo(TaskGroup::class);
    }
}
