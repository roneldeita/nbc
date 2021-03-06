<?php
namespace App\Http\Controllers;

use App\Project;
use App\User;
use App\Contract;
use App\Proposal;
use App\Deliverable;
use App\Term;
use App\WorkerProjects;
use DB;
use Illuminate\Http\Request;
use Facades\App\Services\Users\HCoordinator;
use Facades\App\Services\HMessage;
use Facades\App\Services\Notifications;


class CoordinatorController extends Controller
{
    //
    public function Index () {
        return view('/coordinator/home/index');
    }
    public function IndexProject (Request $request) {

        return view('/coordinator/projects/index', HCoordinator::projects());
    }

    public function ViewProject ($status, $hashedProjectId) {
        $projectId = HELPERDoubleDecrypt($hashedProjectId);
        if (!is_numeric($projectId) || empty(Project::find($projectId))) {
            return view('coordinator/projects/invalid');
        }
        $project = Project::find($projectId);
        if (HCoordinator::identifyStatus($project->status) != $status) {
            return view('coordinator/projects/outdated')->with('project', $project);

        }
        if (HCoordinator::identifyStatus($project->status) == "in_progress") {
            $project = Project::where('id', $project->id)->with('contract', 'contract.deliverables', 'contract.deliverables.comments', 'contract.deliverables.content', 'contract.deliverables.comments.by')->first();
            //return view('coordinator/projects/outdated')->with('project', $projectDetails);

        }
        $applicants = DB::table('proposals')
                    ->join('projects', 'proposals.project_id', '=', 'projects.id')
                    ->join('users', 'proposals.worker_id', '=', 'users.id')
                    ->where('projects.id', $project->id)
                    ->select('users.id', 'users.name', 'proposals.days', 'proposals.amount')
                    ->get();
        return view(HCoordinator::viewProject($project->status))->with('project', $project)->with('applicants', $applicants);
    }

    public function SaveWorkerProject (Request $request) {
        $project = Project::find($request->get('id'));
        $project->status = 5;
        $project->save();

        $worker_project = new WorkerProjects;
        $worker_project->worker_id = $request->get('worker_id');
        $worker_project->project_id = $project->id;
        $worker_project->status = 0;
        $worker_project->save();

        $container = array();
        $container['project_id'] = $request->get('id');
        $container['type'] = 2;
        $container['to'] = $project->client_id;
        $container['content'] = array("id" => $project->id, "name" => $project->name, "status" => $project->status);

        Notifications::CreateV2($container);
        // $forClientNotification = Notifications::CreateV2($container);

        $containerB = array();
        $containerB['project_id'] = $request->get('id');
        $containerB['type'] = 2;
        $containerB['to'] = $request->get('worker_id');
        $containerB['content'] = array("id" => $project->id, "name" => $project->name, "status" => $project->status);

        Notifications::CreateV2($containerB);
        // $forWorkerNotification = Notifications::CreateV2($container);

        return $project;
    }

    public function SaveWorkerContract (Request $request) {
        $project = Project::find($request->get('id'));
        $project->status = 4;
        $project->save();

        $contract = new Contract;
        $contract->cost = $request->get('contract')["cost"];
        $contract->days = $request->get('contract')["days"];
        $contract->worker_id = $request->get('contract')["worker_id"];
        $contract->client_id = $project->client_id;
        $contract->project_id = $project->id;
        $contract->worker_approved = 0;
        $contract->client_approved = 0;
        $contract->save();

        $container = array();
        $container['project_id'] = $request->get('id');
        $container['type'] = 3;
        $container['to'] = $project->client_id;
        $container['content'] = array("id" => $project->id, "name" => $project->name, "status" => $project->status);

        Notifications::CreateV2($container);
        // $forClientNotification = Notifications::CreateV2($container);

        $containerB = array();
        $containerB['project_id'] = $request->get('id');
        $containerB['type'] = 3;
        $containerB['to'] = $contract->worker_id;
        $containerB['content'] = array("id" => $project->id, "name" => $project->name, "status" => $project->status);

        Notifications::CreateV2($containerB);
        // $forWorkerNotification = Notifications::CreateV2($container);

        for ($i = 0; $i < count($request->get('deliverables')); $i++) {
            $deliverable = new Deliverable;
            $deliverable->project_id = $project->id;
            $deliverable->title =  $request->get('deliverables')[$i]["name"];
            $deliverable->status = 0;
            $deliverable->save();
        }

        for ($i = 0; $i < count($request->get('terms')); $i++) {
            $term = new Term;
            $term->project_id =  $project->id;
            $term->title =  $request->get('terms')[$i]["name"];
            $term->status = 0;
            $term->save();
        }
        return 'success';
    }

    public function IndexProfile () {
        return view('coordinator/profile/index');
    }
    public function SaveProfile (Request $request) {
        $fields = [];
        $user = User::find($request->user()->id);
        return redirect()->back;
    }
    public function SaveProfileImage (Request $request) {

    }
    public function UpdateProjectStatus (Request $request) {
        $projectId = HELPERDoubleDecrypt($request->get('id'));

        if (!is_numeric($projectId) || empty(Project::find($projectId))) {

            return json_encode( array("status" => 400));
        }

        $project = Project::find($projectId);
        $project->status = $request->get('status');
        $project->save();

        $container = array();
        $container['project_id'] = $projectId;
        $container['type'] = 2;
        $container['to'] = $project->client_id;
        $container['content'] = array("id" => $project->id, "name" => $project->name, "status" => $project->status);

        Notifications::CreateV2($container);

        return json_encode( array("status" => 200, "redirect" => $request->get('id'), "projectStatus" => HCoordinator::identifyStatus($request->get('status')) ));
    }

    public function SendMessage (Request $request) {
        HMessage::Create($request);
    }
    public function ReadMessage (Request $request) {
        HMessage::Seen($request);
    }

    public function ContractApprove (Request $request) {
        $contract = Contract::find($request->get('id'));
        if ($contract) {
            $contract->client_approved = 1;
            $contract->save();

            return $contract;
        }else {
            // not found
        }
    }

    public function ReadNotification (Request $request) {
        Notifications::MarkAsRead($request->get('notification_id'));
    }
    public function ViewApplicantProposal (Request $request) {
        $proposal = Proposal::where('worker_id', $request->get('id'))->with('worker', 'worker.skills.skill')->first();
        return $proposal;

    }
}
