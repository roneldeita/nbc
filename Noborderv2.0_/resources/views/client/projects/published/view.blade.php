@extends('layouts/client/template')
@section('content')

<div class="container" id="project">
    <input type="hidden" id="pId" value="{{$project->id}}">
    <input type="hidden" id="pName" value="{{$project->name}}">
    <input type="hidden" id="receiver" value="{{$project->coordinator->id}}">
    <div class="row">
        <div class="col-md-12">
        <?php
            $getStatusData = HELPERIdentifyStatus($project->status);
            $budget = json_decode($project->budget_info);
        ?>
        <h2># {{$project->name}} <span class="label {{$getStatusData['class']}}" style="font-size:18px; font-weight: normal; margin: 10px; border-radius: 20px; padding:5px 25px;">{{$getStatusData['status']}}</span>
        </h2>
        <br>
            <div class="card">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#overview">Overview</a></li>
                    <li><a data-toggle="tab" href="#applicant">Applicant <i class="badge" v-cloak>@{{applicants == null ? '0' : applicants.length }}</i></a></li>
                </ul>


                <div class="tab-content">
                    <div id="overview" class="tab-pane fade in active" style="padding: 20px;">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        Project Details
                                    </div>
                                    <div class="panel-body">
                                        <label>Name :</label><br>
                                        {{$project->name}}<br><br>
                                        <label>Category :</label><br>
                                        {{HELPERIdentifyCategory($project->skill_category_id)}}<br><br>
                                        <label>Description :</label><br>
                                        {{str_limit($project->description, 100)}} <a href="">Read More</a><br><br>
                                        <label>Cost :</label><br>
                                        ${{$budget->budget}}<br>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">

                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        Terms And Conditions
                                    </div>
                                    <div class="panel-body">
                                        <ul class="termAndCondition" style="padding-left: 15px">
                                            @foreach (json_decode($project->terms_condition) as $term)
                                                <li>
                                                    {{$term->name}}
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        Deliverables
                                    </div>
                                    <div class="panel-body">
                                        <ul class="deliverable" style="padding-left: 15px">
                                            @foreach (json_decode($project->deliverables) as $deliverable)
                                                <li>
                                                    {{$deliverable->name}}
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">

                                @component('layouts/general/chat_area')
                                    @slot('name')
                                        NoBorderClub Coordinator
                                    @endslot
                                    @slot('messages')
                                        <ul class="list-unstyled" id="message_container" style="margin-top: 5px">
                                            @foreach ($project->messages as $message)
                                                @if ($message->type == $project->status)
                                                    <li class="left clearfix {{$message->from == Auth::user()->id ? 'admin_chat' : ''}}">
                                                        <div class="chat_content clearfix">
                                                            <p>{{$message->message}}</p>
                                                        </div>
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    @endslot
                                    @slot('footer')
                                        <textarea class="form-control" placeholder="type a message" v-model="message" @keydown="$event.keyCode == 13 ? SendMessage($event) : false"></textarea>
                                        <div class="clearfix"></div>
                                        <div class="chat_bottom">
                                            <button type="button" class="pull-right btn btn-primary-nbc" @click="SendMessage($event)" v-bind:disabled="emptyMessage">Send</button>
                                        </div>
                                    @endslot
                                @endcomponent

                            </div>
                        </div>
                    </div>


                    <div id="applicant" class="tab-pane fade" style="padding: 20px 40px">
                        <div class="">
                            <div class="row">
                                <div class="chat_container">
                                    <div class="col-md-3">
                                        <div class="row">
                                            <div style="width: 100%; height : 300px; overflow-y : auto; border:1px solid #BDBDBD">
                                                <ul class="list-unstyled">
                                                    <li v-for="applicant in applicants" style="border-bottom : 1px solid #BDBDBD">
                                                        <a @click='ShowApplicantProposal(applicant.id)' style="padding : 12px; display : block; " class="applicants">@{{applicant.name}}</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="row">
                                            <div v-if="showApplicantProposal">
                                                <div style="width: 100%; height : 300px; overflow-y : auto; border:1px solid #BDBDBD; border-left:none">
                                                    <div style="padding-left: 15px; padding-right : 15px">
                                                        <h4>Proposal Details</h4>
                                                        <p><strong>Days : </strong> @{{applicantProposal.days}} Days</p>
                                                        <p><strong>Amount : </strong> $ @{{applicantProposal.amount}}</p>
                                                        <p><strong>Message : </strong> @{{applicantProposal.message}}</p>
                                                        <br>
                                                        <h4>Worker Details</h4>
                                                        <p><strong>Name : </strong> @{{applicantProposal.worker.name}}</p>
                                                        <p><strong>Skills : </strong> </p>
                                                        <ul>
                                                            <li v-for =" workerSkill in applicantProposal.worker.skills">
                                                                @{{workerSkill.skill.name}}
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>


@endsection


@section('scripts')
<script src="{{asset('temp/vue.js')}}"></script>
<script src="{{asset('temp/vue-resource.min.js')}}"></script>
<script type="text/javascript">
    Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('value');
</script>
<script src="{{asset('js/core/general/message.js')}}"></script>
<script src="{{asset('js/core/general/notification.js')}}"></script>
<script src="{{asset('js/core/client/published/index.js')}}"></script>
<script type="text/javascript">

$('#message_parent').animate({scrollTop : $('#message_parent').prop('scrollHeight')});

var varApplicants = "{{count($applicants) > 0 ? $applicants : null}}";
varApplicants = varApplicants == "" ? null : JSON.parse(varApplicants.replace(/&quot;/g,'"'));
published.applicants = varApplicants;

Message.Seen({role : "client", projectId : pId});
Notification.Seen({role : "client", projectId : pId});
</script>
@endsection
