<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class groups extends Model
{
    public function group_members()
    {
        return $this->hasMany('App\group_members', 'group_id');
    }

    public function employees()
    {
        return $this->belongsToMany('App\employees', 'group_members', 'group_id', 'employee_id');
    }
}
