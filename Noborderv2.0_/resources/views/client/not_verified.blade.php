@extends('layouts/client/template')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"></div>

                <div class="panel-body">
                    Thank You {{Auth::user()->name}}. You're one step closer on starting! Kindly check your
e-mail to verify your account.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
