<?php

namespace App\Models;

use App\Traits\FilterStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Project extends Model implements HasMedia
{
    use HasFactory,SoftDeletes,InteractsWithMedia,FilterStatus;

    protected $fillable = [
        'title',
        'description',
        'deadline',
        'assigned_user',
        'assigned_client',
        'status'
    ];

    public const Status = [
        'open', 'in progress', 'pending', 'waiting client', 'blocked', 'closed'
    ];

    public function user() : BelongsTo{
        return $this->belongsTo(User::class,'assigned_user');
    }

    public function client() : BelongsTo{
        return $this->belongsTo(Client::class,'assigned_client');
    }

    public function tasks() : HasMany{
        return $this->hasMany(Task::class,'project_id');
    }



}
