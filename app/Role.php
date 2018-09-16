<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public function projects()
    {
        return $this->belongsTo('App\Project','project_id','id');
    }
}
