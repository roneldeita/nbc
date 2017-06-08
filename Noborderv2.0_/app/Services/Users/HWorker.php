<?php

namespace App\Services\Users;

use Auth;

use App\Project;
use Facades\App\Services\HProject;
use Facades\App\Services\HProposal;
use Facades\App\Services\HContract;
class HWorker
{
        public function projects () {
                return array
        ('proposalProjects' => HProposal::fetchAll(),
        'contractProjects' => HContract::fetchAll(),
        'progressProjects' => HProject::fetchInProgress(),
        );

        }

        public function proposalIds () {
                return  collect(HProposal::fetchAll())->pluck('id');
        }

        public function createProposal ($data, $data2) {
                HProposal::create($data, $data2);
        }

        public function hasProposal ($data) {
                return HProposal::exist($data);
        }
}
?>
