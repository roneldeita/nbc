<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proposal extends Model
{
    //
    public function worker () {
        return $this->hasOne('App\User', 'id', 'worker_id');
    }

    public function project () {
        return $this->hasOne('App\Project', 'id', 'project_id');
    }
}
