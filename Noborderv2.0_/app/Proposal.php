<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proposal extends Model
{
    //
    public function worker () {
        return $this->hasOne('App\User', 'id', 'worker_id');
    }
}
