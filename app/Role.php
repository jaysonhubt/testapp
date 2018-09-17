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

    public function storeRole($request)
    {
        $this->project_id = $request->project_id;
        $this->member_id = $request->member_id;
        $this->role = $request->role;
        $this->save();

        return $this;
    }
}
