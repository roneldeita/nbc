@extends('layouts/client/template')

@section('content')
<div class="container">
    <div class="row">
       	<div class="col-md-12">
	       	<h4>Projects</h4>
		</div>
		<div class="col-md-4">
            <div class="panel panel-info">
    			<div class="panel-heading">
					<h1>{{count($draftProjects)}} <small>Drafts</small></h1>
					<a href="{{url('/client/projects')}}">View Details <span class="pull-right fa fa-chevron-circle-right"></span></a>
  				</div>
    		</div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-info">
    			<div class="panel-heading">
					<h1>{{count($publishedProjects)}} <small>Published</small></h1>
					<a href="{{url('/client/projects')}}">View Details <span class="pull-right fa fa-chevron-circle-right"></span></a>
  				</div>
    		</div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-info">
    			<div class="panel-heading">
					<h1>{{count($matchingProjects)}} <small>Pre-Screening</small></h1>
					<a href="{{url('/client/projects')}}">View Details <span class="pull-right fa fa-chevron-circle-right"></span></a>
  				</div>
    		</div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-info">
    			<div class="panel-heading">
					<h1>{{count($contractProjects)}} <small>Contract Signing</small></h1>
					<a href="{{url('/client/projects')}}">View Details <span class="pull-right fa fa-chevron-circle-right"></span></a>
  				</div>
    		</div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-info">
    			<div class="panel-heading">
					<h1>{{count($progressProjects)}} <small>In Progress</small></h1>
					<a href="{{url('/client/projects')}}">View Details <span class="pull-right fa fa-chevron-circle-right"></span></a>
  				</div>
    		</div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-info">
    			<div class="panel-heading">
					<h1>{{count($closedProjects)}}<small>Finished</small></h1>
					<a href="{{url('/client/projects')}}">View Details <span class="pull-right fa fa-chevron-circle-right"></span></a>
  				</div>
    		</div>
        </div>


    </div>
</div>
@endsection
