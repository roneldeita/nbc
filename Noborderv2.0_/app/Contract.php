<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    //
    public function project () {
        return $this->hasOne('App\Project', 'id', 'project_id');
    }

    public function worker () {
        return $this->hasOne('App\User', 'id', 'worker_id');
    }

    public function client () {
        return $this->hasOne('App\User', 'id', 'client_id');
    }

    public function deliverables () {
        return $this->hasMany('App\Deliverable', 'project_id', 'project_id');
    }

    public function terms () {
        return $this->hasMany('App\Term', 'project_id', 'project_id');
    }
}
