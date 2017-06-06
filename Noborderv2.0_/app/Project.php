<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    //hasMany ('table', '')
    public function contract () {
        return $this->hasOne('App\Contract', 'project_id', 'id');
    }

    public function proposals () {
        return $this->hasMany('App\Proposal', 'project_id', 'id');
    }

    public function client () {
    	return $this->hasOne('App\User', 'id', 'client_id');
    }

    public function coordinator () {
        return $this->hasOne('App\User', 'id', 'coordinator_id');
    }

    public function skillCategory () {
    	return $this->hasOne('App\SkillCategory', 'id', 'skill_category_id');
    }

    public function messages () {
        return $this->hasMany('App\Message', 'project_id', 'id');
    }


}
