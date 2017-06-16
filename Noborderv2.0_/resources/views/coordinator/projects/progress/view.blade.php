@extends('layouts/coordinator/template')
@section('styles')
<link rel="stylesheet" type="text/css" href="{{asset('/css/toggle-switch.css')}}">
@endsection()
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
        </div>

        <div class="col-md-8">
        	<div class="panel panel-default">
        		<div class="panel-heading">
        			Deliverable
					<label class="switch pull-right">
						<input type="checkbox">
						<div class="slider round"></div>
					</label>
        		</div>
        		<div class="panel-body">
        			<div id="summernote">What's your update?</div>
        		</div>
        	</div>
        </div>

        <div class="col-md-4">
        	<div class="panel panel-default">
        		<div class="panel-heading">
        			Deliverables
        		</div>
        		<div class="panel-body">
        			<div class="btn-group-vertical" aria-label="..." style="width:100%;">
                        @foreach($project->contract->deliverables as $deliverable)
                            <button type="button" class="btn {{$deliverable->status == 1 ? 'btn-success' : 'btn-default'}} " style="text-align:left" name="button">{{$deliverable->title}}</button>
                        @endforeach
        			</div>
        		</div>
        	</div>
        </div>

    </div>
</div>
@endsection


@section('scripts')
<script src="{{asset('js/core/general/message.js')}}"></script>
<script type="text/javascript">
$(function(){
	$('#summernote').summernote({
		height:100
	});
});

Message.Seen({role : "coordinator", projectId : pId});
</script>
@endsection
