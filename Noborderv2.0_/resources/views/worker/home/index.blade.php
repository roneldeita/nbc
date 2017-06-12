@extends('layouts/worker/template')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
        	<h4>Projects</h4>
        	<div class="col-md-4">
				<div class="panel panel-info">
					<div class="panel-heading">
						<h1>{{count($contractProjects)}} <small>Contract Signing</small></h1>
						<a href="{{url('/worker/projects')}}">View Details <span class="pull-right fa fa-chevron-circle-right"></span></a>
					</div>
				</div>
        	</div>
        	<div class="col-md-4">
				<div class="panel panel-info">
					<div class="panel-heading">
						<h1>{{count($progressProjects)}} <small>In Progress</small></h1>
						<a href="{{url('/worker/projects')}}">View Details <span class="pull-right fa fa-chevron-circle-right"></span></a>
					</div>
				</div>
        	</div>
        	<div class="col-md-4">
				<div class="panel panel-info">
					<div class="panel-heading">
						<h1>0 <small>Finished</small></h1>
						<a href="{{url('/worker/projects')}}">View Details <span class="pull-right fa fa-chevron-circle-right"></span></a>
					</div>
				</div>
        	</div>
        </div>
        <div class="col-md-12">
			<h4>Ratings & Reviews</h4>
			<div class="panel panel-info text-center">
				<div class="panel-body">
					<h1>0/5 <span class="fa fa-star"></span></h1>
				</div>
			</div>
        </div>
    </div>
</div>
@endsection
