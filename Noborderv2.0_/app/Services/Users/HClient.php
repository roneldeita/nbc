<?php

namespace App\Services\Users;

use Auth;
use DB;

use App\Project;
use Facades\App\Services\HProject;

class HClient
{
	public function projects () {
		return array
        ('draftProjects' => HProject::fetchAllByStatus(),
         'publishedProjects' => HProject::fetchAllByStatus(2),
         'matchingProjects' => HProject::fetchAllByStatus(3),
         'contractProjects' => HProject::fetchAllByStatus(4),
         'progressProjects' => HProject::fetchAllByStatus(5),
         'closedProjects' => HProject::fetchAllByStatus(6)
        );
	}

    public function viewProject ($project) {
    switch ($project->status) {
        case 1 :
            return view('client/projects/draft/view')->with('project', $project);
            break;
        case 2 :
            $applicants = DB::table('proposals')
                        ->join('projects', 'proposals.project_id', '=', 'projects.id')
                        ->join('users', 'proposals.worker_id', '=', 'users.id')
                        ->where('projects.id', $project->id)
                        ->select('users.id', 'users.name')
                        ->get();
            return view('client/projects/published/view')->with('project', $project)->with('applicants', $applicants);
            break;
        case 3 :
            return view('client/projects/prescreening/view')->with('project', $project);
            break;
        case 4 :
            return view('client/projects/contract/view')->with('project', $project);
            break;
        case 5 :
            return view('client/projects/progress/view')->with('project', $project);
            break;
        case 6 :
            $result = 'client/projects/closed/view';
            break;
        default :
            $result ='errors/404';
            break;
    }
    }


	public function createProject ($data) {
		return HProject::create($data);
	}

    public function identifyStatus ($status) {
            $result;
            switch ($status) {
                    case 1 :
                        $result = 'draft';
                        break;
                    case 2 :
                        $result = 'published';
                        break;
                    case 3 :
                        $result = 'pre_screening';
                        break;
                    case 4 :
                        $result = 'contract_signing';
                        break;
                    case 5 :
                        $result = 'in_progress';
                        break;
                    case 6 :
                        $result = 'closed';
                        break;
                    default :
                        $result ='';
                        break;
            }
            return $result;
    }


}
?>
