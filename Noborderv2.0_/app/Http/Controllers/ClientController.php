<?php

namespace App\Http\Controllers;

use Auth;
use Braintree_Transaction;
use DB;

use App\Contract;
use App\Deliverable;
use App\Project;
use App\Proposal;
use App\Rate;
use App\SkillCategory;
use App\User;
use App\DeliverableContent;
use App\DeliverableComment;

use Illuminate\Http\Request;
use Facades\App\Services\Notifications;
use Facades\App\Services\Users\HClient;
use Facades\App\Services\HMessage;


class ClientController extends Controller
{
    public function Index () {
        return view('client/home/index',HClient::projects());
    }

    //::PROJECT
        // -- GET
            public function IndexProject (Request $request) {
                return view('client/projects/index', HClient::projects());
            }

            public function CreateProject () {
                return view('client/projects/create')->with('skill_categories', SkillCategory::all());
            }

            public function CreatedProject ($hashedProjectId) {
                $projectId = HELPERDoubleDecrypt($hashedProjectId);
                if (!is_numeric($projectId) || empty(Project::find($projectId))) {
                    return view('errors/404');
                }
                return view('client/projects/created')->with('project', Project::find($projectId));
            }

            public function ViewProject ($status, $hashedProjectId, Request $request) {
                $projectId = HELPERDoubleDecrypt($hashedProjectId);

                if (!is_numeric($projectId)) {
                    return view('client/projects/invalid');
                }
                $project = Project::find($projectId);
                if (HClient::identifyStatus($project->status) != $status || $project->client_id != $request->user()->id) {
                    return view('client/projects/outdated')->with('project', $project);
                }

                return HClient::viewProject($project);


                // if (HClient::identifyStatus($project->status) == 'in_progress') {
                //     $projectWithContractDetails = Project::where('id', $projectId)->with('contract', 'contract.deliverables', 'contract.deliverables.comments', 'contract.deliverables.content', 'contract.deliverables.comments.by')->first();
                //     return view('client/projects/progress/view')->with('project', $projectWithContractDetails);
                // }
            }

        // -- POST
            public function SaveProject (Request $request) {
                $project = HClient::createProject($request);

                return json_encode(array("redirect" => HELPERDoubleEncrypt($project->id), "details" => $project, "client" => $project->client));
            }

            // TEMP
            public function PayProject (Request $request) {
                $projectId = HELPERDoubleDecrypt($request->get('id'));
                if (!is_numeric($projectId) || empty(Project::find($projectId))) {
                    return view('errors/404');
                }

                $project = Project::find($projectId);
                $project->status = 2;
                $project->save();

                Notifications::Create($project, 1);

                $result = Braintree_Transaction::sale(
                    [
                        'amount' => $request->get('amount'),
                        'paymentMethodNonce' => $request->get('nonce'),
                        'options' => [
                        'submitForSettlement' => True
                    ],
                    'customer' => [
                        'firstName' => Auth::user()->name,
                        'email' => Auth::user()->email
                    ]
                ]);

                // $message ="Hi, Thank you for posting your very important job.
                // We have already published your project to our qualified associates page and we are currently waiting for them
                // to propose on your job. You will be receiving notification as soon as associates submit proposal,
                // you can check their proposal on the applicant tab and message me after you choose your desired associate for this job.";
                $message = "Hi ".$request->user()->name."! Thank you for creating your project. It was already published to our qualified associate's page and we are currently waiting for them to propose for it. You will receive notifications as soon as the associates submit proposal.";

                HMessage::StaticMessage(array("projectId" => $project->id, "status" => $project->status, "message" => $message, "from" => User::find(1)->id));

                return json_encode(array("redirect" => HELPERDoubleEncrypt($project->id), "details" => $project, "client" => $project->client));
            }

            public function SaveRate (Request $request) {
                $rate = new Rate;
                $rate->worker_id = $request->get('worker_id');
                $rate->project_id = $request->get('project_id');
                $rate->rate = $request->get('rate');
                $rate->messae = $request->get('message');
                $rate->save();
            }
    //x::PROJECT


    public function IndexProfile () {
        return view('client/profile/index');
    }


    public function ViewApplicantProposal (Request $request) {
        $proposal = Proposal::where('worker_id', $request->get('id'))->with('worker', 'worker.skills.skill')->first();
        return $proposal;

    }

    public function ContractApprove (Request $request) {
        $contract = Contract::find($request->get('id'));
        if ($contract) {
            $contract->client_approved = 1;
            $contract->save();

            $container = array();
            $container['project_id'] = $contract->project_id;
            $container['type'] = 4;
            $container['to'] = $contract->worker_id;
            $container['content'] = array("id" => $contract->project_id, "name" => $contract->project->name, "by" => "client");

            Notifications::CreateV2($container);

            $containerB = array();
            $containerB['project_id'] = $contract->project_id;
            $containerB['type'] = 4;
            $containerB['to'] = $contract->project->coordinator_id;
            $containerB['content'] = array("id" => $contract->project_id, "name" => $contract->project->name, "by" => "client");

            Notifications::CreateV2($containerB);

            return $contract;
        }else {
            // not found
        }
    }

    public function SendMessage (Request $request) {
        HMessage::Create($request);
    }
    public function ReadMessage (Request $request) {
        HMessage::Seen($request);
    }

    public function testing (Request $request) {
        //return HMessage::All();
        return $request->ip();
    }

    public function SaveDeliverableContent (Request $request) {
        // if ($request->get('')) {
        //
        // }
    }

    public function SaveDeliverableComment (Request $request) {
        $comment = new DeliverableComment;
        $comment->user_id = $request->user()->id;
        $comment->deliverable_id = $request->get('deliverable_id');
        $comment->content = $request->get('content');
        $comment->save();

    }

    public function SaveDeliverableStatus (Request $request) {
        $deliverable = Deliverable::find($request->get('deliverable_id'));
        $deliverable->status = 1;
        $deliverable->save();
    }

    public function ReadNotification (Request $request) {
        Notifications::MarkAsRead($request->get('notification_id'));
    }

}
