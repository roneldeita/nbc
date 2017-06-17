<?php

namespace App\Services;

use Auth;
use DB;


use App\Proposal;

class HProposal
{
		public function exist ($projectId) {
			return count(Proposal::where('project_id', $projectId)->where('worker_id', Auth::user()->id)->first());
		}

        public function fetchAll () {
            return DB::table('proposals')
                    ->join('projects', 'proposals.project_id', '=', 'projects.id')
                    ->where('proposals.worker_id', Auth::user()->id)
                    ->where('projects.status', 2)
                    //->orWhere('projects.status', 3) -- 3 = prescreening
                    ->orderBy('proposals.id', 'desc')
                    ->select('projects.id', 'projects.name')
                    ->get();

        }
        public function create ($request, $projectId) {
        	$proposal = new Proposal;
            $proposal->worker_id = Auth::user()->id;
            $proposal->project_id = $projectId;
            $proposal->days = $request->get('days');
            $proposal->amount = $request->get('amount');
            $proposal->message = $request->get('message');
            $proposal->save();
        }
}
?>
