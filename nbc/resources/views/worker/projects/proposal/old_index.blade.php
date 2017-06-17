@extends('layouts/worker/template')

@section('content')
<?php
    $budget = json_decode($proposal->project->budget_info);
?>
<div style="position: relative; margin-top:-22px">
    <div style="height: 200px">
        <img src="http://placehold.it/2000X400/6794B2" alt="" class="img-responsive" style="min-height: 400px">
    </div>
    <div class="container" style="margin-top: -100px;">
        <div class="col-md-12">
            <div class="row">
                <h1>
                    <div class="project-img background-primary-nbc">
                        {{$proposal->project->name[0]}}
                    </div>
                    <span style="color:#fff">{{$proposal->project->name}}</span>
                </h1>
                <br>
                <div class="row">
                    <div class="col-md-7">
                        <div class="panel" style="box-shadow: 0 10px 20px rgba(0,0,0,0.19), 0 6px 6px rgba(0,0,0,0.23);">
                            <div class="panel-body">
                                <h3>Project Details</h3>
                                <br>
                                <p><strong>Posted By</strong></p>
                                <p>{{$proposal->project->client->name}}</p>
                                <br>
                                <p><strong>Project Category</strong></p>
                                <p>{{$proposal->project->skillCategory->name}}</p>
                                <br>
                                <p><strong>Project Budget</strong></p>
                                <p>$ {{$budget->budget}}</p>
                                <br>
                                <p><strong>Project Description</strong></p>
                                <p>
                                    {{$proposal->project->description}}
                                </p>
                            </div>
                        </div>

                        <div class="panel" style="box-shadow: 0 10px 20px rgba(0,0,0,0.19), 0 6px 6px rgba(0,0,0,0.23);">
                            <div class="panel-body">
                                <h3>Proposal Details</h3>
                                <br>
                                <p><strong>Date Proposed</strong></p>
                                <p>{{date('F d, Y', strtotime($proposal->created_at))}}</p>
                                <br>
                                <p><strong>Estimated Completion</strong></p>
                                <p>{{$proposal->days}}</p>
                                <br>
                                <p><strong>Amount</strong></p>
                                <p>{{$proposal->amount}}</p>
                                <br>
                                <p><strong>Message</strong></p>
                                <p>$ {{$proposal->message}}</p>
                                <br>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="panel"  style="box-shadow: 0 10px 20px rgba(0,0,0,0.19), 0 6px 6px rgba(0,0,0,0.23);" >
                            <div class="panel-body">
                                @component('layouts/general/chat_area')
                                    @slot('name')
                                        NoBorderClub Coordinator
                                    @endslot
                                    @slot('messages')
                                        <ul class="list-unstyled" id="message_container" style="margin-top: 5px">

                                        </ul>
                                    @endslot
                                    @slot('footer')
                                        <textarea class="form-control" placeholder="type a message" id="message"></textarea>
                                        <div class="clearfix"></div>
                                        <div class="chat_bottom">
                                            <button type="button" class="pull-right btn btn-primary-nbc" id="send">Send</button>
                                        </div>
                                    @endslot
                                @endcomponent
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
    $('#message_parent').animate({scrollTop : $('#message_parent').prop('scrollHeight')});
    $('#message').keydown(function (e) {
        var key = e.which;
        if(key == 13) {
          e.preventDefault();
          if (/\S/.test($('#message').val())) {


            var dataToEmit = {
                "projectName" : "{{$proposal->project->name}}",
                "projectId" : {{$proposal->project->id}},
                "receiver" : {{$proposal->project->coordinator->id}},
                "status" : {{$proposal->project->status}},
                message : $('#message').val()
            };
            //v.SendMessage(dataToEmit);
            socket.emit('new message', dataToEmit);
            $('#message_container').append('<li class="left clearfix admin_chat"><div class="chat_content clearfix"><p>'+$('#message').val()+'</p></div></li>');
            $('#message').val('');
            $('#message_parent').animate({scrollTop : $('#message_parent').prop('scrollHeight')});
           }
        }
    });
    $('#send').on('click', function () {
        if (/\S/.test($('#message').val())) {
            var dataToEmit = {
                "projectName" : "{{$proposal->project->name}}",
                "projectId" : {{$proposal->project->id}},
                "receiver" : {{$proposal->project->coordinator->id}},
                "status" : {{$proposal->project->status}},
                "message" : $('#message').val()
            };
            //v.SendMessage(dataToEmit);
            socket.emit('new message', dataToEmit);
            $('#message_container').append('<li class="left clearfix admin_chat"><div class="chat_content clearfix"><p>'+$('#message').val()+'</p></div></li>');
            $('#message').val('');
            $('#message_parent').animate({scrollTop : $('#message_parent').prop('scrollHeight')});
        }
    });
</script>
@endsection
