@extends('layouts/client/template')

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tour/0.11.0/css/bootstrap-tour-standalone.min.css">
<style media="screen">
  .navbar-nav li a#projectsMainMenu,
  .navbar-nav li a#notificationsMainMenu,
  .navbar-nav li a#messagesMainMenu{
    background-color: #001f31 !important;
  }
</style>
@endsection

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
					<a href="{{url('/client/projects#draft')}}">View Details <span class="pull-right fa fa-chevron-circle-right"></span></a>
  				</div>
    		</div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-info">
    			<div class="panel-heading">
					<h1>{{count($publishedProjects)}} <small>Published</small></h1>
					<a href="{{url('/client/projects#published')}}">View Details <span class="pull-right fa fa-chevron-circle-right"></span></a>
  				</div>
    		</div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-info">
    			<div class="panel-heading">
					<h1>{{count($matchingProjects)}} <small>Pre-Screening</small></h1>
					<a href="{{url('/client/projects#prescreening')}}">View Details <span class="pull-right fa fa-chevron-circle-right"></span></a>
  				</div>
    		</div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-info">
    			<div class="panel-heading">
					<h1>{{count($contractProjects)}} <small>Contract Signing</small></h1>
					<a href="{{url('/client/projects#contract')}}">View Details <span class="pull-right fa fa-chevron-circle-right"></span></a>
  				</div>
    		</div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-info">
    			<div class="panel-heading">
					<h1>{{count($progressProjects)}} <small>In Progress</small></h1>
					<a href="{{url('/client/projects#progress')}}">View Details <span class="pull-right fa fa-chevron-circle-right"></span></a>
  				</div>
    		</div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-info">
    			<div class="panel-heading">
					<h1>{{count($closedProjects)}}<small>Finished</small></h1>
					<a href="{{url('/client/projects#closed')}}">View Details <span class="pull-right fa fa-chevron-circle-right"></span></a>
  				</div>
    		</div>
        </div>


    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tour/0.11.0/js/bootstrap-tour.min.js"></script>
<script type="text/javascript">
  // Instance the tour
  var tour = new Tour({
  storage: false,
  debug: true,
  backdrop: true,
  smartPlacement: true,
  steps: [
  {
    element: "#projectsMainMenu",
    title: "(1/3) Navigation",
    content: "You can always view all your projects using this link."
  },
  {
    element: "#notificationsMainMenu",
    title: "(2/3) Navigation",
    content: "All your notifications goes here."
  },
  {
    element: "#messagesMainMenu",
    title: "(3/3) Navigation",
    content: "All your messages goes here."
  }
],
template: "<div class='popover tour'>"+
    "<div class='arrow'></div>"+
    "<h3 class='popover-title'></h3>"+
    "<div class='popover-content'></div>"+
    "<div class='popover-navigation'>"+
        "<button class='btn btn-sm btn-default' data-role='prev'>« Prev</button>"+
        "<span data-role='separator'></span>"+
        "<button class='btn btn-sm btn-info' data-role='next'>Next »</button>"+
        "<a class='btn btn-sm' data-role='end'>Skip</a>"+
    "</div>"+

  "</div>",
});

  // Initialize the tour
  tour.init();

  // Start the tour
  tour.start();
</script>
@endsection
