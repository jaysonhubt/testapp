<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    public function show($id = null) {
        if ($id) {
            return $this->find($id);
        }
       return $this->all();
    }
}
