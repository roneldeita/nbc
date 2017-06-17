<?php

namespace App\Http\Controllers;

use DB;
use App\Contract;
use App\Project;
use App\Proposal;
use App\Skill;
use App\SkillCategory;
use App\WorkerSkill;
use App\WorkerPersonal;
use App\WorkerEducation;
use App\WorkerExperience;
use App\DeliverableContent;
use App\DeliverableComment;


use Illuminate\Http\Request;
use Facades\App\Services\Notifications;

use Facades\App\Services\Users\HWorker;
use Facades\App\Services\Users\HMessage;

class WorkerController extends Controller
{
    //

    public function Index () {
        return view('worker/home/index',HWorker::projects());
    }

    public function IndexProfile () {
    	return view('worker/profile/index');
    }

    public function IndexWork (Request $request) {
    	$projects = Project::where('status', 2)->whereNotIn('id',HWorker::proposalIds())->orderBy('id', 'desc')->paginate(5);
    	return view('worker/find_work/index')->with('projects', $projects);
    }

    // SHOULD UPDATE
    public function ViewWork ($hashedProjectId, Request $request) {
        $projectId = HELPERDoubleDecrypt($hashedProjectId);
        if (!is_numeric($projectId) || empty(Project::find($projectId))) {
            return view('errors/404');
        } else {
            $project = Project::find($projectId);

            if (Proposal::where('project_id', $projectId)->where('worker_id', $request->user()->id)->first()) {
                return 'invalid id';
            }

            if ($project->status != 2) {
                return view('errors/404');
            }
            return view('worker/find_work/view')->with('project', Project::find($projectId));
        }
    }

    // FIXED
    public function SaveProposal (Request $request) {
        $projectId = HELPERDoubleDecrypt($request->get('project_id'));

        if (!is_numeric($projectId) || empty(Project::find($projectId))) {
            return json_encode(array("status" => 4000));
        } else {
            if (Project::find($projectId)->status != 2 ) {
                return json_encode(array("status" => 4000));
            } else if (HWorker::hasProposal($projectId)) {
                return json_encode(array("status" => 4000));
            }

            HWorker::createProposal($request, $projectId);
            $project = Project::find($projectId);
            $container = array();
            $container['project_id'] = $projectId;
            $container['type'] = 11;
            $container['to'] = $project->client_id;
            $container['content'] = array("id" => $projectId, "name" => $project->name);

            Notifications::CreateV2($container);

            $containerB = array();
            $containerB['project_id'] = $projectId;
            $containerB['type'] = 11;
            $containerB['to'] = $project->coordinator_id;
            $containerB['content'] = array("id" => $projectId, "name" => $project->name);

            Notifications::CreateV2($containerB);


            return json_encode(array("status" => 2000));
        }
    }

    // SHOULD UPDATE
    public function IndexProject (Request $request) {
        return view('worker/projects/index', HWorker::projects());
    }

    // SHOULD UPDATE
    public function ViewProject ($status, $hashedProjectId, Request $request) {
        $projectId = HELPERDoubleDecrypt($hashedProjectId);
        if (!is_numeric($projectId) || empty(Project::find($projectId))) {
            return view('errors/404');
        }

        $project = Project::find($projectId);
        $proj = HELPERIdentifyStatus($project->status);

        // check if its published or pre screening
        if ($proj['_status'] == 'published' || $proj['_status'] == 'pre_screening') {
            if ($status != 'proposal') {
                return 'Invalid id';
            }

            $proposal = Proposal::where('project_id', $projectId)->where('worker_id', $request->user()->id)->first();
            if (count($proposal)) {
                return view('/worker/projects/proposal/index')->with('proposal', $proposal);
            }
            return 'Invalid id';
        }
        if ($proj['_status'] == 'in_progress' && $status == $proj['_status']) {
            $projectWithContractDetails = Project::where('id', $projectId)->with('contract', 'contract.deliverables', 'contract.deliverables.comments', 'contract.deliverables.content', 'contract.deliverables.comments.by')->first();
            return view('/worker/projects/progress/index')->with('project', $projectWithContractDetails);
        }

        if ($proj['_status'] != $status) {
            return view('worker/projects/outdated');
        }
    }

    public function ViewContract ($hashedContractId, Request $request) {
        $contractId = HELPERDoubleDecrypt($hashedContractId);
        if (!is_numeric($contractId) || empty(Contract::find($contractId))) {
            return view('errors/404');
        }

        $contract = Contract::find($contractId);
        if ($contract->project->status != 4) {
            return view('worker/projects/outdated');
        }
        if ($contract->worker_id != $request->user()->id) {
            return 'Invalid Id';
        }
        return view('/worker/projects/contract/view')->with('contract', $contract);
    }

