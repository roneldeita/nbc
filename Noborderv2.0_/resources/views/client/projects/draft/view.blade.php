@extends('layouts/client/template')
@section('content')
<div class="container" id="project">
    <input type="hidden" id="pId" value="{{$project->id}}">
    <input type="hidden" id="pName" value="{{$project->name}}">
    <input type="hidden" id="receiver" value="{{$project->coordinator->id}}"> 
    <?php
        $budget = json_decode($project->budget_info);
    ?>
    <div class="row">
        <div class="col-md-12">
            <h2 >PUBLISH YOUR PROJECT</h2>
            <br>
        </div>
        <div class="col-md-5">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Payment
                </div>
                <div class="panel-body">
                    <div id="paymentSuccess" class="alert alert-success hidden" role="alert">
                        <strong>Payment Success!</strong> Congratulations your project is now published! Redirecting to your project dashboard <i class="fa fa-circle-o-notch fa-spin"></i>
                    </div>

                    <form id="checkoutform" method="post" action="{{ url('client/project/pay/braintree') }}">
                        {{ csrf_field() }}
                        <div id="paypal-container"></div>
                        <div id="payment-form"></div>

                        <input type="hidden" name="project_id" value="{{ $project->id }}">
                        <input type="hidden" name="budget" value="{{$budget->budget}}">
                        <br>

                        <button type="submit" class="btn btn-primary-nbc" style="width:100%" name="button"><span>Pay</span></button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Project Details
                </div>
                <div class="panel-body">
                    <div>
                        <h3>Project Name : {{$project->name}}</h3>
                        <p>
                            <span style="font-size : 24px">Project Details : </span>
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                            tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                            quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                            consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                            cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                            proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                        </p>
                        <h3>PROJECT COST : $ {{$budget->budget}}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section ('scripts')
    <script src="{{asset('temp/vue.js')}}"></script>
    <script src="{{asset('temp/vue-resource.min.js')}}"></script>

    <script src="https://js.braintreegateway.com/js/braintree-2.32.0.min.js"></script>

    <script type="text/javascript">

    braintree.setup("@braintreeClientToken", "dropin", {
        container: "payment-form",
        form: 'checkoutform',
        paypal: {
            container:'paypal-container',
            locale: 'en_US',
            singleUse: true,
            intent:'sale',
            amount: {{ $budget->budget }},
            currency: 'USD',
            displayName: 'NBC',
            button: {
                type:'checkout'
            }
        },
        paymentMethodNonceReceived: function (event, data) {
            event.preventDefault();
            $('#paymentSuccess').removeClass('hidden');
            $('#checkoutform').addClass('hidden');

            $.ajax({
                url : '/client/projects/pay',
                method : 'POST',
                data : { "_token" : "{{ csrf_token() }}", "id" : "{{HELPERDoubleEncrypt($project->id)}}", "amount" : "{{$budget->budget}}", "nonce" : data },
                success : function (response) {
                    response = JSON.parse(response);
                    var dataToEmit = {
                        details : response.details,
                        client : response.client,
                        hashed : response.redirect
                    };
                    socket.emit('new project published', dataToEmit);
                    window.location = "/client/projects/published/"+response.redirect;
                }
            });

        }
    });

    </script>
@endsection
