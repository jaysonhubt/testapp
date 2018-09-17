<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    public function showAll() {
        return $this->all();
    }

    public function show($id) {
        return $this->find($id);
    }
}
