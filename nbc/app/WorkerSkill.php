<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkerSkill extends Model
{
    //
    protected $fillable = ['worker_id', 'skill_id'];

    public function category () {
        return $this->hasOne('App\SkillCategory', 'id', 'skill_id');
    }

    public function skill () {
    	return $this->hasOne('App\Skill', 'id', 'skill_id');
    }
}
