@extends('layouts/client/template')

@section('styles')
<style media="screen">
  .bordered{
    border: 1px solid #dddddd;
  }
  .applicant-list{
    list-style: none;
  }
  .applicant-list li{
    margin-left: -40px;
    padding: 5px;
  }
  .applicant-list a{
    cursor: pointer;
  }
  .applicant-list .active{
    background-color: #999999;
    color: #ffffff;
  }
  .applicant-list li:not(.active):hover{
    background-color: lightgrey;
    color: #ffffff;
  }
  .applicant-list img{
    margin-right: -20px;
  }
  .applicant-list p{
    line-height: 0px;
  }
  .fa-star{
    color: gold;
  }
  .skills li{
    margin-bottom: 3px;
    margin-right: 3px;
  }
  .well{
    padding: 15px 5px 0px;
  }
  .row{
    padding: 0px;
  }
</style>
@endsection

@section('content')

<div class="container" id="project">
    <input type="hidden" id="pId" value="{{$project->id}}">
    <input type="hidden" id="hPId" value="{{HELPERDoubleEncrypt($project->id)}}">
    <input type="hidden" id="p" value="{{$project}}">
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
                                        ${{$budget->budget}}<br><br>
                                        <label>File Link :</label><br>
                                        ${{$project->link}}<br>
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
                                <div class="">
                                  <div class="col-md-4">
                                      <ul class="bordered applicant-list">
                                        <li v-for="applicant in applicants">
                                          <a @click='ShowApplicantProposal(applicant.id)'>
                                            <div class="row">
                                              <div class="col-md-3">
                                                <img class="img img-circle img-responsive" src="{{asset('images/default_avatar.png')}}">
                                              </div>
                                              <div class="col-md-9">
                                                <h4>@{{applicant.name}}</h4>
                                                <p>
                                                  <span class="fa fa-star"></span>
                                                  <span class="fa fa-star"></span>
                                                  <span class="fa fa-star"></span>
                                                  <span class="fa fa-star"></span>
                                                  <span class="fa fa-star"></span>
                                                </p>
                                              </div>
                                            </div>
                                          </a>
                                        </li>
                                      </ul>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="row">
                                            <div v-if="showApplicantProposal">
                                              <div class="row">
                                                <div class="col-md-3 text-center">
                                                  <img class="img img-circle img-responsive" src="{{asset('images/default_avatar.png')}}">
                                                  <h3>
                                                    <span class="fa fa-star"></span>
                                                    <span class="fa fa-star"></span>
                                                    <span class="fa fa-star"></span>
                                                    <span class="fa fa-star"></span>
                                                    <span class="fa fa-star"></span>
                                                  </h3>
                                                </div>
                                                <div class="col-md-9">
                                                  <h2>@{{applicantProposal.worker.name}}</h2>
                                                  <p>@{{applicantProposal.worker.overview}}</p>
                                                  <div class="well">
                                                    <ul class="skills">
                                                      <li class="btn btn-success btn-sm" v-for ="workerSkill in applicantProposal.worker.skills">
                                                          @{{workerSkill.skill.name}}
                                                      </li>
                                                    </ul>
                                                  </div>
                                                </div>
                                              </div>
                                              <div class="col-md-12">
                                                <hr>
                                                <h4>Proposal Details</h4>
                                              </div>
                                              <div class="col-md-3 text-center">
                                                <div class="panel panel-info">
                                                  <div class="panel-heading">
                                                    Completion
                                                  </div>
                                                  <div class="panel-body">
                                                    <h1>@{{applicantProposal.days}}<small>days</small></h1>
                                                  </div>
                                                </div>
                                              </div>
                                              <div class="col-md-3 text-center">
                                                <div class="panel panel-info">
                                                  <div class="panel-heading">
                                                    Bid Amount
                                                  </div>
                                                  <div class="panel-body">
                                                    <h1>@{{applicantProposal.amount}}</h1>
                                                  </div>
                                                </div>
                                              </div>
                                              <div class="col-md-6 text-center">
                                                <div class="panel panel-info">
                                                  <div class="panel-heading">
                                                    Proposal
                                                  </div>
                                                  <div class="panel-body">
                                                    <p>@{{applicantProposal.message}}</p>
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
