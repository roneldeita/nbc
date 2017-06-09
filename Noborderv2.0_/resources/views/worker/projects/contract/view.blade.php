@extends('layouts/worker/template')

@section('content')
<div class="container" id="contract">
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
                            by and between {{$contract->client->name}} (client) and {{Auth::user()->name}} (associate). NOW THEREFORE, in consideration of the foregoing, and the mutual promises
                            herein contained, the parties hereby agree to the Kill Sleepy requirements as follows:
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
<script src="{{asset('temp/vue.js')}}"></script>
<script src="{{asset('temp/vue-resource.min.js')}}"></script>
<script type="text/javascript">
    Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('value');
</script>
<script type="text/javascript" src="{{asset('js/tempV.js')}}"></script>
<script type="text/javascript">
    vm.SeenNotification({role : "worker", status : 3});
    vm.SeenNotification({role : "worker", status : 4});
    var v = new Vue({
        el : '#contract',
        data : {
            approve : false
        },
        methods : {
            Approve : function () {
                this.$http.post("{{url('/worker/contract/approve')}}", {id : "{{$contract->id}}"}).then(response => {
                    var dataToEmit = {
                        contract_id : "{{$contract->id}}",
                        receiver : "{{$contract->client->id}}",
                        project : "{{$contract->project}}",
                        projectName : "{{$contract->project->name}}",
                        update : response.data.client_approved,
                        by : "worker"
                    }
                    socket.emit('contract approve', dataToEmit);
                    toastr.info('You approved the contract!');
                    setTimeout(function() {
                        location.reload();
                    }, 5000);
                    this.approve = true;
                }, response => {

                });
            }
        }
    });

    socket.on('project development', function (details) {
        if (details.workerId == "{{Auth::user()->id}}") {
            toastr.success('Your have new project assigned!', ''+details.projectName);
            addNotification('<li><a href=""><strong>Project Development </strong>: '+ details.projectName +'</a></li>');
            setTimeout(function() {

            }, 5000);
            this.approve = true;
        }
    });
    // socket.on('contract approve', function (details) {
    //     if (details.contract_id == "{{$contract->id}}" && details.by == "client") {
    //         toastr.info('Client approved to contract signing!');
    //     }
    // })
</script>

@endsection
