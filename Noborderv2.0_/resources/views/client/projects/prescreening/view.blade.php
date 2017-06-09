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
            <div class="panel panel-default">
                <div class="panel-body ">
                    <h3>Hi ! Your project is now currently on "Pre-Screening Stage" where in your Coordinator will pick an associate to work for this project.</h3>
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
        Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('value');
    </script>
    <script type="text/javascript" src="{{asset('js/tempV.js')}}"></script>

    <script type="text/javascript">
    vm.SeenNotification({role : "client", status : 2});

    var varDeliverables = "{{$project->deliverables}}";
    var varTermsAndConditions = "{{$project->terms_condition}}";
    var varApplicants = "{{$applicants}}";

    varDeliverables = JSON.parse(varDeliverables.replace(/&quot;/g,'"'));
    varTermsAndConditions = JSON.parse(varTermsAndConditions.replace(/&quot;/g,'"'));
    varApplicants = JSON.parse(varApplicants.replace(/&quot;/g,'"'));
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
