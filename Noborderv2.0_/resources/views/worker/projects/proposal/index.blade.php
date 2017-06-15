@extends('layouts/worker/template')

@section('content')
<?php
    $budget = json_decode($proposal->project->budget_info);
?>
<div style="position: relative; margin-top:-22px">
    <div style="height: 200px">
        <img src="http://placehold.it/2000X400/6794B2" class="img-responsive" style="min-height: 400px">
    </div>
    <div class="container" style="margin-top: -100px;">

        <div class="col-md-12">
            <div class="row">
                <div class="alert btn-secondary-nbc" role="alert">
                    "
                        Hi, Thank you for bidding on the job post. We have already published your bid to the client and we are currently waiting for him/her to review your bid. You will be receiving  a notification as soon as the client has accepted or rejected your bid. While waiting for a response, we suggest that you visit the project page (AS IT IS UPDATED REGULARLY)  for more projects to choose from. Good luck!"
                </div>
                <h1>
                    <div class="project-img background-primary-nbc">
                        {{$proposal->project->name[0]}}
                    </div>
                    <span style="color:#fff">{{$proposal->project->name}}</span>
                </h1>
                <br>
                <div class="row">
                    <div class="col-md-6">
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
                                <p><strong>Project File Link</strong></p>
            					<p>{{$proposal->project->link}}</p>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-6">
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
                                <p>$ {{$proposal->amount}}</p>
                                <br>
                                <p><strong>Message</strong></p>
                                <p>{{$proposal->message}}</p>
                                <br>
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
<script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.3/summernote.js"></script>
<script src="{{asset('temp/vue.js')}}"></script>
<script src="{{asset('temp/vue-resource.min.js')}}"></script>
<script type="text/javascript">
    Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('value');
</script>

@endsection
