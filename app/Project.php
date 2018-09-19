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
        if (!$projects->count()) {
            return response()->json([
                'status' => 'Have no projects'
            ]);
        }
        return response()->json($projects);
    }

    public function showProject($id) {
        $project = $this->find($id);
        if (!$project) {
            return response()->json([
                'status' => 'Project does not exist'
            ]);
        }
        return response()->json($project);
    }
}
