@extends('layouts/client/template')
@section('content')
<div class="container" id="project">
    <input type="hidden" id="pId" value="{{$project->id}}">
    <input type="hidden" id="hPId" value="{{HELPERDoubleEncrypt($project->id)}}">
    <input type="hidden" id="p" value="{{$project}}">
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

                        <button type="submit" class="btn btn-primary-nbc hidden" style="width:100%" name="button" id="pay">
                            <span>Pay</span>
                            <i class="fa fa-circle-o-notch fa-spin hidden" id="loading"></i>
                        </button>
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
                            {{$project->description}}
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
    setInterval(function(){
        if ($("#payment-form > iframe")) {
            $('#pay').removeClass('hidden');
        }
    }, 3000);

    $("#checkoutform").on("submit", function () {
        $('#pay').attr('disabled', 'disabled');
        $('#loading').removeClass('hidden');
    });
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
                        project : JSON.parse($("#p").val().replace(/&quot;/g,'"')),
                        type : 1,
                        hPId : $("#hPId").val(),
                        newStatus : "published"
                    };
                    socket.emit('new project published', dataToEmit);
                    window.location = "/client/projects/published/"+response.redirect;
                }
            });

        }
    });

    </script>
@endsection
