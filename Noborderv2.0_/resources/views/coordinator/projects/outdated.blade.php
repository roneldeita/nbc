@extends('layouts/coordinator/template')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h3>The current status of this project is now <a href="{{url('/coordinator/projects/'.HIS($project->status).'/'.HELPERDoubleEncrypt($project->id) )}}"> {{HELPERIdentifyStatus($project->status)['status']}}</a></h3>
        </div>
    </div>
</div>
@endsection
