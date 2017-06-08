@extends('layouts/coordinator/template')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Projects</h1><br>

            <div class="card">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#published">Published</a></li>
                    <li><a data-toggle="tab" href="#prescreening">Pre-Screening</a></li>
                    <li><a data-toggle="tab" href="#contract">Contract Signin</a></li>
                    <li><a data-toggle="tab" href="#progress">In Progress</a></li>
                    <li><a data-toggle="tab" href="#closed">Finished</a></li>
                </ul>

                <div class="tab-content" style="padding: 0">
                    <div id="published" class="tab-pane fade in active" style="padding: 0">

                        <div class="input-group" style="width: 100%; padding:20px;">
                            <input type="text" class="form-control" placeholder="e.g. 400" id="filterPublished">
                            <span class="input-group-addon"><i class="pe-7s-search" style="font-size: 20px; font-weight: bold"></i></span>
                        </div>

                        <table class="table table-project footable" data-page-size="10" data-filter="#filterTable" id="publishedTable">
                            <tbody>
                                <?php $i = 1;?>
                                @foreach ($publishedProjects as $project)
                                <tr>

                                    <td>
                                        <h4># <span class="project-name">{{$project->name}}</span></h4>
                                    </td>
                                    <td>
                                        <a href="{{url('/coordinator/projects/published/'.HELPERDoubleEncrypt($project->id))}}" class="btn btn-secondary-nbc btn-md"><i style="font-size: 15px; font-weight:bold;margin-right: 5px" class="pe-7s-note2 pe-2x"></i>View Details</a>
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

                    </div>

                    <div id="prescreening" class="tab-pane" style="padding: 0">

                        <div class="input-group" style="width: 100%; padding:20px;">
                            <input type="text" class="form-control" placeholder="e.g. 400" id="filterPrescreening">
                            <span class="input-group-addon"><i class="pe-7s-search" style="font-size: 20px; font-weight: bold"></i></span>
                        </div>

                        <table class="table table-project footable" data-page-size="10" data-filter="#filterPrescreening">
                            <tbody>
                                <?php $i = 1;?>
                                @foreach ($prescreeningProjects as $project)
                                <tr>

                                    <td>
                                        <h4># <span class="project-name">{{$project->name}}</span></h4>
                                    </td>
                                    <td>
                                        <a href="{{url('/coordinator/projects/pre_screening/'.HELPERDoubleEncrypt($project->id))}}" class="btn btn-secondary-nbc btn-md"><i style="font-size: 15px; font-weight:bold;margin-right: 5px" class="pe-7s-note2 pe-2x"></i>View Details</a>
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

                    </div>

                    <div id="contract" class="tab-pane" style="padding: 0">

                        <div class="input-group" style="width: 100%; padding:20px;">
                            <input type="text" class="form-control" placeholder="e.g. 400" id="filterContract">
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
                                        <a href="{{url('/coordinator/projects/contract_signing/'.HELPERDoubleEncrypt($project->id))}}" class="btn btn-secondary-nbc btn-md"><i style="font-size: 15px; font-weight:bold;margin-right: 5px" class="pe-7s-note2 pe-2x"></i>View Details</a>
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

                    </div>

                    <div id="progress" class="tab-pane fade" style="padding: 0">

                        <div class="input-group" style="width: 100%; padding:20px;">
                            <input type="text" class="form-control" placeholder="e.g. 400" id="filterProgress">
                            <span class="input-group-addon"><i class="pe-7s-search" style="font-size: 20px; font-weight: bold"></i></span>
                        </div>

                        <table class="table table-project footable" data-page-size="10" data-filter="#filterProgess">
                            <tbody>
                                <?php $i = 1;?>
                                @foreach ($progressProjects as $project)
                                <tr>

                                    <td>
                                        <h4># <span class="project-name">{{$project->name}}</span></h4>
                                    </td>
                                    <td>
                                        <a href="{{url('/coordinator/projects/in_progress/'.HELPERDoubleEncrypt($project->id))}}" class="btn btn-secondary-nbc btn-md"><i style="font-size: 15px; font-weight:bold;margin-right: 5px" class="pe-7s-note2 pe-2x"></i>View Details</a>
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
                    </div>

                    <div id="closed" class="tab-pane fade" style="padding: 0">

                        <div class="input-group" style="width: 100%; padding:20px;">
                            <input type="text" class="form-control" placeholder="e.g. 400" id="filterClosed">
                            <span class="input-group-addon"><i class="pe-7s-search" style="font-size: 20px; font-weight: bold"></i></span>
                        </div>

                        <table class="table table-project footable" data-page-size="10" data-filter="#filterClosed">
                            <tbody>
                                <?php $i = 1;?>
                                @foreach ($closedProjects as $project)
                                <tr>

                                    <td>
                                        <h4># <span class="project-name">{{$project->name}}</span></h4>
                                    </td>
                                    <td>
                                        <a href="{{url('/coordinator/projects/closed/'.HELPERDoubleEncrypt($project->id))}}" class="btn btn-secondary-nbc btn-md"><i style="font-size: 15px; font-weight:bold;margin-right: 5px" class="pe-7s-note2 pe-2x"></i>View Details</a>
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

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection


@section('scripts')
<script type="text/javascript">
    socket.on('new project published', function (data) {
        var client = data.client;
        var details = data.details;
        var hashed = data.hashed;
        if (details.coordinator_id == {{Auth::user()->id}}) {
            var id = $('#publishedTable tbody tr').length + 1;
            var url = window.location+'/'+hashed;
            $('#publishedTable tbody').append('<tr><td>'+id+'</td><td>'+details.name+'</td><td>'+client.name+'</td><td>--</td><td><a href="'+url+'" class="btn btn-secondary-nbc btn-sm"><i style="font-size: 15px; font-weight:bold;margin-right: 5px" class="pe-7s-note2 pe-2x"></i> View </a></td></tr>');
        }
    });

    $('.footable').footable();
</script>
@endsection
