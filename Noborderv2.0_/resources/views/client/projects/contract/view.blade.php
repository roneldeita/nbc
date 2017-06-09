@extends('layouts/client/template')

@section('content')
<div class="container" id="contract">
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
<script type="text/javascript" src="{{asset('js/tempV.js')}}"></script>

<script type="text/javascript">
vm.SeenNotification({role : "client", status : 3});
vm.SeenNotification({role : "client", status : 4});
    var v = new Vue({
        el : '#contract',
        data : {
            approve : false
        },
        methods : {
            Approve : function () {
                this.$http.post("{{url('/client/contract/approve')}}", {id : "{{$project->contract->id}}"}).then(response => {
                    var dataToEmit = {
                        contract_id : "{{$project->contract->id}}",
                        receiver : "{{$project->contract->worker->id}}",
                        project : "{{$project}}",
                        projectName : "{{$project->name}}",
                        update : response.data.worker_approved,
                        by : "client"
                    }
                    socket.emit('contract approve', dataToEmit);
                    toastr.info('You approved the contract!');
                    setTimeout(function() {
                        location.reload();
                        //window.location = '/client/projects/in_progress/{{HELPERDoubleEncrypt($project->id)}}';
                    }, 5000);
                    this.approve = true;
                }, response => {

                });
            }
        }
    });
    socket.on('project development', function (details) {
        if (details.clientId == "{{Auth::user()->id}}") {
            toastr.success('Your project is now on development!', ''+details.projectName);
            addNotification('<li><a href=""><strong>Project Status Updated </strong>: '+ details.projectName +'</a></li>');
             setTimeout(function() {
                //location.reload();
                window.location = '/client/projects/in_progress/{{HELPERDoubleEncrypt($project->id)}}';
            }, 5000);
        }
    });

</script>
@endsection
