@extends('layouts/coordinator/template')
@section('styles')
<style type="text/css">
    .panel-success {
        background-color: #4CAF50;
        border-color: #388E3C;
        color :#fff;
    }
</style>
@endsection
@section('content')
<div class="container" id="project">
    <input type="hidden" id="hPId" value="{{HELPERDoubleEncrypt($project->id)}}">
    <input type="hidden" id="pId" value="{{$project->id}}">
    <input type="hidden" id="p" value="{{$project}}">
    <input type="hidden" id="c" value="{{$project->contract}}">
    <input type="hidden" id="pCId" value="{{$project->contract->id}}">

    <div class="row">
        <div class="col-md-12">
        <?php
            $getStatusData = HELPERIdentifyStatus($project->status);
            $budget = json_decode($project->budget_info);
        ?>
        <h2># {{$project->name}} <span class="label {{$getStatusData['class']}}" style="font-size:18px; font-weight: normal; margin: 10px; border-radius: 20px; padding:5px 25px;">{{$getStatusData['status']}}</span>


            <button v-if="!updateProject" v-bind="{disabled : canUpdate}" @click="UpdateProjectStatus()" type="button" class="pull-right btn btn-info" >Start Development</button>
            <button v-if="updateProject" disabled type="button" class="pull-right btn btn-info" >Start Development <i class="fa fa-circle-o-notch fa-spin "></i></button>
        </h2>
        <br>
            <div class="card">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#overview">Overview</a></li>
                </ul>


                <div class="tab-content">
                    <div id="overview" class="tab-pane fade in active" style="padding: 20px;">
                        <div class="row">
                            <div class="col-md-6">
                                <div id="worker_approved" class="panel {{$project->contract->worker_approved == 1 ? 'panel-success' : 'panel-default'}}">
                                    <div class="panel-body">
                                        @if ($project->contract->worker_approved == 1)
                                            <h3 ><i class="pe pe-7s-check" style="font-weight: bold; font-size: 35px"></i> Associate Approved the Contract</h3>
                                        @else
                                            <h3 id="worker_approved_text"><i class="pe pe-7s-clock" style="font-weight: bold; font-size: 35px"></i> Waiting for Associate Response</h3>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div id="client_approved" class="panel {{$project->contract->client_approved == 1 ? 'panel-success' : 'panel-default'}}">
                                    <div class="panel-body">
                                        @if ($project->contract->client_approved == 1)
                                            <h3 ><i class="pe pe-7s-check" style="font-weight: bold; font-size: 35px"></i> Client Approved the Contract</h3>
                                        @else
                                            <h3 id="client_approved_text"><i class="pe pe-7s-clock" style="font-weight: bold; font-size: 35px"></i> Waiting for Client Response</h3>
                                    @endif
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
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
                                        <label>File Link :</label><br>
                                        {{$project->link}}<br>
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
    Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('value');
</script>
<script src="{{asset('js/core/general/message.js')}}"></script>
<script src="{{asset('js/core/general/notification.js')}}"></script>
<script src="{{asset('js/core/coordinator/contract/index.js')}}"></script>
<script type="text/javascript">
contract.worker_approved = {{$project->contract->worker_approved}};
contract.client_approved = {{$project->contract->client_approved}};

Message.Seen({role : "coordinator", projectId : pId});
Notification.Seen({role : "coordinator", projectId : pId});

</script>
@endsection
