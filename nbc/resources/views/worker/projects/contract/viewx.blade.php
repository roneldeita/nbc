@extends('layouts/worker/template')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2># {{$contract->project->name}} <span class="label label-primary" style="font-size:18px; font-weight: normal; margin: 10px; border-radius: 20px; padding:5px 25px;">Contract Signing</span>
            <br><br>
            <div class="panel panel-default">
                <div class="panel-body">
                    <h3>Contract Agreement</h3>
                </div>
            </div>
            <div class="text-center">
                @if (!$contract->worker_approved)
                <a  class="btn btn-lg btn-success">Approve <i class="fa fa-check"></i></a>
                @else
                <p>You Already Approve</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">

</script>
@endsection
