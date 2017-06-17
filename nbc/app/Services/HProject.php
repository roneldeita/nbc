<?php

namespace App\Services;

use Auth;

use App\Project;
use App\WorkerProjects;
use Facades\App\Services\HUser;

class HProject
{
	public function fetchAllByStatus ($status = 1, $orderBy = 'id', $orderType = 'desc') {
		return
			Project::where(HUser::getRoleId(), Auth::user()->id)
				->where('status', $status)
				->orderBy($orderBy, $orderType)
				->get();
	}

	public function fetchInProgress () {
		return
			WorkerProjects::where('worker_id', Auth::user()->id)
				->where('status', 0)
				->orderBy('id', 'desc')
				->get();
	}

	public function create ($request) {
	$project = new Project;
        $project->skill_category_id = $request->get('type');
        $project->client_id = $request->user()->id;
        $project->coordinator_id = 1;
        $project->name = $request->get('name');
        $project->description = $request->get('description');
        //$project->budget = $request->get('budget');
        //will be change
        $project->budget_info = json_encode(array("type" => 1, "budget" => $request->get("budget")));
        $project->timeline = $request->get('timeline');
        $project->status = 1; // make it draft first
        $project->deliverables = json_encode($request->get('deliverables'));
        $project->terms_condition = json_encode($request->get('termAndAgreements'));
        $project->skills = "{id : 1},{id : 2}";
        $project->link = $request->get('link');
        $project->save();
        return $project;
	}


}
?>
