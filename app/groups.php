<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class groups extends Model
{
    public function group_members()
    {
        return $this->hasMany('App\group_members', 'group_id');
    }
}
