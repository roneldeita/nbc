@extends('layouts/client/template')
@section('styles')
<link type="text/css" href="{{asset('public/css/toggle-switch.css')}}" rel="stylesheet">
@endsection
@section('content')
<div class="container" id="project">
    <input type="hidden" id="hPId" value="{{HELPERDoubleEncrypt($project->id)}}">
    <input type="hidden" id="pId" value="{{$project->id}}">
    <input type="hidden" id="p" value="{{$project}}">
    <input type="hidden" id="deliverables" value="{{$project->contract->deliverables}}">
    <input type="hidden" id="aName" value="{{Auth::user()->name}}">
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
                        @{{selectedDeliverable.title}} <label class="label" v-bind:class="selectedDeliverable.status == 1 ? 'label-success' : 'label-default'" >@{{selectedDeliverable.status == 1 ? 'Completed' : 'Incomplete'}}</label>
                        <span v-if="selectedDeliverable.content != null">
                            <button v-if="selectedDeliverable.status == 0"  type="button" @click="CheckDeliverable(selectedDeliverable.id)" class="pull-right btn btn-xs" v-bind:class="selectedDeliverable.status == 1 ? 'btn-success' : 'btn-danger' ">
                                Change Status
                            </button>
                        </span>
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
                            <strong> @{{comment.by.name}} @{{comment.user_id == user_id ? '(You)' : '' }} </strong> :  @{{comment.content}}
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
                    <!-- <button type="button" class="btn btn-info" style="width:100%">
                        <span>Rate Worker</span>
                    </button> -->
        		</div>
        		<div class="panel-body">
        			<div class="btn-group-vertical" style="width:100%;">
                        <button v-cloak v-for="deliverable in deliverables" @click='SelectDeliverable(deliverable)'  type="button" class="btn" v-bind:class ="deliverable.status == 0 ? 'btn-default' : 'btn-success'" style="text-align:left" name="button">
                            <span v-cloak>@{{deliverable.title}}</span>
                        </button>
                        <button type="button" class="btn btn-default" style="text-align:left" v-bind:disabled="!CanAccessFinalFile">
                            <span>Final Project Link</span>
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
                    <p >This CONTRACT OF AGREEMENT, is entered into made effective this <strong>{{date('d', strtotime($project->contract->created_at))}} day of {{date('F, y', strtotime($project->contract->created_at))}} </strong>
                        by and between <strong> {{Auth::user()->name}} (<i>client</i>) </strong> and {{$project->contract->worker->name}} (associate). NOW THEREFORE, in consideration of the foregoing, and the mutual promises
                        herein contained, the parties hereby agree to the <strong>{{$project->name}}</strong> requirements as follows:
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

<div class="modal fade" tabindex="-1" role="dialog" id="rating">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="rating_form">
                <input type="hidden" name="worker_id" value="{{$project->contract->worker->id}}">
                <input type="hidden" name="project_id" value="{{$project->id}}">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Rate the Associate</h4>
                </div>
                <div class="modal-body">
                    <label>Rating</label><br>
                    <fieldset class="rating">
                        <input type="radio" id="star5" name="rating" value="5" /><label class = "full" for="star5" title="Awesome - 5 stars"></label>
                        <input type="radio" id="star4" name="rating" value="4" /><label class = "full" for="star4" title="Pretty good - 4 stars"></label>
                        <input type="radio" id="star3" name="rating" value="3" /><label class = "full" for="star3" title="Meh - 3 stars"></label>
                        <input type="radio" id="star2" name="rating" value="2" /><label class = "full" for="star2" title="Kinda bad - 2 stars"></label>
                        <input type="radio" id="star1" name="rating" value="1" /><label class = "full" for="star1" title="Sucks big time - 1 star"></label>
                    </fieldset>
                    <br><br>
                    <label>Comments</label><br>
                    <textarea rows="8" class="form-control" name="comment"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="rating_btn">Save changes <i class="fa fa-circle-o-notch fa-spin hidden" id="rating_loading"></i></button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="warning">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Update deliverable</h4>
            </div>
            <div class="modal-body">
                <p>Are you sure to update the deliverable</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="update_btn">Save changes</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@endsection


@section('scripts')
<script type="text/javascript">
    Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('value');
</script>
<script src="{{asset('public/js/core/general/message.js')}}"></script>
<script src="{{asset('public/js/core/client/progress/index.js')}}"></script>
<script type="text/javascript">
Message.Seen({role : "client", projectId : pId});

$("#rating_form").on("submit", function (e) {
    e.preventDefault();

    console.log($(this).serialize());

    $("#rating_btn").attr("disabled", "disabled");
    $("#rating_loading").removeClass("hidden");
});

$("#update_btn").on("click", function () {
    progress.UpdateDeliverable();
});
</script>
@endsection
