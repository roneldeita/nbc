@extends('layouts/worker/template')

@section('content')
<div class="container" id="skill_area">
    <div class="row">
        <div class="col-md-12">
            <h1>Choose Skills</h1>
        </div>
        <div class="col-md-9">
            <div class="panel">
                <div class="panel-body" style="padding: 0">
                    <div style="float: left; width: 250px; max-height: 500px; border: 1px solid #dddddd; overflow-y: auto;">
                        <div style="width: 100%; height: 50px; padding: 15px; background-color: #f5f3f3">
                            <p>Choose Category</p>
                        </div>
                        <div >
                            <ul class="custom_" >
                                <li v-for="category in categories"  v-cloak>
                                    <a href="#" @click="ChooseCategory(category)">
                                        @{{category.name}}
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    
                    <div style="margin-left: 250px; height: 500px; border: 1px solid #ddd">
                        <div style="width: 100%; height: 50px; padding: 15px; background-color: #f5f3f3">
                            <div>
                                @{{selectedCategory.name}}
                            </div>
                        </div>
                        <div style="width: 100%; height: 450px; overflow-y: auto">
                            <div v-if="selectedSkill != null">
                                <div class="input-group" style="padding: 20px;">
                                    <input type="text" class="form-control" placeholder="Search skills">
                                    <span class="input-group-addon"><i class="pe-7s-search"></i></span>
                                </div>
                                <table class="table"  style="border: none">
                                    <tbody>
                                        <tr v-for="skill in selectedSkill">
                                            <td><a @click="ChooseSkill(skill)"><i class="fa fa-plus"></i></a> @{{skill.name}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>    
        <div class="col-md-3">
            <div class="panel">
                <div style="float: left; width: 250px; max-height: 500px; border: 1px solid #dddddd; overflow-y: auto;">
                    <div style="width: 100%; height: 50px; padding: 15px; background-color: #f5f3f3">
                        <p>Choosen Skill</p>
                    </div>
                    <div >
                        <ul class="list-unstyled">
                            <li v-for="skill in choosenSkill">
                                <a @click="RemoveSkill(skill)">@{{skill.name}}</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>    
    </div>
</div>
@endsection

@section('scripts')
<script src="{{asset('temp/vue.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.4/lodash.min.js"></script>
<script type="text/javascript">
    var categories = "{{$categories}}";
    categories = JSON.parse(categories.replace(/&quot;/g,'"'));


    var skill1 = [
     { id : 1, caregory_id : 1, name : "C", selected : false},
     { id : 2, caregory_id : 1, name : "C++", selected : false },
     { id : 3, caregory_id : 1, name : "Java", selected : false },
     { id : 4, caregory_id : 1, name : "HTML", selected : false },
     { id : 5, caregory_id : 1, name : "CSS", selected : false },
     { id : 6, caregory_id : 1, name : "Javascript", selected : false },
     { id : 7, caregory_id : 1, name : "Lumen", selected : false },
     { id : 8, caregory_id : 1, name : "MVC", selected : false },
     { id : 9, caregory_id : 1, name : "PHP", selected : false },
     { id : 10, caregory_id : 1, name : "Laravel", selected : false },
     { id : 11, caregory_id : 1, name : "Code Igniter", selected : false },
    ];

    var skill2 = [
     { id : 1, caregory_id : 2, name : "C", selected : false},
     { id : 2, caregory_id : 2, name : "C++", selected : false },
     { id : 3, caregory_id : 2, name : "Java", selected : false },
     { id : 4, caregory_id : 2, name : "HTML", selected : false },
     { id : 5, caregory_id : 2, name : "CSS", selected : false },
     { id : 6, caregory_id : 2, name : "Javascript", selected : false },
     { id : 7, caregory_id : 2, name : "Lumen", selected : false },
     { id : 8, caregory_id : 2, name : "MVC", selected : false },
     { id : 9, caregory_id : 2, name : "PHP", selected : false },
     { id : 10, caregory_id : 2, name : "Laravel", selected : false },
     { id : 11, caregory_id : 2, name : "Code Igniter", selected : false },
    ];



    new Vue({
        el : '#skill_area',
        data : {
            categories : categories,
            selectedCategory : {name : null},
            selectedSkill : null,
            choosenSkill : [],
            currentCategory : null
        }, 
        methods : {
            ChooseCategory (category) {
                this.selectedCategory.name = category.name;
                this.selectedSkill = IdentifySkillSet(category.id);
                this.currentCategory = category.id;
            },
            ChooseSkill (skill) {  


                var data = this.selectedSkill;
                var newData = data.map(function(d) {
                    return d;
                }).indexOf(skill);

                this.selectedSkill[newData]['selected'] = true;

                this.choosenSkill.push({id : skill.id, name : skill.name});


                this.selectedSkill = _.filter(this.selectedSkill, function(v, k) {
                    return !v.selected;
                });
            },
            RemoveSkill (skill) {
                var skillSet = IdentifySkillSet(1);

                var newData = skillSet.map(function(d) {
                    return d;
                }).indexOf(skill.id);

                console.log(newData);

            }

        }
    });


    function IdentifySkillSet (id) {
        var skillSet;
        switch (id) {
            case 1:
                skillSet = skill1;
                break;
            case 2 :
                skillSet = skill2;
                break;
            case 3 :
                skillSet = skill1;
                break;
            case 4 :
                skillSet = skill2;
                break;
            case 5 :
                skillSet = skill5;
                break;
            case 6 :
                skillSet = skill6;
                break;
            case 7 :
                skillSet = skill7;
                break;
            case 8 :
                skillSet = skill8;
                break;
            case 9 :
                skillSet = skill9;
                break;
            case 10 :
                skillSet = skill10;
                break;
            case 11 :
                skillSet = skill11;
                break;
            case 12 :
                skillSet = skill12;
                break;
            case 13 :
                skillSet = skill13;
                break;
            case 14 :
                skillSet = skill14;
                break;
            case 15 :
                skillSet = skill15;
                break;
            case 16 :
                skillSet = skill16;
                break;
            default :
                skillSet = null;
                break;
        }
        skillSet = _.filter(skillSet, function(v, k){
            return !v.selected;
        });
        return skillSet;
    }

</script>
@endsection