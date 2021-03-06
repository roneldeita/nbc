@extends('layouts/worker/template')

@section('styles')
<link rel="stylesheet" href="{{asset('css/footable.core.css')}}">
<style media="screen">
 .hidden{
   display: none;
 }
 #steps{
   height: 0px;
   overflow: hidden;
   }
</style>
@endsection


@section('content')

@include('layouts/worker/include/easysteps')
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<h1>Find Work</h1><br>
		</div>
		@if (count($projects) > 0)
		<!-- <div class="col-md-3">
			<h4>Skill Categories</h4>
		</div> -->

		<div class="col-md-12">
			<div class="input-group">
				<input type="text" class="form-control" name="" placeholder="Search Job">
				<span class="input-group-addon">
					<i class="pe-7s-search" style="font-size: 1.5em"></i>
				</span>
			</div>
			<br>
		</div>

		<!-- <div class="col-md-3">
			<div style="max-height:500px; width: 100%; border: 1px solid rgb(221, 221, 221); background-color: #fff ">
				<ul class="category_list">
					<li>
						<a href="">Web Development</a>
					</li>
					<li>
						<a href="">Web Development</a>
					</li>
					<li>
						<a href="">Web Development</a>
					</li>
					<li>
						<a href="">Web Development</a>
					</li>
					<li>
						<a href="">Web Development</a>
					</li>
					<li>
						<a href="">Web Development</a>
					</li><li>
						<a href="">Web Development</a>
					</li>
				</ul>
			</div>
		</div> -->

		<div class="col-md-12">
			<div class="card">
				<table class="table table-project footable" data-page-size="5" data-filter="#filterProjects">
					<tbody>
						@foreach ($projects as $project)
                        <?php
                            $budget = json_decode($project->budget_info);
                        ?>
						<tr>
	                        <td>
	                            <h4><span class="project-name" style="padding: 0">{{$project->name}}</span></h4>
	                            <p>{{$project->skillCategory->name}}</p>
	                            <p>{{str_limit($project->description,100)}}</p>
	                            <p>Budget : $ {{$budget->budget}}</p>
	                        </td>
	                        <td>
	                            <a href="{{url('/worker/works/'.HELPERDoubleEncrypt($project->id))}}" class="btn btn-secondary-nbc btn-md"><i style="font-size: 15px; font-weight:bold;margin-right: 5px" class="pe-7s-note2 pe-2x"></i>View Details</a>
	                        </td>
	                    </tr>
						@endforeach
					</tbody>
					<tfoot>
						<tr>
							<td colspan="7">
								<div style="margin-left: 20px; padding: 0">
									 <ul class="pagination pull-right nbc-pagination"></ul>
								</div>
							</td>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>

		@else
		<div class="col-md-12">
			<h1>No Available Projects Yet...</h1>
		</div>
		@endif
	</div>
</div>
@endsection


@section('scripts')
<script type="text/javascript">
	$('.footable').footable();

	var stepState = localStorage.getItem('step');

	$(function(){
	    $('#steps').toggleClass(localStorage.getItem('step'));
	  step(localStorage.getItem('step'));
	});


	$('a.toggle').click(function(){

	  $('#steps').toggleClass('hidden');
	  if($('#steps').hasClass('hidden')){
	    localStorage.step = 'hidden';
	  }else{
	    localStorage.step = '';
	  }
	  step(localStorage.getItem('step'));
	});

	function step(stepState){
	  if(stepState){
	    $('.toggle').removeClass('pe-7s-angle-up').addClass('pe-7s-angle-down');
	  }else{
	    $('.toggle').addClass('pe-7s-angle-up').removeClass('pe-7s-angle-down');
	    $('#steps').css({'height':'auto', 'overflow':'visible'});
	  }
	}
</script>
@endsection
