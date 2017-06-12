<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    //
    public function project () {
    	return $this->hasOne('App\Project', 'id', 'project_id');
    }
}
