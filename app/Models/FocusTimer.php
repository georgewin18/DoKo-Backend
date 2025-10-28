<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FocusTimer extends Model
{
    use HasFactory;

    protected $table = 'focus_timer';

    protected $fillable = [
        'name',
        'focus_time',
        'break_time',
        'section',
    ];
}
