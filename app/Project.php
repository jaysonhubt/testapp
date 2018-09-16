<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    public function roles()
    {
        return $this->hasMany('App\Role','project_id','id');
    }

    public function deleteProject($id)
    {
        $project = $this->find($id);
        if ($project) {
            foreach ($project->roles as $role) {
                $role->delete();
            };
            $project->delete();
            return response()->json("Deleted project success");
        }
        return response()->json("Project does not exist");
    }
}
