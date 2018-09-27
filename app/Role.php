<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public function projects()
    {
        return $this->belongsTo('App\Project', 'project_id', 'id');
    }

    public function members()
    {
        return $this->belongsTo('App\Member', 'member_id', 'id');
    }

    public function storeRole($request)
    {
        $role = $this->where([
            ['member_id', '=', $request->member_id],
            ['project_id', '=', $request->project_id]
        ])->get();

        if ($role->count()) {
            return ['message' => 'This role already exists'];
        }

        $this->project_id = $request->project_id;
        $this->member_id = $request->member_id;
        $this->role = $request->role;
        $this->save();

        return $this;
    }

    public function deleteRole($memberId, $projectId)
    {
        $role = $this->where([
            ['member_id', '=', $memberId],
            ['project_id', '=', $projectId]
        ]);
        if ($role->count()) {
            $role->delete();
            return response()->json([
                'message' => 'Deleted role success'
            ]);
        }
        return response()->json([
            'message' => 'Role does not exist'
        ]);
    }

    public function showMemberInProject($projectId)
    {
        $roles = $this->select('roles.member_id', 'members.name', 'members.position', 'roles.role')
            ->join('members', 'roles.member_id', '=', 'members.id')
            ->where([['project_id', '=', $projectId]])
            ->get()->toArray();

        if (count($roles)) {
            return $roles;
        }

        return response()->json([
            'message' => 'Have no role'
        ]);
    }

    public function showMemberNotInProject($projectId)
    {
        $roles = $this->select('members.id', 'members.name', 'members.position')
            ->join('members', 'roles.member_id', '=', 'members.id', 'right')
            ->whereNull('roles.member_id')
            ->get()->toArray();

        if (count($roles)) {
            return $roles;
        }

        return response()->json([
            'message' => 'Have no role'
        ]);
    }
}
