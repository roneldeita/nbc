<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkerEducation extends Model
{
    //
    protected $fillable = ['worker_id', 'type', 'school', 'from', 'to'];
}
