<?php

namespace App\Models;

use App\Traits\FilterStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Task extends Model implements HasMedia
{
    use HasFactory,SoftDeletes,InteractsWithMedia,FilterStatus;

    protected $fillable = [
        'user_id',
        'client_id',
        'project_id',
        'title',
        'description',
        'deadline',
        'finished_at',
        'status',
    ];

    public const Status = [
        'open', 'in progress', 'pending', 'waiting client', 'blocked', 'closed'
    ];

    public function client() : BelongsTo{
        return $this->belongsTo(Client::class,'client_id');
    }

    public function user() : BelongsTo{
        return $this->belongsTo(User::class,'user_id');
    }

    public function project() : BelongsTo{
        return $this->belongsTo(Project::class,'project_id');
    }

    
}
