<?php

namespace App\Traits;

use Illuminate\Contracts\Database\Eloquent\Builder;

trait FilterStatus
{

    
    public function scopeOpen(Builder $query) : Builder{
        return $query->where('status','open');;
    }

    public function scopeDone(Builder $query) : Builder{
        return $query->where('status','done');
    }

    public function scopeFilterStatus(Builder $query,?string $status) : Builder {
        if(
            in_array($status,self::Status)
        ){
            return $query->where('status',$status);

        }
        return $query;
    }
}
