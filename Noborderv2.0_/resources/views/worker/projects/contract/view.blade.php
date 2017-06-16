@extends('layouts/worker/template')

@section('content')
<div class="container" id="project">
    <input type="hidden" id="p" value="{{$contract->project}}">
    <input type="hidden" id="c" value="{{$contract}}">
    <input type="hidden" id="pId" value="{{$contract->project->id}}">
    <input type="hidden" id="hPId" value="{{HELPERDoubleEncrypt($contract->project->id)}}">
    <input type="hidden" id="ca" value="{{strtotime($contract->project->created_at)}}">
    <div class="row">
        <div class="col-md-12">
            <h2>
                # {{$contract->project->name}}
                <span class="label label-primary" style="font-size:18px; font-weight: normal; margin: 10px; border-radius: 20px; padding:5px 25px;">Contract Signing</span>
            </h2>
            <br>
            <div class="panel panel-default">
                <div class="panel-body">
                    <h3 class="text-center">Contract Agreement</h3>
                    <div class="text-center" style="width: 700px; margin : auto; font-size : 18px">
                        <p >This CONTRACT OF AGREEMENT, is entered into made effective this {{date('d', strtotime($contract->created_at))}} day of {{date('F, y', strtotime($contract->created_at))}},
                            by and between <strong>{{$contract->client->name}} (client)</strong> and <strong>{{Auth::user()->name}} (<i>associate</i>)</strong>. NOW THEREFORE, in consideration of the foregoing, and the mutual promises
                            herein contained, the parties hereby agree to the <strong>{{$contract->project->name}}</strong> requirements as follows:
                        </p>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Deliverables</strong></p>
                            <ul>
                                @foreach($contract->deliverables as $deliverable)
                                <li>{{$deliverable->title}}</li>
                                @endforeach
                            </ul>
                            <p><strong>Terms & Condition</strong></p>
                            <ul>
                                @foreach($contract->terms as $term)
                                <li>{{$term->title}}</li>
                                @endforeach
                            </ul>
                            <p><strong>Total Amount</strong></p>
                            <p>$ {{$contract->cost}}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>No. of days :</strong></p>
                            <p>{{$contract->days}}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center">
                @if (!$contract->worker_approved)
                <button v-if="!approve" @click="Approve()" class="btn btn-lg btn-success">Approve <i class="fa fa-check"></i></button>
                <button v-if="approve" class="btn btn-lg btn-success" disabled>Approve <i class="fa fa-circle-o-notch fa-spin"></i></button>
                @else
                <p>You Already Approve</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{asset('js/core/worker/contract/index.js')}}"></script>
@endsection
