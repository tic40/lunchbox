<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class employees extends Model
{
    public function departments()
    {
        return $this->belongsTo('App\departments', 'department_id');
    }

    public function positions()
    {
        return $this->belongsTo('App\positions', 'position_id');
    }

    public function group_members()
    {
        return $this->belongsTo('App\group_members', 'id', 'employee_id');
    }

    public function groups()
    {
        return $this->belongsToMany('App\groups', 'group_members', 'employee_id', 'group_id');
    }
}
