<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public function members()
    {
        return $this->belongsTo('App\Member','member_id','id');
    }
}
