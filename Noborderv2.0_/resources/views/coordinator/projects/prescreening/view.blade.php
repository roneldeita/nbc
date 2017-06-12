@extends('layouts/coordinator/template')
@section('styles')
<style>
    ul.c {
    list-style-type: none;
    margin: 0;
    padding: 0;
    }

    ul.c > li {
    display: inline-block;
    float: left;
    }

    input[type="radio"][name="associate"] {
    display: none;
    }

    label.c {
    font-family: FontAwesome;
    border: 1px solid #fff;
    display: block;
    position: relative;
    margin: 5px;
    cursor: pointer;
    }

    label.c:before {
    background-color: white;
    color: white;
    content: " ";
    display: block;
    border-radius: 50%;
    position: absolute;
    top: -5px;
    left: -5px;
    width: 25px;
    height: 25px;
    text-align: center;
    line-height: 28px;
    transition-duration: 0.4s;
    transform: scale(0);
    }

    label.c img {
    height: 100px;
    width: 100px;
    transition-duration: 0.2s;
    transform-origin: 50% 50%;
    }
    label.c p {
    text-align: center;
    width: 100px;
    font-family: Raleway,sans-serif;
    margin-top: 5px;
    font-size: 12px;
    }

    :checked + label {
    border-color: #5cb85c;
    }

    :checked + label:before {
    content: "\f00c";
    background-color: #5cb85c;
    z-index: 1;
    transform: scale(1.1);
    }

    :checked + label img {
    transform: scale(0.9);
    z-index: -1;
    }
</style>
@endsection
@section('content')
<div class="container" id="project">
    <input type="hidden" id="hPId" value="{{HELPERDoubleEncrypt($project->id)}}">
    <input type="hidden" id="pId" value="{{$project->id}}">
    <input type="hidden" id="pName" value="{{$project->name}}">
    <input type="hidden" id="cId" value="{{$project->client_id}}"> 
    <div class="row">
        <div class="col-md-12">
        <?php
            $getStatusData = HELPERIdentifyStatus($project->status);
            $budget = json_decode($project->budget_info);
        ?>
        <h2># {{$project->name}} <span class="label {{$getStatusData['class']}}" style="font-size:18px; font-weight: normal; margin: 10px; border-radius: 20px; padding:5px 25px;">{{$getStatusData['status']}}</span>
        </h2>
        <br>
        <div class="col-md-6">
            <div class="panel">
                <div class="panel-body">
                    <div style="height : 300px; width : 100%; overflow-x : auto; overflow-y : auto; border : 1px solid #ddd; margin-bottom : 10px">
                        <div style="margin: 10px">
                            <h3>Applicants</h3>
                            <ul class="c">
                                @foreach($applicants as $applicant)
                                    <li><input type="radio" name="associate" id="{{$applicant->id}}" @click='ChooseWorker("{{$applicant->id}}")'   />
                                    <label class="c" for="{{$applicant->id}}"><img class="img img-circle" src="http://lorempixel.com/100/100" />
                                        {{$applicant->name}}
                                    </label>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label>Cost
                                <span v-if ="!contract.cost" class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" value="{{$budget->budget}}" v-model="contract.cost">
                        </div>
                        <div class="col-md-6">
                            <label>No. of Days
                                <span v-if ="!contract.days" class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" v-model ="contract.days">
                        </div>
                    </div>
                    <br>
                    <button v-if="!submit" @click="CreateContract()" type="button" class="btn btn-success" style="width:100%;" v-bind="{disabled : errors}">Create Contract</button>
                    <button v-cloak v-if="submit" type="button" class="btn btn-success" style="width:100%;" disabled>Create Contract <i class="fa fa fa-circle-o-notch fa-spin"></i></button>
                </div>
            </div>
        </div>
        <div class="col-md-6">

            <div class="panel">
                <div class="panel-body">
                    <label>Description</label><br>
                    {{str_limit($project->description, 100)}} <a href="">Read More</a><br><br>
                    <br>
                    <label>Deliverables</label><br>
                    <ul style="padding-left: 15px" class="list-unstyled">
                        @foreach (json_decode($project->deliverables) as $deliverable)
                            <li>
                                {{$deliverable->name}}
                            </li>
                        @endforeach
                    </ul>
                    <br>
                    <label>Terms & Condition</label><br>
                    <ul style="padding-left: 15px" class="list-unstyled">
                        @foreach (json_decode($project->terms_condition) as $term)
                            <li>
                                {{$term->name}}
                            </li>
                        @endforeach
                    </ul>
                    <br>
                </div>
            </div>

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
<script src="{{asset('js/core/general/notification.js')}}"></script>
<script src="{{asset('js/core/coordinator/prescreening/index.js')}}"></script>
<script type="text/javascript">
$(function(){
    $('input[type="radio"]').change(function(){
        var id = $(this).attr('id');
        console.log(id);
    });
});

var varDeliverables = "{{$project->deliverables}}";
var varTermsAndConditions = "{{$project->terms_condition}}";

varDeliverables = JSON.parse(varDeliverables.replace(/&quot;/g,'"'));
varTermsAndConditions = JSON.parse(varTermsAndConditions.replace(/&quot;/g,'"'));

prescreening.deliverables = varDeliverables;
prescreening.terms = varDeliverables;


Message.Seen({role : "coordinator", projectId : pId});
Notification.Seen({role : "coordinator", projectId : pId});
</script>
@endsection
