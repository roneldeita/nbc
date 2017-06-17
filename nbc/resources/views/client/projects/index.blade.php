@extends('layouts/client/template')

@section('styles')
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

@include('layouts/client/include/easysteps')
<div class="container">
    <div class="row">
        <div class="col-md-12">
        <h1>My Projects
            <span class="pull-right">
                <a href="{{url('/client/projects/create')}}" class="btn btn-primary-nbc btn-md">
                    <i style="font-size: 18px;" class="pe-7s-plus pe-2x"></i>
                    <span style="font-size:20px;">Create Project</span>
                </a>
            </span>
        </h1><br>

            <div class="card">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#draft">Draft</a></li>
                    <li><a data-toggle="tab" href="#published">Published</a></li>
                    <li><a data-toggle="tab" href="#prescreening">Pre-Screening</a></li>
                    <li><a data-toggle="tab" href="#contract">Contract Signin</a></li>
                    <li><a data-toggle="tab" href="#progress">In Progress</a></li>
                    <li><a data-toggle="tab" href="#closed">Finished</a></li>
                </ul>

                <div class="tab-content" style="padding: 0">
                    <div id="draft" class="tab-pane fade in active" style="padding: 0; min-height : 300px;">
                        @if (count($draftProjects) > 0)
                        <div class="input-group" style="width: 100%; padding:20px;">
                            <input type="text" class="form-control" placeholder="e.g. Project Name" id="filterDraft">
                            <span class="input-group-addon"><i class="pe-7s-search" style="font-size: 20px; font-weight: bold"></i></span>
                        </div>

                        <table class="table table-project footable" data-page-size="10" data-filter="#filterDraft">
                            <tbody>
                                <?php $i = 1;?>
                                @foreach ($draftProjects as $project)
                                <tr>

                                    <td>
                                        <h4># <span class="project-name">{{$project->name}}</span></h4>
                                    </td>
                                    <td>
                                        <a href="{{url('/client/projects/draft/'.HELPERDoubleEncrypt($project->id))}}" class="btn btn-secondary-nbc btn-md">
                                            <i class="pe-7s-info" style="font-size : 18px;"></i> Publish Now
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="7">
                                        <ul class="pagination pull-right"></ul>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                        @else
                            @include('client/projects/empty')
                        @endif
                    </div>


                    <div id="published" class="tab-pane fade" style="padding: 0; min-height : 300px;">
                        @if(count($publishedProjects) > 0)
                        <div class="input-group" style="width: 100%; padding:20px;">
                            <input type="text" class="form-control" placeholder="e.g. Project Name" id="filterPublished">
                            <span class="input-group-addon"><i class="pe-7s-search" style="font-size: 20px; font-weight: bold"></i></span>
                        </div>

                        <table class="table table-project footable" data-page-size="10" data-filter="#filterPublished">
                            <tbody>
                                <?php $i = 1;?>
                                @foreach ($publishedProjects as $project)
                                <tr>

                                    <td>
                                        <h4># <span class="project-name">{{$project->name}}</span></h4>
                                    </td>
                                    <td>
                                        <a href="{{url('/client/projects/published/'.HELPERDoubleEncrypt($project->id))}}" class="btn btn-secondary-nbc btn-md">
                                            <i class="pe-7s-info" style="font-size : 18px;"></i>
                                            View Details
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                            @include('client/projects/empty')
                        @endif
                    </div>

                    <div id="prescreening" class="tab-pane fade" style="padding: 0; min-height : 300px;">
                        @if (count($matchingProjects) > 0)
                        <div class="input-group" style="width: 100%; padding:20px;">
                            <input type="text" class="form-control" placeholder="e.g. Project Name" id="filterPrescreening">
                            <span class="input-group-addon"><i class="pe-7s-search" style="font-size: 20px; font-weight: bold"></i></span>
                        </div>

                        <table class="table table-project footable" data-page-size="10" data-filter="#filterPrescreening">
                            <tbody>
                                <?php $i = 1;?>
                                @foreach ($matchingProjects as $project)
                                <tr>
                                    <td>
                                        <h4># <span class="project-name">{{$project->name}}</span></h4>
                                    </td>
                                    <td>
                                        <a href="{{url('/client/projects/pre_screening/'.HELPERDoubleEncrypt($project->id))}}" class="btn btn-secondary-nbc btn-md">
                                            <i class="pe-7s-info" style="font-size : 18px;"></i>
                                            View Details
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                            @include('client/projects/empty')
                        @endif
                    </div>

                    <div id="contract" class="tab-pane fade" style="padding: 0; min-height : 300px;">
                        @if (count($contractProjects) > 0)
                        <div class="input-group" style="width: 100%; padding:20px;">
                            <input type="text" class="form-control" placeholder="e.g. Project Name" id="filterContract">
                            <span class="input-group-addon"><i class="pe-7s-search" style="font-size: 20px; font-weight: bold"></i></span>
                        </div>

                        <table class="table table-project footable" data-page-size="10" data-filter="#filterContract">
                            <tbody>
                                <?php $i = 1;?>
                                @foreach ($contractProjects as $project)
                                <tr>
                                    <td>
                                        <h4># <span class="project-name">{{$project->name}}</span></h4>
                                    </td>
                                    <td>
                                        <a href="{{url('/client/projects/contract_signing/'.HELPERDoubleEncrypt($project->id))}}" class="btn btn-secondary-nbc btn-md">
                                            <i class="pe-7s-info" style="font-size : 18px;"></i>
                                            View Details
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                            @include('client/projects/empty')
                        @endif
                    </div>

                    <div id="progress" class="tab-pane fade" style="padding: 0; min-height : 300px;">
                        @if (count($progressProjects) > 0)
                        <div class="input-group" style="width: 100%; padding:20px">
                                <input type="text" class="form-control" placeholder="e.g. Project Name">
                                <span class="input-group-addon"><i class="pe-7s-search" style="font-size: 20px; font-weight: bold"></i></span>
                        </div>
                        <table class="table table-project footable">
                            <tbody>
                                <?php $i = 1;?>
                                @foreach ($progressProjects as $project)
                                <tr>
                                    <td>
                                        <h4># <span class="project-name">{{$project->name}}</span></h4>
                                    </td>
                                    <td>
                                        <a href="{{url('/client/projects/in_progress/'.HELPERDoubleEncrypt($project->id))}}" class="btn btn-secondary-nbc btn-md">
                                            <i class="pe-7s-info" style="font-size : 18px;"></i>
                                            View Details
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                            @include('client/projects/empty')
                        @endif
                    </div>

                    <div id="closed" class="tab-pane fade" style="padding: 0; min-height : 300px;">
                        @if (count($closedProjects) > 0)
                        <div class="input-group" style="width: 100%; padding: 20px;">
                            <input type="text" class="form-control" placeholder="e.g. 400">
                            <span class="input-group-addon"><i class="pe-7s-search" style="font-size: 20px; font-weight: bold"></i></span>
                        </div>
                        <table class="table table-project footable">
                            <tbody>
                                <?php $i = 1;?>
                                @foreach ($closedProjects as $project)
                                <tr>

                                    <td>
                                        <h4># <span class="project-name">{{$project->name}}</span></h4>
                                    </td>
                                    <td>
                                        <a href="{{url('/client/projects/closed/'.HELPERDoubleEncrypt($project->id))}}" class="btn btn-secondary-nbc btn-md">
                                            <i class="pe-7s-info" style="font-size : 18px;"></i>
                                            View Details
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                            @include('client/projects/empty')
                        @endif
                    </div>

                </div>
                <!-- ./tab-content -->
            </div>
            <!-- ./card -->
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
$('.footable').footable();
$(document).ready(function() {
    if (location.hash != '') {
        $('.nav-tabs a[href="'+location.hash+'"]').tab('show');
    }
});

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
