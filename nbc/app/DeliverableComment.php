<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeliverableComment extends Model
{
    //
    public function by () {
        return $this->hasOne('App\User', 'id', 'user_id');
    }
}
