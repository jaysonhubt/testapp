<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public function projects()
    {
        return $this->belongsTo('App\Project','project_id','id');
    }

    public function members()
    {
        return $this->belongsTo('App\Member','member_id','id');
    }
}
