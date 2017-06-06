@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tour/0.11.0/css/bootstrap-tour-standalone.min.css">
<style>
    .popover.welcome{
        max-width: 800px;
    }
</style>
@endsection

@section('content')
<div class="container" id="selectRole">
    <div class="row">
    <h1 class="text-center" >Choose between two!</h1><br>
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="row">
                    <div class="col-sm-6" style="border-right: 1px solid #e7eaec;">
                        <div style="padding:20px" class="text-center">
                            <h3>Become a client</h3>
                            <div style="padding:10px 0">
                                <img src="http://placehold.it/150x150" class="img-responsive img-circle" style="margin: 0 auto;" >
                            </div
                            <p>I want to hire a worker</p>
                            <button @click ="SelectRole(1)" id="stepOne" class="btn btn-success btn-md"  v-bind:disabled ="loadClient || loadWorker">Choose <i v-cloak v-show="loadClientLoading" class="fa fa-circle-o-notch fa-spin  fa-fw"></i></button>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div style="padding:20px" class="text-center">
                            <h3>Become a freelancer</h3>
                            <div style="padding:10px 0">
                                <img src="http://placehold.it/150x150" class="img-responsive img-circle" style="margin: 0 auto;" >
                            </div
                            <p>I'm looking for an online job</p>
                            <button @click ="SelectRole(2)"  id="stepTwo" class="btn btn-success btn-md" v-bind:disabled ="loadWorker || loadClient">Choose <i v-cloak v-show="loadWorkerLoading" class="fa fa-circle-o-notch fa-spin fa-fw"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tour/0.11.0/js/bootstrap-tour.min.js"></script>
<script src="{{asset('temp/vue.js')}}"></script>
<script src="{{asset('temp/vue-resource.min.js')}}"></script>
<script type="text/javascript">
    toastr.options = {
        "timeOut": "5000",
        "positionClass" : "toast-top-right",
        "progressBar": true,
    };

    Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('value');

    var tour = new Tour({
        name : 'firstTour',
        storage: false,
        debug: true,
        backdrop: true,
        backdropContainer: 'body',
        steps : [
        {
            content : '<h3 class="text-center">Welcome to Noborderclub </h3>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. '
        }],
        orphan : true,
        template : "<div class='popover welcome tour'>"+
            "<div class='arrow'></div>"+
            "<div class='popover-content'></div>"+
            "<div class='popover-navigation'>"+
                "<button class='btn btn-default' data-role='prev'>« Prev</button>"+
                "<button class='btn btn-default' data-role='next'>Next »</button>"+
            "</div>"+
          "</div>",
    });


    tour.addStep({
        element : "#stepOne",
        title : "Become a Client",
        content : "asdasdasdasdasd",
        template : "<div class='popover tour'>"+
        "<div class='arrow'></div>"+
        "<h3 class='popover-title'></h3>"+
        "<div class='popover-content'></div>"+
        "<div class='popover-navigation'>"+
            "<button class='btn btn-default' data-role='prev'>« Prev</button>"+
            "<button class='btn btn-default' data-role='next'>Next »</button>"+
        "</div>"+
      "</div>",
    });

    tour.addStep({
        element : "#stepTwo",
        title : "Become a worker",
        content : "asdasdasdasdasd",
        template : "<div class='popover tour'>"+
        "<div class='arrow'></div>"+
        "<h3 class='popover-title'></h3>"+
        "<div class='popover-content'></div>"+
        "<div class='popover-navigation'>"+
            "<button class='btn btn-default' data-role='prev'>« Prev</button>"+
            "<button class='btn btn-default' data-role='next'>Next »</button>"+
        "</div>"+
      "</div>",
    });

    tour.addStep({
        title : "Become a worker",
        content : "asdasdasdasdasd",
        template: "<div class='popover tour'> " +
            "<div class='arrow'></div>" +
            "<h3 class='popover-title'></h3>"+
            "<div class='popover-content'></div>"+
            "<div class='popover-navigation'>"+
            "<button class='btn btn-primary' data-role='end' style='width : 100%;'>Ok</button>"+
            "</div>"+
          "</div>",
        orphan : true
    });

    tour.init();
    tour.start();


    new Vue({
        el : '#selectRole',
        data : {
            loadClient : false,
            loadWorker : false,
            loadClientLoading : false,
            loadWorkerLoading : false,
        },
        methods : {
            SelectRole : function (role) {
                if (role == 1) {
                    this.loadClient = true;
                    this.loadClientLoading = true;

                    this.$http.post('', {role : role}).then(response => {
                        toastr.success('You Choose to become a client!');
                        setTimeout(function() {
                            window.location = "/";
                        }, 5000);

                    }, response => {

                    });

                } else if (role == 2) {
                    this.loadWorker = true;
                    this.loadWorkerLoading = true;

                    this.$http.post('', {role : role}).then(response => {
                        toastr.success('You Choose to become a worker!');
                        setTimeout(function() {
                            window.location = "/";
                        }, 5000);

                    }, response => {

                    });
                } else {
                    toastr.error('Theres a problem on the system, please reload your browser');
                }
            }
        }
    })
</script>
@endsection
