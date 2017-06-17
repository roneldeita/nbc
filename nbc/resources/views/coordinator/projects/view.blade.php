@extends('layouts/coordinator/template')

@section('content')
<div class="container" id="project_details">
    <div class="row">
        <div class="col-md-12">
        <?php
        $getStatusData = HELPERIdentifyStatus($project->status);
        ?>
        <h2># {{$project->name}} <span class="label {{$getStatusData['class']}}" style="font-size:18px; font-weight: normal; margin: 10px; border-radius: 20px; padding:5px 25px;">{{$getStatusData['status']}}</span>
        <a href="" class="pull-right btn btn-info">Start Prescreening</a>
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
                                        ${{$project->budget}}<br>
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
                                                :class = "{ editing : termAndCondition == editedTermAndCondition}">
                                                <div class="view">
                                                    <a >
                                                    <label @click="EditTermAndCondition(termAndCondition)">@{{termAndCondition.name}}</label>
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
                                 <div class="panel panel-default">
                                    <div class="panel-heading">
                                        Client Details
                                    </div>
                                    <div class="panel-body">
                                        <div class="media">
                                            <div class="media-left">
                                                <img class="img-circle" src="http://placehold.it/350x150" width="70" height="70">
                                            </div>
                                            <div class="media-body">
                                                <h4>{{json_decode($project->client)->name}}</h4>
                                                <p>{{json_decode($project->client)->email}}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div id="applicant" class="tab-pane fade" style="padding: 20px 40px">
                        <div class="">
                            <div class="row">
                                <div class="chat_container">
                                    <div class="col-md-3">
                                        <div class="row">
                                            <div class="people_list">
                                                <ul class="list-unstyled">
                                                    <li class="left clearfix">
                                                        <span class="chat_img pull-left">
                                                            <img src="https://lh6.googleusercontent.com/-y-MY2satK-E/AAAAAAAAAAI/AAAAAAAAAJU/ER_hFddBheQ/photo.jpg" alt="User Avatar" class="img-circle">
                                                        </span>
                                                        <div class="chat_body clearfix">
                                                            <div class="information_section">
                                                                Foo Bar
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li class="left clearfix">
                                                        <span class="chat_img pull-left">
                                                            <img src="https://lh6.googleusercontent.com/-y-MY2satK-E/AAAAAAAAAAI/AAAAAAAAAJU/ER_hFddBheQ/photo.jpg" alt="User Avatar" class="img-circle">
                                                        </span>
                                                        <div class="chat_body clearfix">
                                                            <div class="information_section">
                                                                Foo Bar
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-9 message_section">
                                        <div class="row">
                                        <div class="chat_head">
                                            <div class="pull-left">
                                                Name
                                            </div>
                                        </div>
                                            <div class="chat_area">
                                                <ul class="list-unstyled">
                                                    <li class="left clearfix">
                                                        <span class="pull-left">
                                                            <img src="https://lh6.googleusercontent.com/-y-MY2satK-E/AAAAAAAAAAI/AAAAAAAAAJU/ER_hFddBheQ/photo.jpg" alt="User Avatar" class="img-circle">
                                                        </span>
                                                        <div class="chat_content clearfix">
                                                            <p>
                                                                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                                                tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                                                                quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                                                                consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                                                                cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                                                                proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                                                            </p>
                                                            <div class="chat_time pull-right">
                                                                09:40 PM
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li class="left clearfix admin_chat">
                                                        <span class="pull-right">
                                                            <img src="https://lh6.googleusercontent.com/-y-MY2satK-E/AAAAAAAAAAI/AAAAAAAAAJU/ER_hFddBheQ/photo.jpg" alt="User Avatar" class="img-circle">
                                                        </span>
                                                        <div class="chat_content clearfix">
                                                            <p>
                                                                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                                                tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                                                                quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                                                                consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                                                                cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                                                                proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                                                            </p>
                                                            <div class="chat_time pull-left">
                                                                09:41 PM
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="message_write">
                                                <textarea class="form-control" placeholder="type a message"></textarea>
                                                <div class="clearfix"></div>
                                                <div class="chat_bottom">
                                                    <a href="" class="pull-right btn btn-success">Send</a>
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

    <script src="{{asset('public/temp/vue.js')}}"></script>

    <script type="text/javascript">
    var varDeliverables = "{{$project->deliverables}}";
    var varTermsAndConditions = "{{$project->terms_condition}}";

    varDeliverables = JSON.parse(varDeliverables.replace(/&quot;/g,'"'));
    varTermsAndConditions = JSON.parse(varTermsAndConditions.replace(/&quot;/g,'"'));

        new Vue({
            el : '#project_details',
            data : {
                deliverables : varDeliverables,
                origDeliverables : varDeliverables,
                termsAndConditions : varTermsAndConditions,
                editedDeliverable : null,
                editedTermAndCondition : null,
                oldDeliverable : null,
                oldTermAndCondition : null,
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
    </script>
@endsection
