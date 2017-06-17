@extends('layouts/worker/template')

@section('styles')
<link rel="stylesheet" type="text/css" href="{{asset('public/css/multisteps/style.css')}}">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tour/0.11.0/css/bootstrap-tour-standalone.min.css">

<style type="text/css">
    a {
        cursor: pointer;
    }
    .popover.welcome{
        max-width: 800px;
    }
    .tour-step-backdrop.tour-tour-element {
       z-index: 4000;
       background-color: white;
     }
     .categories {
        height: 100px;
        border: 1px solid #B0BEC5;
     }
     .categories:nth-child(-n+12) {
        border-bottom: none;
     }
     .categories:nth-child(2n+2) {
        border-left: none;
     }
     .categories:nth-child(2n+1) {
        border-left: none;
     }
     .categories:nth-child(4n+1) {
        border-left: 1px solid #B0BEC5;
     }


     .skills {
        border: 1px solid #B0BEC5;
        border-radius: 4px;
     }
     .skills-header {
        padding: 20px;
        border-bottom: 1px solid #B0BEC5;
        background-color: #f7f7f7;
        border-radius: 4px 4px 0 0;
     }
     .skills-body {

     }
     .skill-selected {
        padding:20px 20px;
        border-bottom: 1px solid #B0BEC5;
     }
     .skill-list {
        margin :0;
        padding: 0;
        list-style: none;
     }
     .skill-list li {
        float: left;
        width: 33%;
        line-height: 18px;
     }
     .skill-list li a{
        color: #636b6f;
        display: block;
        padding: 15px;
     }
     .skill-list li a:hover {
        background-color: #f7f7f7;
        text-decoration: none;
     }
     .chosen-skills {
        width: 100%;
        border: 1px solid #B0BEC5;
        border-radius: 4px;
     }
     .chosen-skills-body {
        height: 275px;
        overflow-y: auto;
     }

     .chosen-skills-list a{
        color: #636b6f;
        display: block;
        padding: 15px 20px;
     }
     .chosen-skills-list a:hover{
        text-decoration: none;
        background-color: #f7f7f7;
     }

</style>
@endsection

@section('content')
<div id="skills">
<div style="width: 100%; background-color: #bdbdbd; margin-top:-20px;">
    <div class="container" id="stepOne" style="padding-top: 20px;">
         <h2 class="text-center">Build up your profile</h2>
            <nav>
                <ol class="cd-multi-steps text-bottom count">
                    <li class="current"><a href="">Skills</a></li>
                    <li><em>Personal</em></li>
                    <li><em>Education</em></li>
                    <li><em>Experience</em></li>
                </ol>
            </nav>
    </div>
</div>

