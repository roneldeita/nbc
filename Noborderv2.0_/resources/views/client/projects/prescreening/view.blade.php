@extends('layouts/client/template')
@section('content')
<div class="container" id="project_details">
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
                    <li><a data-toggle="tab" href="#applicant">Applicant</a></li>
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
                                    <div class="panel-footer">
                                        <a href="" style="color:#000"> <i style="font-size: 15px; font-weight:bold;margin-right: 5px" class="pe-7s-note2 pe-2x"></i> View Contract</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        Client Documents
                                    </div>
                                    <div class="panel-body">

                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        Terms And Conditions
                                    </div>
                                    <div class="panel-body">
                                        <ul class="termAndCondition" style="padding-left: 15px">
                                            <li v-for="termAndCondition in termsAndConditions"
                                                ng-cloak
                                                :class = "{ editing : termAndCondition == editedTermAndCondition}">
                                                <div class="view">
                                                    <a>
                                                    <label @click="EditTermAndCondition(termAndCondition)" >@{{termAndCondition.name}}</label>
                                                    </a>
                                                </div>
                                                <input class="edit" type="text"
                                                  v-model="termAndCondition.name"
                                                  v-termandcondition-focus="termAndCondition == editedTermAndCondition"
                                                  @blur = "DoneEditTermAndCondition(termAndCondition)"
                                                  @keyup.enter = "DoneEditTermAndCondition(termAndCondition)"
                                                  >
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="panel-footer">

                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        Deliverables
                                    </div>
                                    <div class="panel-body">
                                        <ul class="deliverable" style="padding-left: 15px">
                                            <li v-for="deliverable in deliverables"
                                                ng-cloak
                                                :class = "{ editing : deliverable == editedDeliverable}">
                                                <div class="view">
                                                    <a>
                                                    <label @click="EditDeliverable(deliverable)">@{{deliverable.name}}</label>
                                                    </a>
                                                </div>
                                                <input class="edit" type="text"
                                                  v-model="deliverable.name"
                                                  v-deliverable-focus="deliverable == editedDeliverable"
                                                  @blur = "DoneEditDeliverable(deliverable)"
                                                  @keyup.enter = "DoneEditDeliverable(deliverable)"
                                                  @keyup.esc = "CancelEditDeliverable(deliverable)"
                                                  >
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="panel-footer">
                                        <div class="text-right">
                                            <a @click="UndoEditDeliverables()" class="btn btn-default btn-xs">Undo</a>
                                            <a href="" class="btn btn-success btn-xs">Save</a>
                                        </div>
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

                                        </ul>
                                    @endslot
                                    @slot('footer')
                                        <textarea class="form-control" placeholder="type a message" id="message"></textarea>
                                        <div class="clearfix"></div>
                                        <div class="chat_bottom">
                                            <button type="button" class="pull-right btn btn-success" id="send">Send</button>
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
                                            <div style="width: 100%; height : 300px; overflow-y : auto; border:1px solid #000">
                                                <ul class="list-unstyled">
                                                    <li v-for="applicant in applicants" style="border-bottom : 1px solid #000">
                                                        <a @click='ShowApplicantProposal(applicant.id)' style="padding : 12px; display : block; ">@{{applicant.name}}</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="row">
                                            <div v-if="showApplicantProposal">
                                                <div style="width: 100%; height : 300px; overflow-y : auto; border:1px solid #000; border-left:none">
                                                    <div style="padding-left: 15px; padding-right : 15px">
                                                        <h4>Proposal Details</h4>
                                                        <p><strong>Days : </strong> @{{applicantProposal.days}} Days</p>
                                                        <p><strong>Amount : </strong> $ @{{applicantProposal.amount}}</p>
                                                        <p><strong>Message : </strong> @{{applicantProposal.message}}</p>
                                                        <br>
                                                        <h4>Worker Details</h4>
                                                        <p><strong>Name : </strong> @{{applicantProposal.worker.name}}</p>
                                                        <p><strong>Skill : </strong> @{{applicantProposal.worker.skills[0].category.name}}</p>

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
    <!-- <script src="https://unpkg.com/vue/dist/vue.js"></script> -->

    <script src="{{asset('temp/vue.js')}}"></script>
    <script src="{{asset('temp/vue-resource.min.js')}}"></script>

    <script type="text/javascript">

    var varDeliverables = "{{$project->deliverables}}";
    var varTermsAndConditions = "{{$project->terms_condition}}";
    var varApplicants = "{{$applicants}}";

    varDeliverables = JSON.parse(varDeliverables.replace(/&quot;/g,'"'));
    varTermsAndConditions = JSON.parse(varTermsAndConditions.replace(/&quot;/g,'"'));
    varApplicants = JSON.parse(varApplicants.replace(/&quot;/g,'"'));

    Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('value');
        var v = new Vue({
            el : '#project_details',
            data : {
                deliverables : varDeliverables,
                origDeliverables : varDeliverables,
                termsAndConditions : varTermsAndConditions,
                editedDeliverable : null,
                editedTermAndCondition : null,
                oldDeliverable : null,
                oldTermAndCondition : null,
                showApplicantProposal : false,
                applicantProposal : null,
                applicants : varApplicants
            },
            methods : {
                RemoveDeliverable : function (deliverable) {
                    this.deliverables.splice(this.deliverables.indexOf(deliverable), 1);
                },

                EditDeliverable : function (deliverable) {
                    this.oldDeliverable = deliverable.name;
                    this.editedDeliverable = deliverable;
                },

                EditTermAndCondition : function (termAndCondition) {
                    this.oldTermAndCondition = termAndCondition.name;
                    this.editedTermAndCondition = termAndCondition;
                },

                DoneEditDeliverable : function (deliverable) {
                    this.editedDeliverable = null;
                    deliverable.name = deliverable.name.trim();
                    if (!deliverable.name) {
                        this.RemoveDeliverable(deliverable);
                    }
                },
                DoneEditTermAndCondition : function (termAndCondition) {
                    this.editedTermAndCondition = null;
                    termAndCondition.name = termAndCondition.name.trim();
                    if (!termAndCondition.name) {
                        this.RemoveTermAndCondition(termAndCondition);
                    }
                },
                CancelEditDeliverable : function (deliverable) {
                    this.editedDeliverable = null;
                    deliverable.name = this.oldDeliverable;
                },
                UndoEditDeliverables : function () {
                    //this.deliverables = this.origDeliverables;
                    console.log(varDeliverables);
                },
                UpdateProjectStatus : function (project_id, status) {
                    this.$http.post("{{url('/coordinator/projects/status/update')}}", {id : project_id, status : status}).then(response => {
                        if (response.data.status == 200) {
                            location.reload();
                        }
                    }, response => {

                    });
                    //console.log({project_id : project_id, status : status});
                },
                ShowApplicantProposal : function (id) {

                    this.$http.post("{{url('/client/applicant_proposal/view')}}", {id : id}).then(response => {
                        this.showApplicantProposal = true;
                        this.applicantProposal = null;
                        this.applicantProposal = response.data;
                        console.log(response.data);
                    }, response => {

                    });
                }
            },
            directives : {
                'deliverable-focus' : function (el, value) {
                    if (value) {
                        el.focus();
                    }
                },
                'termandcondition-focus' : function (el, value) {
                    if (value) {
                        el.focus();
                    }
                }
            }
        });
        $('#message').keydown(function (e) {
            var key = e.which;
            if(key == 13) {
              e.preventDefault();
              if (/\S/.test($('#message').val())) {
                  var dataToEmit = {
                      projectName : "{{$project->name}}",
                      projectId : "{{$project->id}}",
                      receiver : "{{$project->coordinator->id}}",
                      status : "{{$project->status}}",
                      message : $('#message').val()
                  };
                socket.emit('new message', dataToEmit);
                $('#message_container').append('<li class="left clearfix admin_chat"><div class="chat_content clearfix"><p>'+$('#message').val()+'</p></div></li>');
                $('#message').val('');
                $('#message_parent').animate({scrollTop : $('#message_parent').prop('scrollHeight')});
               }
            }
        });
        $('#send').on('click', function () {
            if (/\S/.test($('#message').val())) {
                var dataToEmit = {
                    projectName : "{{$project->name}}",
                    projectId : "{{$project->id}}",
                    receiver : "{{$project->coordinator->id}}",
                    status : "{{$project->status}}",
                    message : $('#message').val()
                };
                socket.emit('new message', dataToEmit);
                $('#message_container').append('<li class="left clearfix admin_chat"><div class="chat_content clearfix"><p>'+$('#message').val()+'</p></div></li>');
                $('#message').val('');
                $('#message_parent').animate({scrollTop : $('#message_parent').prop('scrollHeight')});
            }
        });

        socket.on('new message', function (details) {
            if ((details.receiver == "{{Auth::user()->id}}" && details.projectId == "{{$project->id}}") && details.status == "{{$project->status}}") {
                $('#message_container').append('<li class="left clearfix "><div class="chat_content clearfix"><p>'+details.message+'</p></div></li>');
                $('#message_parent').animate({scrollTop : $('#message_parent').prop('scrollHeight')});
            } else if (details.receiver == "{{Auth::user()->id}}") {
                toastr.info('You have new message!', ''+details.projectName);
                addMessage('<li><a href=""> '+ details.projectName +'</a></li>');
            }
        });

        socket.on('new contract', function (details) {
            if (details.projectId == "{{$project->id}}" && details.clientId == "{{Auth::user()->id}}") {
                toastr.success('Youre Project Will Procceed to Contract Signing!');
                setTimeout(function() {
                    window.location = '/client/projects/contract_signing/'+"{{HELPERDoubleEncrypt($project->id)}}";
                }, 5000);
            } else if (details.clientId == "{{Auth::user()->id}}") {
                toastr.info('You have new contract signing!', ''+details.projectName);
                addNotification('<li><a href=""><strong>New Contract </strong>: '+ details.projectName +'</a></li>');
            }
        });

    </script>
@endsection
