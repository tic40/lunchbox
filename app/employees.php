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
}
