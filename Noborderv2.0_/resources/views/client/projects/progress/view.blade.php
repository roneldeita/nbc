@extends('layouts/client/template')
@section('styles')
<link type="text/css" href="{{asset('css/toggle-switch.css')}}" rel="stylesheet">
@endsection
@section('content')
<div class="container" id="project">
    <input type="hidden" id="hPId" value="{{HELPERDoubleEncrypt($project->id)}}">
    <input type="hidden" id="pId" value="{{$project->id}}">
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
        </div>

        <div class="col-md-8">
            <div v-if="selectedDeliverable != null" v-cloak>
            	<div class="panel panel-default" >
            		<div class="panel-heading">
                        @{{selectedDeliverable.title}} <span class="label" v-bind:class="selectedDeliverable.status == 1 ? 'label-success' : 'label-default' ">
                             @{{selectedDeliverable.status == 1 ? 'Completed' : 'Incomplete'}}
                        </span>

                        <label class="switch pull-right" v-if="selectedDeliverable.content != null">
                            <input type="checkbox" @click="CheckDeliverable(selectedDeliverable.id)" v-bind:disabled="selectedDeliverable.status == 1" v-bind:checked="selectedDeliverable.status">
                            <div class="slider round"></div>
                        </label>

            		</div>
            		<div class="panel-body">
                        <div class="" v-if="selectedDeliverable.content == null">
                            <h3>No Update Yet...</h3>
                        </div>
                        <div class="" v-else>
                             @{{selectedDeliverable.content.content}}
                        </div>

            		</div>
            	</div>
                <br>

                <div v-if="selectedDeliverable.content != null">
                <h3>Comments</h3>
                    <div v-if="selectedDeliverable.comments.length > 0">
                        <div class="well" v-for="comment in selectedDeliverable.comments">
                            <strong> @{{comment.by.name}} @{{comment.user_id == id ? '(You)' : '' }} </strong> :  @{{comment.content}}
                        </div>
                    </div>
                <hr>

                    <textarea name="name" class="form-control" rows="4" v-model="comment"></textarea><br>
                    <button v-if="!commented" type="button" class="btn btn-secondary-nbc  pull-right" v-bind:disabled="!comment" @click="SaveComment()">
                        <i class="pe-7s-check" style="font-size : 18px;"></i>
                        Post
                    </button>
                    <button v-if="commented" type="button" class="btn btn-secondary-nbc  pull-right" disabled>
                        <i class="pe-7s-check" style="font-size : 18px;"></i>
                        Post
                    </button>
                </div>

                <br>
            </div>
        </div>

        <div class="col-md-4">
        	<div class="panel panel-default">
        		<div class="panel-heading">
        			Deliverables <br><br>
                    <div class="progress" v-cloak>
                        <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;" v-bind:style = "{width : DeliverablePercentage + '%'}">
                            @{{DeliverablePercentage}}%
                        </div>
                    </div>
        		</div>
        		<div class="panel-body">
        			<div class="btn-group-vertical" aria-label="..." style="width:100%;">
                        <button v-cloak v-for="deliverable in deliverables" @click='SelectDeliverable(deliverable)'  type="button" class="btn" v-bind:class ="deliverable.status == 0 ? 'btn-default' : 'btn-success'" style="text-align:left" name="button">
                            <span v-cloak>@{{deliverable.title}}</span>
                        </button>
        			</div>
        		</div>
        	</div>
            <div class="panel panel-default">
        		<div class="panel-heading">
        			Project Description
                    <span class="pull-right">
                        <a href="#project_body" data-toggle="collapse">
                            <i class="pe-7s-angle-up" style="font-size : 24px; font-weight:bold; color : #000"></i>
                        </a>
                    </span>
        		</div>
        		<div id="project_body" class="panel-body panel-collapse collapse"style="max-height:300px; overflow-y:auto">
                    {{$project->description}}
        		</div>
        	</div>

            <div class="panel panel-default">
        		<div class="panel-heading">
        			Contract Details
                    <span class="pull-right">
                        <a href="#contract_body" data-toggle="collapse">
                            <i class="pe-7s-angle-up" style="font-size : 24px; font-weight:bold; color : #000"></i>
                        </a>
                    </span>
        		</div>
        		<div id="contract_body" class="panel-body panel-collapse collapse" style="max-height:300px; overflow-y:auto">
                    <p >This CONTRACT OF AGREEMENT, is entered into made effective this {{date('d', strtotime($project->contract->created_at))}} day of {{date('F, y', strtotime($project->contract->created_at))}},
                        by and between {{Auth::user()->name}} (client) and {{$project->contract->worker->name }} (associate). NOW THEREFORE, in consideration of the foregoing, and the mutual promises
                        herein contained, the parties hereby agree to the Kill Sleepy requirements as follows:
                    </p>

                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Deliverables</strong></p>
                            <ul>
                                @foreach($project->contract->deliverables as $deliverable)
                                <li>{{$deliverable->title}}</li>
                                @endforeach
                            </ul>
                            <p><strong>Terms & Condition</strong></p>
                            <ul>
                                @foreach($project->contract->terms as $term)
                                <li>{{$term->title}}</li>
                                @endforeach
                            </ul>
                            <p><strong>Total Amount</strong></p>
                            <p>$ {{$project->contract->cost}}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>No. of days :</strong></p>
                            <p>{{$project->contract->days}}</p>
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
<script src="{{asset('js/core/client/progress/index.js')}}"></script>
<script type="text/javascript">
Message.Seen({role : "client", projectId : pId});
Notification.Seen({role : "client", projectId : pId});
var deliverables = "{{$project->contract->deliverables}}";
deliverables = deliverables == "" ? null : JSON.parse(deliverables.replace(/&quot;/g,'"'));
progress.deliverables = deliverables;
</script>
@endsection
