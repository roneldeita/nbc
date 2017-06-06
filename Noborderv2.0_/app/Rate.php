<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    //

    protected $fillable = ['worker_id', 'project_id', 'rate'];
}
