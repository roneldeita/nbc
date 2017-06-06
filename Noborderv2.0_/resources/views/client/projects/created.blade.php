@extends('layouts/client/template')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12" style="padding-top:50px">
        <!-- <h1>{{$project->name}}</h1><br> -->

        <div class="panel panel-defaut" >
            <div class="panel-body text-center" style="padding: 50px;">
                <i class="pe-7s-check pe-4x"></i>
                <h2 style="margin-top: 5px; padding-top: 5px">SUCCESS</h2>
                <p style="width: 600px; margin: auto; font-size: 16px">
                Your new project has been created. Before we publish this, please check the payment form.
    Once its done it will be publish for the associates to apply and we'll recommend you with top associates also.
                </p><br>
                <a href="{{url('/client/projects/draft/'.HELPERDoubleEncrypt($project->id))}}" class="btn btn-primary-nbc"><span style="font-size: 18px">PUBLISH YOUR PROJECT NOW</span> <i class="pe-7s-paper-plane pe-2x"></i></a>
            </div>
        </div>

        </div>
    </div>
</div>
@endsection
