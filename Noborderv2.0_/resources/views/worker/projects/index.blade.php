@extends('layouts/worker/template')

@section('content')
@include('layouts/worker/include/easysteps')
<div class="container">

    <div class="row">
        <div class="col-md-12">
        <h1>My Projects
            <span class="pull-right">
                <a href="{{url('/worker/works')}}" class="btn btn-primary-nbc btn-md">
                    <i style="font-size: 18px;" class="pe-7s-gym pe-2x"></i>
                    <span style="font-size:20px;">Find Work</span>
                </a>
            </span>
        </h1><br>

            <div class="card">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#proposal">Proposal</a></li>
                    <li><a data-toggle="tab" href="#contract">Contract Signing</a></li>
                    <li><a data-toggle="tab" href="#progress">In Progress</a></li>
                    <li><a data-toggle="tab" href="#closed">Finished</a></li>
                </ul>

                <div class="tab-content" style="padding: 0">
                    <div id="proposal" class="tab-pane fade in active" style="padding: 0; min-height: 300px">
                        @if (count($proposalProjects) > 0)
                        <table class="table table-project">
                            <tbody>
                                <?php $i = 1;?>
                                @foreach ($proposalProjects as $project)
                                <tr>

                                    <td>
                                        <h4># <span class="project-name">{{$project->name}}</span></h4>
                                    </td>
                                    <td>
                                        <a href="{{url('/worker/projects/proposal/'.HELPERDoubleEncrypt($project->id))}}" class="btn btn-success btn-md">View Details</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                        <div style="width: 100%; height: 300px;" class="text-center">
                            <a href="{{url('/worker/works')}}" class="empty_sample">
                                <div style="width: 100%; height: 100%;">
                                    <div style="padding: 80px 20px 20px 20px;">
                                        <i class="i pe-7s-file pe-5x"></i>
                                        <h1>Submit proposal to projects!</h1>
                                    </div>
                                </div>
                            </a>
                        </div>
                        @endif
                    </div>


                    <div id="contract" class="tab-pane fade" style="padding: 0; min-height: 300px">
                        <table class="table table-project">
                            <tbody>
                                <?php $i = 1;?>
                                @foreach ($contractProjects as $project)
                                <tr>

                                    <td>
                                        <h4># <span class="project-name">{{$project->name}}</span></h4>
                                    </td>
                                    <td>
                                        <a href="{{url('/worker/contract_signing/'.HELPERDoubleEncrypt($project->contracts_id))}}" class="btn btn-success btn-md">View Details</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div id="progress" class="tab-pane fade" style="padding: 0; min-height: 300px">
                        <table class="table table-project">
                            <tbody>

                            </tbody>
                        </table>
                    </div>

                    <div id="closed" class="tab-pane fade" style="padding: 0; min-height: 300px">
                        <table class="table table-project">
                            <tbody>

                            </tbody>
                        </table>
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
</script>
@endsection