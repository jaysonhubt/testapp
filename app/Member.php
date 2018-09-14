<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    public function storeMember($request)
    {
        return $this->saveData($this, $request);
    }

    public function updateMember($request, $id)
    {
        $member = $this->find($id);

        return $this->saveData($member, $request);
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
}
