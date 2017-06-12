@extends('layouts/client/template')

@section('content')
<div class="container" id="project">
    <input type="hidden" id="p" value="{{$project}}">
    <input type="hidden" id="pId" value="{{$project->id}}">
    <input type="hidden" id="pName" value="{{$project->name}}">
    <input type="hidden" id="hPId" value="{{HELPERDoubleEncrypt($project->id)}}">
    <input type="hidden" id="pCId" value="{{$project->contract->id}}">
    <input type="hidden" id="receiver" value="{{$project->contract->worker_id}}">
    <div class="row">
        <div class="col-md-12">
            <h2>
                # {{$project->name}}
                <span class="label label-primary" style="font-size:18px; font-weight: normal; margin: 10px; border-radius: 20px; padding:5px 25px;">Contract Signing</span>
            </h2>
            <br>
            <div class="panel panel-default">
                <div class="panel-body">
                    <h3 class="text-center">Contract Agreement</h3>
                    <div class="text-center" style="width: 700px; margin : auto; font-size : 18px">
                        <p >This CONTRACT OF AGREEMENT, is entered into made effective this {{date('d', strtotime($project->contract->created_at))}} day of {{date('F, y', strtotime($project->contract->created_at))}},
                            by and between {{Auth::user()->name}} (client) and {{$project->contract->worker->name}} (associate). NOW THEREFORE, in consideration of the foregoing, and the mutual promises
                            herein contained, the parties hereby agree to the Kill Sleepy requirements as follows:
                        </p>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Deliverables</strong></p>
                            <ul>
                                @foreach($project->contract->deliverables as $deliverable)
                                <li>{{$deliverable->title}}</li>
                                @endforeach
                            </ul>
                            <p><strong>Terms & Condition</strong></p>
                            <ul>
                                @foreach($project->contract->terms as $term)
                                <li>{{$term->title}}</li>
                                @endforeach
                            </ul>
                            <p><strong>Total Amount</strong></p>
                            <p>$ {{$project->contract->cost}}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>No. of days :</strong></p>
                            <p>{{$project->contract->days}}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center">
                @if (!$project->contract->client_approved)
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
<script src="{{asset('temp/vue.js')}}"></script>
<script src="{{asset('temp/vue-resource.min.js')}}"></script>

<script type="text/javascript">
    Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('value');
</script>
<script src="{{asset('js/core/general/message.js')}}"></script>
<script src="{{asset('js/core/client/contract/index.js')}}"></script>
<script src="{{asset('js/core/general/notification.js')}}"></script>


<script type="text/javascript">
Message.Seen({role : "client", projectId : pId});
Notification.Seen({role : "client", projectId : pId});
</script>
@endsection
