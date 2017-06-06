<?php

namespace App\Services\Users;

use Auth;

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

    public function viewProject ($status) {
            $result;
            switch ($status) {
                    case 1 :
                        $result = 'client/projects/draft/view';
                        break;
                    case 2 :
                        $result = 'client/projects/published/view';
                        break;
                    case 3 :
                        $result = 'client/projects/prescreening/view';
                        break;
                    case 4 :
                        $result = 'client/projects/contract/view';
                        break;
                    case 5 :
                        $result = 'client/projects/progress/view';
                        break;
                    case 6 :
                        $result = 'client/projects/closed/view';
                        break;
                    default :
                        $result ='errors/404';
                        break;
            }
            return $result;
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
