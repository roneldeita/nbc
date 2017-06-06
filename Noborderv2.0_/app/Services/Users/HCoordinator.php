<?php

namespace App\Services\Users;

use Auth;

use App\Project;
use Facades\App\Services\HProject;

class HCoordinator
{

	public function projects () {
		return array
        ('publishedProjects' => HProject::fetchAllByStatus(2),
         'prescreeningProjects' => HProject::fetchAllByStatus(3),
		 'contractProjects' => HProject::fetchAllByStatus(4),
         'progressProjects' => HProject::fetchAllByStatus(5),
         'closedProjects' => HProject::fetchAllByStatus(6)
        );
	}

        public function viewProject ($status) {
                $result;
                switch ($status) {
                        case 2 :
                            $result = 'coordinator/projects/published/view';
                            break;
                        case 3 :
                            $result = 'coordinator/projects/prescreening/view';
                            break;
                        case 4 :
                            $result = 'coordinator/projects/contract/view';
                            break;
                        case 5 :
                            $result = 'coordinator/projects/progress/view';
                            break;
                        case 6 :
                            $result = 'coordinator/projects/closed/view';
                            break;
                        default :
                            $result ='errors/404';
                            break;
                }
                return $result;
        }

        public function identifyStatus ($status) {
            $result;
            switch ($status) {
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
