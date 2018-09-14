<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    public function storeMember($request)
    {
        $this->name = $request->name;
        $this->information = $request->information;
        $this->phone = $request->phone;
        $this->dob = $request->dob;
        if ($request->file('avatar')->isValid()) {
            $file = $request->avatar;
            $fileName = time() . $file->getClientOriginalName();
            $file->storeAs('avatar', $fileName);
            $this->avatar = $fileName;
        }
        $this->position = $request->position;
        $this->gender = $request->gender;
        $this->save();

        return $this;
    }
}
