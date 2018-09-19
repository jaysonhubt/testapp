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
            return response()->json([
                'message' => 'Deleted project success'
            ]);
        }
        return response()->json([
            'message' => 'Project does not exist'
        ]);
    }

    public function updateProject($request, $id)
    {
        $project = $this->find($id);

        return $this->saveData($project, $request);
    }

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

    public function showAllProjects() {
        $projects = $this->all();

        return response()->json($projects);
    }

    public function showProject($id) {
        $project = $this->find($id);
        if (!$project) {
            abort(404);
        }
        return response()->json($project);
    }
}
