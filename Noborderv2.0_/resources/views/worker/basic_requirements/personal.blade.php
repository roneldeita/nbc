@extends('layouts/worker/template')

@section('styles')
<link rel="stylesheet" type="text/css" href="{{asset('css/multisteps/style.css')}}">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tour/0.11.0/css/bootstrap-tour-standalone.min.css">

<style type="text/css">
    .tour-step-backdrop.tour-tour-element {
       z-index: 4000;
       background-color: white;
     }
</style>
@endsection

@section('content')
<div id="personal">
<div style="width: 100%; background-color: #bdbdbd; margin-top:-20px;">
    <div class="container" style="padding-top: 20px;">
         <h2 class="text-center">Build up your profile</h2>
            <nav>
                <ol class="cd-multi-steps text-bottom count">
                    <li class="visited"><a>Skills</a></li>
                    <li class="current"><a>Personal</a></li>
                    <li><em>Education</em></li>
                    <li><em>Experience</em></li>
                </ol>
            </nav>
    </div>
</div>

<div class="container"  style="padding: 20px 0px;">
    <div class="">
        <div class="col-md-12" id="stepOne" style="padding-bottom: 20px;">
            <h2 class="text-center">Overview of yourself</h2>
            <p style="width: 600px; margin:auto;" class="text-center">
                This describes the worker's profile to be used as reference for linking job availability.
            </p>
        </div>
    </div>
    <div>
        <div class="col-md-12">
            <div style="width: 600px; margin: auto;">
                <textarea id="stepTwo" v-model = "personal.overview" class="form-control" rows="10" style="font-size: 18px;border: 3px solid black;background-color: #f7f7f7;"></textarea>
            </div>
        </div>
    </div>
    <div class="col-md-12 text-center">
    <br>
        <!-- <a href="" v-bind:disabled="chosenSkills.length" class="btn btn-lg btn-info" id="stepNine">Next</a> -->
        <button v-if="!save" @click="SavePersonal()" v-bind:disabled="!personal.overview" class="btn btn-lg btn-info" id="stepNine">Next</button>
        <button v-cloak v-if="save" class="btn btn-lg btn-info"  disabled>Next <i class="fa fa fa-circle-o-notch fa-spin"></i></button>
    </div>
</div>
</div>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tour/0.11.0/js/bootstrap-tour.min.js"></script>

<script src="{{asset('temp/vue.js')}}"></script>
<script src="{{asset('temp/vue-resource.min.js')}}"></script>

<script type="text/javascript">
    Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('value');


    var v = new Vue({
        el : '#personal',
        data : {
            personal : {overview : ''},
            save : false
        },
        methods : {
            SavePersonal : function () {
                this.save = true;
                this.$http.post('/worker/cache', { key : 'personal', value : this.personal}).then(response => {
                    window.location = "/worker/education";
                }, response => {

                });
            }
        }
    });
</script>

@endsection
