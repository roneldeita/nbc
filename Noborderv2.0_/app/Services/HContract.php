<?php

namespace App\Services;

use Auth;
use DB;

use App\Contract;
use App\Project;
class HContract
{
        public function fetchAll () {
            return Project::join('contracts', 'contracts.project_id', '=', 'projects.id')
                    ->where('contracts.worker_id', Auth::user()->id)
                    ->where('projects.status', 4)
                    ->select('projects.name',
               			DB::raw('contracts.id as contracts_id'),'contracts.worker_approved', 'contracts.client_approved', 'contracts.created_at')
                    ->orderBy('contracts_id','desc')
                    ->get();

        }

}
?>
