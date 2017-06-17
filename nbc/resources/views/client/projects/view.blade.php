@extends('layouts/client/template')
@section('content')
<div class="container">
    <?php
        $budget = json_decode($project->budget_info);
    ?>
    <div class="row">
        <div class="col-md-12">
        @if ($project->status == 1)
        <div class="panel panel-defaut">
        <div class="text-center">
            <h2>PUBLISH YOUR PROJECT</h2>
        </div>
            <div class="panel-body">
                <div class="panel panel-default" style="max-width: 500px; margin : auto">
                    <div class="panel-body text-center">
                        <h3>{{$project->name}}</h3>
                        <p style="max-width: 400px; margin:auto">
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                            tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                            quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                            consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                            cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                            proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                        </p>
                        <h3>PROJECT COST : $ {{$budget->budget}}</h3>
                    </div>
                    <div class="panel-footer text-center">
                        <h3 >PUBLISH NOW</h3>
                        <div style="padding:20px;" class="payment_btn">
                            <a href="" class="btn btn-default btn-md">PAY USING STRIPE</a>
                            <a href="" class="btn btn-default btn-md">PAY USING BITCOIN</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @else
        @endif
        </div>
    </div>
</div>
@endsection
