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
        <div class="col-md-7">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Project Details
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label>Name :</label><br>
                            {{$project->name}}<br><br>
                            <label>Cost :</label><br>
                            ${{number_format($budget->budget, 2)}}<br><br>
                        </div>
                        <div class="col-md-6">
                            <label>Category :</label><br>
                            {{HELPERIdentifyCategory($project->skill_category_id)}}<br><br>
                            <label>File Link :</label><br>
                            {{$project->link}}<br><br>
                        </div>
                    </div>
                    
                    <label>Timeline</label><br>
                    {{$project->timeline}}
                    <br>

                    <label>Description :</label><br>
                    <!-- {{str_limit($project->description, 100)}} <a href="">Read More</a><br><br> -->
                    {{$project->description}}<br><br>

                    <div class="row">
                        <div class="col-md-6">
                            <label>Deliverables</label>
                            <ul>
                                @foreach(json_decode($project->deliverables) as $deliverable)
                                <li>
                                    {{$deliverable->name}}
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <label>Terms and Conditions</label>
                            <ul>
                                @foreach(json_decode($project->terms_condition) as $term)
                                <li>
                                    {{$term->name}}
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
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
    </div>
</div>
@endsection


@section ('scripts')
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

        },
        onError : function () {
            $('#pay').removeAttr('disabled');
            $('#loading').addClass('hidden');
        }
    });

    </script>
@endsection
