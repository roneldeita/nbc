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
<div class="container" id="project_details">
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
                                        <p>{{$applicant->name}}</p>
                                    </label>
                                    </li>
                                @endforeach

                            </ul>
                        </div>
                    </div>

                    <label>Name Your Contract
                        <span v-if ="!contract.name" class="text-danger">*</span>
                    </label>
                    <input type="text" class="form-control" v-model="contract.name" >
                    <br>

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
                        <li v-for="deliverable in deliverables" v-cloak>
                            <a class="text-danger" style="cursor: pointer" @click="RemoveDeliverable(deliverable)">
                                <i class="pe-7s-close" style="font-size: 16px; font-weight: bold"></i>
                            </a>
                            @{{deliverable.name}}
                        </li>
                    </ul>
                    <div class="input-group">
                        <input type="text" v-model="newDeliverable" class="form-control" placeholder="e.g. The color of the logo should be blue">
                        <span class="input-group-btn">
                            <button class="btn btn-success" type="button" @click="AddDeliverable()">Add</button>
                        </span>
                    </div>
                    <br>
                    <label>Terms & Condition</label><br>
                    <ul style="padding-left: 15px" class="list-unstyled">
                        <li v-for="termAndCondition in termsAndConditions" v-cloak>
                            <a class="text-danger" style="cursor: pointer" @click="RemoveTermAndCondition(termAndCondition)">
                                <i class="pe-7s-close" style="font-size: 16px; font-weight: bold"></i>
                            </a>
                            @{{termAndCondition.name}}
                        </li>
                    </ul>
                    <div class="input-group">
                        <input type="text" v-model="newTermAndCondition" class="form-control" placeholder="e.g. The created logo should be own design and not copyrighted">
                        <span class="input-group-btn">
                            <button class="btn btn-success" type="button" @click="AddTermAndCondition()">Add</button>
                        </span>
                    </div>
                    <br>
                </div>
            </div>

        </div>

        </div>
    </div>
</div>
@endsection


@section('scripts')
    <!-- <script src="https://unpkg.com/vue/dist/vue.js"></script> -->

    <script src="{{asset('temp/vue.js')}}"></script>
    <script src="{{asset('temp/vue-resource.min.js')}}"></script>
    <script type="text/javascript">
        Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('value');
    </script>
    <script type="text/javascript" src="{{asset('js/tempV.js')}}"></script>
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

    var v = new Vue({
        el : '#project_details',
        data : {
            contract : {name : '', cost : '', days : '', worker_id : ''},
            deliverables : varDeliverables,
            origDeliverables : varDeliverables,
            termsAndConditions : varTermsAndConditions,
            editedDeliverable : null,
            editedTermAndCondition : null,
            oldDeliverable : null,
            oldTermAndCondition : null,
            newDeliverable : null ,
            newTermAndCondition : null,
            worker : null,
            submit : false
        },
        computed : {
            errors : function () {
                for (var key in this.contract) {
                     if (!this.contract[key]) {
                        return true;
                    }

                }
                return false;
            }
        },
        methods : {
           AddDeliverable : function () {
                var value = this.newDeliverable && this.newDeliverable.trim();
                if (!value) {
                    return;
                }
                this.deliverables.push({
                    name : value
                });
                this.newDeliverable = '';
            },
            AddTermAndCondition : function () {
                var value = this.newTermAndCondition && this.newTermAndCondition.trim();
                if (!value) {
                    return;
                }
                this.termsAndConditions.push({
                    name : value
                });
                this.newTermAndCondition = '';
            },
            RemoveDeliverable : function (deliverable) {
                this.deliverables.splice(this.deliverables.indexOf(deliverable), 1);
            },
            RemoveTermAndCondition: function (termAndCondition) {
                    this.termsAndConditions.splice(this.termsAndConditions.indexOf(termAndCondition), 1);
            },
            ChooseWorker : function (id) {
                this.worker = id;
                this.contract.worker_id = this.worker;
                console.log('worker' + this.worker);
            },
            CreateContract : function () {
                this.submit = true;

                this.$http.post('/coordinator/projects/contract', { id : "{{$project->id}}", contract : this.contract, deliverables : this.deliverables, terms : this.termsAndConditions}).then(response => {

                    var dataToEmit = {
                    projectName : "{{$project->name}}",
                    projectId : "{{$project->id}}",
                    clientId : "{{$project->client_id}}",
                    workerId : this.contract.worker_id
                    }

                    socket.emit('new contract', dataToEmit);
                    toastr.success('Contract Successfully Created!');
                    window.location = "/coordinator/projects/contract_signing/"+"{{HELPERDoubleEncrypt($project->id)}}";

                }, response => {

                });
            }
        },
        directives : {
        }
    });
    </script>
@endsection
