<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    public function roles()
    {
        return $this->hasMany('App\Role','member_id','id');
    }

    public function storeMember($request)
    {
        return $this->saveData($this, $request);
    }

    public function updateMember($request, $id)
    {
        $member = $this->find($id);

        return $this->saveData($member, $request);
    }

    public function deleteMember($id)
    {
        $member = $this->find($id);
        if ($member) {
            foreach ($member->roles as $role) {
                $role->delete();
            };
            $member->delete();
            return response()->json("Deleted member success");
        }
        return response()->json("Member does not exist");
    }

    public function saveData($member, $request)
    {
        $member->name = $request->name;
        $member->information = $request->information;
        $member->phone = $request->phone;
        $member->dob = $request->dob;
        if ($request->hasFile('avatar')) {
            $file = $request->avatar;
            $fileName = time() . $file->getClientOriginalName();
            $file->storeAs('avatar', $fileName);
            $member->avatar = $fileName;
        }
        $member->position = $request->position;
        $member->gender = $request->gender;
        $member->save();

        return $member;
    }

    public function showAllMembers() {
        $members = $this->all();
        if (!$members) {
            return response()->json([
                'status' => 'Have no members'
            ]);
        }
        return response()->json($members);
    }

    public function showMember($id) {
        $member = $this->find($id);
        if (!$member) {
            return response()->json([
                'status' => 'Member does not exist'
            ]);
        }
        return response()->json($member);
    }
}
