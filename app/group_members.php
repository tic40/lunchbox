<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class group_members extends Model
{
    public function groups()
    {
        return $this->belongsTo('App\groups', 'group_id');
    }

    public function employees()
    {
        return $this->belongsTo('App\employees', 'employee_id');
    }
}