<div class="container"  style="padding: 20px 0px;">
    <div class="">
        <div class="col-md-12" id="stepTwo" style="padding-bottom: 20px;">
            <h2 class="text-center">Choose your skills</h2>
            <p style="width: 600px; margin:auto;" class="text-center">
                Choose atleast a maximum of 5 skills.This is for matching the project requirement based on your given skills.
            </p>
        </div>
        <div v-show="!hideCategory" class="col-md-9" id="stepThree" style="padding-top: 20px; padding-bottom: 20px;" >
            @foreach($categories as $category)
            <div class="col-md-3 text-center categories">
                <a @click="ViewCategory({{$category}}, $event)" class="category_link" style="display:block; padding-top: 20px; height: 100%; width: 100%;" >{{$category->name}}</a>
            </div>
            @endforeach
        </div>
        <div v-show="hideCategory" class="col-md-9" id="addSkill" style="padding-top: 20px; padding-bottom: 20px;">
            <div class="skills">
                <div class="skills-header ">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-1">
                                    <a id="stepFive" @click="HideCategory()" class="btn btn-default"><span class="pe-7s-back" style="font-size: 18px; font-weight: bold; width: 100%;"></span></a>
                                </div>
                                <div class="col-md-11">
                                    <p  id="stepFour" style="font-size: 18px; line-height: 2">@{{currentCategory}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="skills-body">
                    <div class="skill-selected"  id="stepSix">
                        <div class="input-group">
                            <span class="input-group-addon" ><span class="pe-7s-search" style="font-size: 18px; font-weight: bold"></span></span>
                            <input type="text" class="form-control" placeholder="Search Skills" v-model="searchString">
                        </div>
                    </div>
                    <div style="padding-bottom: 20px; overflow-y: auto; height : 300px;">
                        <div style="padding:20px; position: relative;">
                            <ul class="list-unstyled skill-list">
                                <li v-show="!hideExampleSkill">
                                    <a id="stepSeven"> Social Media Shift Lead <span class="pe-7s-plus pull-right" style="font-size: 18px; font-weight: bold"></span> </a>
                                </li>

                                <li v-for="skill in filteredSkills">
                                    <a @click="AddSkill(skill)">@{{skill.name}} <span  class="pe-7s-plus pull-right" style="font-size: 18px; font-weight: bold"></span></a>
                                </li>
                            </ul>
                            <div v-cloak v-show="searchString">
                                <div v-cloak v-show="filteredSkills.length < 1">
                                    No Skills Found
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div style="padding-top: 20px; padding-bottom: 20px;">
                <div class="chosen-skills"  id="stepEight">
                    <div class="chosen-skills-header" style="padding : 20px; border-bottom: 1px solid #B0BEC5">
                        @{{chosenSkills.length}} of 5 Selected Skills
                    </div>
                    <div class="chosen-skills-body">
                        <ul v-show="chosenSkills.length > 0" class="list-unstyled chosen-skills-list">
                            <li v-for="skill in chosenSkills">
                                <a @click="RemoveSkill(skill)">
                                    @{{skill.name}}
                                    <span  class="pe-7s-close-circle pull-right" style="font-size: 18px; font-weight: bold"></span>
                                </a>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-md-12 text-center">
        <br>
            <button v-if="!save" @click="SaveSkill()" v-bind:disabled="chosenSkills.length < 1" class="btn btn-lg btn-info" id="stepNine">Next</button>
            <button v-cloak v-if="save" class="btn btn-lg btn-info"  disabled>Next <i class="fa fa fa-circle-o-notch fa-spin"></i></button>
        </div>
    </div>
</div>
</div>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tour/0.11.0/js/bootstrap-tour.min.js"></script>

<script src="{{asset('public/temp/vue.js')}}"></script>
<script src="{{asset('public/temp/vue-resource.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.4/lodash.min.js"></script>

<script >
    Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('value');

    var tour = new Tour({
        name : 'firstTour',
        storage: false,
        debug: true,
        backdrop: true,
        backdropContainer: 'body',
      onEnd : function () {
            v.$data.viewCategory = true;
      }
    });


    tour.addStep({
        element : "#stepThree",
        content : "Please select category",
        template: "<div class='popover tour'> " +
            "<div class='arrow'></div>" +
            "<h3 class='popover-title'></h3>"+
            "<div class='popover-content'></div>"+
            "<div class='popover-navigation'>"+
            "<button class='btn btn-primary' data-role='end' style='width : 100%;'>Ok</button>"+
            "</div>"+
          "</div>",

    });
    @if (!Auth::user()->socialAcc)
    var welcomeTour = new Tour({
        name : 'firstTour',
        storage: false,
        debug: true,
        backdrop: true,
        backdropContainer: 'body',
        steps : [
        {
            content : "<h3 class='text-center' >Hi {{Auth::user()->name}}, Thank you for joining the NoBorderClub community. Before you start,build up your profile first, so Let's begin!"
        }],
        orphan : true,
        template : "<div class='popover welcome tour'>"+
            "<div class='arrow'></div>"+
            "<div class='popover-content'></div>"+
            "<div class='popover-navigation'>"+
                "<button class='btn btn-primary' data-role='end' style='width : 100%;'>Ok</button>"+
            "</div>"+
          "</div>",
      onEnd : function () {
          tour.init();
          tour.start();
      }
    });


    welcomeTour.init();
    welcomeTour.start();

    @else

        tour.init();
        tour.start();

    @endif


    var secondTour = new Tour({
        name : 'secondTour',
        storage: false,
        debug: true,
        backdrop: true,
        backdropContainer: 'body',
        steps : [
        {
            element : '#stepFour',
            content : 'This is your selected category. '
        },
        {
            element : '#stepSix',
            content : 'Use the search bar for searching skills'
        }
        ],
        template : "<div class='popover tour'>"+
        "<div class='arrow'></div>"+
        "<h3 class='popover-title'></h3>"+
        "<div class='popover-content'></div>"+
        "<div class='popover-navigation'>"+
            "<button class='btn btn-default' data-role='prev'>« Prev</button>"+
            "<button class='btn btn-default' data-role='next'>Next »</button>"+
        "</div>"+
        "</div>",
        orphan : true,
        onEnd : function () {
            v.$data.hideExampleSkill = true;
        }
    });

    secondTour.addStep({
        element : "#stepSeven",
        content : "Click the item to add the skill",
        template: "<div class='popover tour'> " +
            "<div class='arrow'></div>" +
            "<h3 class='popover-title'></h3>"+
            "<div class='popover-content'></div>"+
            "<div class='popover-navigation'>"+
            "<button class='btn btn-primary' data-role='end' style='width : 100%;'>Ok</button>"+
            "</div>"+
          "</div>",
    });

    var v = new Vue({
        el : '#skills',
        data : {
            currentCategory : '',
            currentSkills : [],
            chosenSkills : [],
            viewCategory : false,
            hideCategory: false,
            secondStepStarted : false,
            hideExampleSkill : false,
            save : false,
            searchString : ""
        },
        computed : {
            filteredSkills : function () {
                var skill_array = this.currentSkills;
                var searchString = this.searchString;

                if(!searchString){
                    return skill_array;
                }

                searchString = searchString.trim().toLowerCase();

                skill_array = skill_array.filter(function(item){
                    if(item.name.toLowerCase().indexOf(searchString) !== -1){
                        return item;
                    }
                });

                // Return an array with the filtered data.
                return skill_array;
            }
        },
        methods : {
            SaveSkill : function () {
                this.save = true;
                this.$http.post('/worker/cache', { key : 'skill', value : this.chosenSkills}).then(response => {
                    window.location = "/worker/personal";
                }, response => {

                });
            },
            ViewCategory : function (category, event) {
                this.$http.post('/worker/viewSkills', { id : category.id}).then(response => {
                    this.currentSkills = response.data;
                }, response => {

                });

                if (this.viewCategory == false) {
                    event.preventDefault();

                } else {
                    if (!this.secondStepStarted) {
                        secondTour.init();
                        secondTour.start();
                        this.secondStepStarted = true;
                    }
                    this.currentCategory = category.name;
                    this.hideCategory = true;
                }
            },
            ViewSkills : function (id) {
                this.$http.post('/worker/viewSkills', { id : id}).then(response => {
                console.log(response.data);
                }, response => {

                });
            },
            HideCategory : function () {
                this.hideCategory = false;
            },
            AddSkill : function (skill) {
                var checkIfExist = _.find(this.chosenSkills, skill);
                if (checkIfExist == null || checkIfExist == "") {

                    if (this.chosenSkills.length < 5) {
                        this.chosenSkills.push(skill);
                    }
                }
            },
            RemoveSkill : function (skill) {
                this.chosenSkills.splice(this.chosenSkills.indexOf(skill), 1);
            }
        }
    });



</script>
@endsection
