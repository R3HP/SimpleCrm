<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'client_to',
        'project_id',
        'title',
        'description',
        'deadline',
        'finished_at',
        'status',
    ];
}
