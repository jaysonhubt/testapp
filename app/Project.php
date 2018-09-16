<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    public function storeProject($request)
    {
        return $this->saveData($this, $request);
    }

    public function saveData($project, $request)
    {
        $project->name = $request->name;
        $project->information = $request->information;
        $project->deadline = $request->deadline;
        $project->type = $request->type;
        $project->status = $request->status;
        $project->save();

        return $project;
    }
}
