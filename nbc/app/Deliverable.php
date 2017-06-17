<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Deliverable extends Model
{
    //
    public function content () {
        return $this->hasOne('App\DeliverableContent', 'deliverable_id', 'id');
    }
    public function comments () {
        return $this->hasMany('App\DeliverableComment', 'deliverable_id', 'id');
    }
}
