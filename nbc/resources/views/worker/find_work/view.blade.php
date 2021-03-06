@extends('layouts/worker/template')
@section('content')
<div style="height: 200px; margin-top:-22px;">
	<img src="{{asset('public/images/default_background.jpg')}}"  class="img-responsive" style="height: 400px; width: 100%;">
</div>
<div class="container" id="proposal" style="margin-top:-100px">
	<?php
    	$budget = json_decode($project->budget_info);
	?>
	<input type="hidden" id="project_id" value="{{HELPERDoubleEncrypt($project->id)}}">
	<input type="hidden" id="p" value="{{$project}}">
	<input type="hidden" id="w" value="{{Auth::user()}}">

	<div class="row">
		<div class="col-md-12">

			<h2>
				<div class="project-img background-primary-nbc">
					{{$project->name[0]}}
				</div>
				<span style="color:#fff">{{$project->name}}</span>
			</h2>
		</div>
		<div class="col-md-8">
			<div class="panel panel-default">
				<div class="panel-body">
					<h4>Posted By</h4>
					<p>{{$project->client->name}}</p>
					<br>
					<h4>Budget</h4>
					<p>${{number_format($budget->budget, 2)}}</p>
					<br>
					<h4>Timeline</h4>
					<p>{{$project->timeline}}</p>
					<br>
					<h4>Project Description</h4>
					<p>{{$project->description}}</p>
					<br>
					<div class="row">
						<div class="col-md-6">
							<h4>Project Deliverables</h4>
							<ul>
								@foreach(json_decode($project->deliverables) as $deliverable)
								<li>
									{{$deliverable->name}}
								</li>
								@endforeach
							</ul>
						</div>
						<div class="col-md-6">
							<h4>Terms and Condition</h4>
							<ul>
								@foreach (json_decode($project->terms_condition) as $term)
									<li>
										{{$term->name}}
									</li>
								@endforeach
							</ul>
						</div>
					</div>
					<br>
					<h4>Project File Link</h4>
					<p>{{$project->link}}</p>
				</div>
			</div>
		</div>

		<div class="col-md-4">
			<div class="panel panel-default">
				<div class="panel-heading">
					Send Proposal
				</div>
				<div class="panel-body">
					<form method="POST" v-on:submit="OnSubmitForm">
						<h4>Estimated Completion
							<span v-if="!proposal.days" class="text-danger">*</span>
						</h4>
						<div class="input-group">
							<input v-model="proposal.days" type="number" class="form-control" placeholder="Enter number of days">
							<span class="input-group-addon">
								Days
							</span>
						</div>
						<br>

						<h4>Bid Amount
							<span v-if="!proposal.amount" class="text-danger">*</span>
						</h4>
						<div class="input-group">
							<span class="input-group-addon">
								$
							</span>
							<input v-model="proposal.amount" type="number" class="form-control"  placeholder="Enter amount" pattern= "[^.]">
							<span class="input-group-addon">
								.00
							</span>
						</div>
						<br>

						<h4>Proposal
						<span v-if="!proposal.message" class="text-danger">*</span>
						</h4>
						<textarea v-model="proposal.message" class="form-control" rows="5" placeholder="Message"></textarea>
						<br>

						<button v-if="!submitted" type="submit" class="btn btn-primary-nbc" style="width: 100%" v-bind="{disabled : errors}" >Send</button>
						<button v-cloak v-else type="button" class="btn btn-primary-nbc" style="width: 100%" disabled>
							Sending
							<i class="fa fa-circle-o-notch fa-spin"></i>
						</button>
					</form>
				</div>
			</div>
		</div>

	</div>
</div>
@endsection

@section('scripts')
    <script src="{{asset('public/temp/vue.js')}}"></script>
    <script src="{{asset('public/temp/vue-resource.min.js')}}"></script>
    <script type="text/javascript">
    	Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('value');

    	new Vue({
    		el : '#proposal',
    		data : {
    			submitted : false,
    			proposal : {project_id : $('#project_id').val(), days : '', amount : '', message : ''},
    		},
    		computed : {
    			errors : function () {
    				for (var key in this.proposal) {
    					if (!this.proposal[key]) {
    						return true;
    					}
    				}
    				return false;
    			}
    		},
    		methods : {
    			OnSubmitForm : function (e) {
    				e.preventDefault();
    				this.submitted = true;

    				this.$http.post('/worker/projects/proposal', this.proposal).then(response => {

                        if (response.data.status == "2000" || response.data.status == 2000) {
	                        toastr.success('Proposal Submitted  Successfully!');
							var dataToEmit = {
								project : JSON.parse($("#p").val()),
								worker : $("#w").val(),
								hPId : $("#project_id").val(),
								type : 11
							}
							socket.emit('new applicant', dataToEmit);

	                    	setTimeout(function() {
	                    		window.location = "/worker/projects";
	                    	}, TIME_INTERVAL);

                        } else {
                        	toastr.error('Theres a problem on your proposal!');
                        	this.submitted = false;
                        }


                    }, response => {
                    	toastr.error('Theres a problem on your proposal!');
                    });
    			}
    		}
    	});
    </script>
@endsection
