<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkerExperience extends Model
{
    //
    protected $fillable = ['worker_id', 'company', 'position', 'from', 'to', 'description'];
}
