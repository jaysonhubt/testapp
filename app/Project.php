<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    public function updateProject($request, $id)
    {
        $project = $this->find($id);

        return $this->saveData($project, $request);
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