    public function ContractApprove (Request $request) {
        $contract = Contract::find($request->get('id'));
        if ($contract) {
            $contract->worker_approved = 1;
            $contract->save();

            $container = array();
            $container['project_id'] = $request->get('id');
            $container['type'] = 4;
            $container['to'] = $contract->client_id;
            $container['content'] = array("id" => $contract->project_id, "name" => $contract->project->name, "by" => "worker");

            Notifications::CreateV2($container);

            $containerB = array();
            $containerB['project_id'] = $request->get('id');
            $containerB['type'] = 4;
            $containerB['to'] = $contract->project->coordinator_id;
            $containerB['content'] = array("id" => $contract->project_id, "name" => $contract->project->name, "by" => "worker");

            Notifications::CreateV2($containerB);

            return $contract;
        }else {
            // not found
        }
    }

    public function SaveDeliverableContent (Request $request) {
        $comment = new DeliverableContent;
        $comment->deliverable_id = $request->get('deliverable_id');
        $comment->content = $request->get('content');
        $comment->save();
    }

    public function SaveDeliverableComment (Request $request) {
        $comment = new DeliverableComment;
        $comment->user_id = $request->user()->id;
        $comment->deliverable_id = $request->get('deliverable_id');
        $comment->content = $request->get('content');
        $comment->save();
    }

    public function ReadNotification (Request $request) {
        return Notifications::MarkAsRead($request->get('notification_id'));
        //return $request;
    }

    // SHOULD UPDATE
    public function IndexSkill (Request $request) {

        if (count($request->user()->skills) > 0) {
            return redirect('worker/');
        }
        return view('worker/basic_requirements/skill')->with('categories', SkillCategory::all());
    }

    public function IndexPersonal (Request $request) {

        return view('worker/basic_requirements/personal');
    }

    public function IndexEducation (Request $request) {

        return view('worker/basic_requirements/education');
    }

    public function IndexExperience (Request $request) {

        return view('worker/basic_requirements/experience');
    }

    public function PutCache (Request $request) {
        $request->session()->put($request->get('key'), $request->get('value'));
    }

    public function SaveDetails (Request $request) {
        $experience = $request->get('experience');
        $skills = $request->session()->get('skill');
        $personal = $request->session()->get('personal');
        $education = $request->session()->get('education');
        if (count($experience) > 0) {
            for ($i =0; $i < count($experience); $i++) {
                $worker_experience = new WorkerExperience;
                $worker_experience->worker_id = $request->user()->id;
                $worker_experience->company = $experience[$i]["company"];
                $worker_experience->position = $experience[$i]["position"];
                $worker_experience->from = $experience[$i]["from"];
                $worker_experience->to = $experience[$i]["to"];
                $worker_experience->description = "UPDATE"; //array_key_exist($experience[$i]["additional"], $experience[$i]) == true ? $experience[$i]["additional"] : "";
                $worker_experience->save();
            }
        }
        if (count($skills) > 0) {
            for ($i = 0; $i < count($skills); $i++) {
                $worker_skill = new WorkerSkill;
                $worker_skill->worker_id = $request->user()->id;
                $worker_skill->skill_id = $skills[$i]["id"];
                $worker_skill->save();
            }
        }
        if (count($education) > 0) {
            for ($i =0; $i < count($education); $i++) {
                $worker_education = new WorkerEducation;
                $worker_education->worker_id = $request->user()->id;
                $worker_education->qualification = $education[$i]["qualification"];
                $worker_education->field = $education[$i]["field"];
                $worker_education->school = $education[$i]["institute"];
                $worker_education->from = $education[$i]["from"];
                $worker_education->to = $education[$i]["to"];
                $worker_education->description = "UPDATE";//array_key_exists($education[$i]["additional"], $education[$i]) == true ? $education[$i]["additional"] : "";
                $worker_education->save();
            }
        }

        $worker_personal = new WorkerPersonal;
        $worker_personal->worker_id = $request->user()->id;
        $worker_personal->overview = $personal["overview"];
        $worker_personal->save();


        return 'success';
    }

    public function ViewSkills (Request $request) {
        return Skill::where('skill_category_id', $request->get('id'))->get();
    }

    public function UpdateProfileSkill (Request $request) {

    }

    public function UpdateProfilePersonal (Request $request) {

    }

    public function UpdateProfileEducation (Request $request) {

    }

    public function UpdateProfileExperience (Request $request) {

    }

    public function UpdateProfileAvatar (Request $request) {

    }

    public function sessionChecker (Request $request) {
        return $request->session()->all();
    }

    public function SendMessage (Request $request) {
        HMessage::Create($request);
    }
}
