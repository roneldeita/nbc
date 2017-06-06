@extends('layouts/client/template')

@section('content')
<div class="container"  id="project_details">
    <div class="row">
        <div class="col-md-12">
        <h1>Create Project</h1><br>
        </div>
        <form method="POST" v-on:submit="OnSubmitForm">
        <div class="col-md-6">
            <div class="panel" style="padding:20px;">
                <div class="panel-body">
                    <label  class="project-label">What type of project do you require?
                        <span class="text-danger" v-if="newProject.type === 'Select Here'">*</span>
                    </label>
                    <select class="form-control" v-model="newProject.type">
                        <option >Select Here</option>
                        @foreach ($skill_categories as $skill_category)
                            <option value="{{$skill_category->id}}">{{$skill_category->name}}</option>
                        @endforeach
                    </select><br><br>

                    <label class="project-label">What is the name of your project?
                        <span class="text-danger" v-if="!newProject.name">*</span>
                        <!-- <span class="text-danger" v-if="newProject.name.length < 6">The minimum should be 6 letter</span> -->
                    </label>
                    <input type="text" v-model="newProject.name" class="form-control" placeholder="e.g. Create Website Logo">
                    <br><br>

                    <label class="project-label">How much is your budget?
                        <span class="text-danger" v-if="!newProject.budget">*</span>
                    </label>
                        <div class="input-group">
                            <span class="input-group-addon">$</span>
                                <input type="number" v-model="newProject.budget" class="form-control" placeholder="e.g. 400">
                            <span class="input-group-addon">.00</span>
                        </div>
                    <br><br>

                    <label class="project-label">Choose you project term.
                        <span class="text-danger" v-if="newProject.timeline === 'Choose term'">*</span>
                    </label>
                    <select class="form-control" v-model="newProject.timeline">
                        <option >Choose term</option>
                        <option value="1 week">1 Week</option>
                        <option value="2 weeks">2 Weeks</option>
                        <option value="1 month">1 Month</option>
                        <option value="1-3 months">1 - 3 Months</option>
                        <option value="more than 6 months">More than 6 Months</option>
                    </select><br><br>

                    <div v-if="!submitted">
                        <button type="submit" class="btn btn-primary-nbc" style="width : 100%" v-bind="{disabled : errors}">    Create
                        </button>
                    </div>
                    <div v-else>
                        <button type="submit" class="btn btn-primary-nbc" style="width : 100%" disabled>
                            Creating
                            <i class="fa fa-circle-o-notch fa-spin"></i>
                        </button>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="panel" style="padding:20px;">
                <div class="panel-body">
                    <label class="project-label">Tell us more about your project.</label><br>

                    <label>Description
                        <span class="text-danger" v-if="!newProject.description">*</span>
                    </label>
                    <textarea rows="3" v-model="newProject.description" class="form-control" placeholder="Describe your project here..."></textarea><br><br>

                    <label>Deliverables
                        <span class="text-danger" v-if="!newProject.deliverables.length > 0">*</span>
                    </label>
                        <div class="input-group">
                            <input type="text" v-model="deliverable" class="form-control" placeholder="e.g. The color of the logo should be blue">
                            <span class="input-group-btn">
                                <button class="btn btn-primary-nbc" type="button" @click="AddDeliverable()">Add</button>
                            </span>
                        </div>
                    <br>

                    <ul class="list-unstyled" v-cloak>
                        <li v-for="deliverable in newProject.deliverables">
                            <a class="text-danger" style="cursor: pointer" @click="RemoveDeliverable(deliverable)">
                                <i class="pe-7s-close" style="font-size: 16px; font-weight: bold"></i>
                            </a>
                            <span style="font-size: 15px;">@{{deliverable.name}}</span>
                        </li>
                    </ul><br>

                    <label>Terms and Conditions
                        <span class="text-danger" v-if="!newProject.termAndAgreements.length > 0">*</span>
                    </label>
                    <div class="input-group">
                        <input type="text" v-model="termAndAgreement" class="form-control" placeholder="e.g. The created logo should be own design and not copyrighted">
                        <span class="input-group-btn">
                            <button class="btn btn-primary-nbc" type="button" @click="AddTermAndAgreement()">Add</button>
                        </span>
                    </div>
                    <br>

                    <ul class="list-unstyled">
                        <li v-for="termAndAgreement in newProject.termAndAgreements" v-cloak>
                            <a class="text-danger" style="cursor: pointer" @click="RemoveTermAndAgreement(termAndAgreement)">
                                <i class="pe-7s-close" style="font-size: 16px; font-weight: bold"></i>
                            </a>
                            <span style="font-size: 15px;">@{{termAndAgreement.name}}</span>
                        </li>
                    </ul>

                </div>
            </div>
        </div>
        </form>
    </div>
</div>
@endsection


@section('scripts')
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/1.7.3/socket.io.min.js"></script>

    <script src="https://unpkg.com/vue/dist/vue.js"></script>
    <script src="https://cdn.jsdelivr.net/vue.resource/1.3.1/vue-resource.min.js"></script> -->


    <script src="{{asset('temp/vue.js')}}"></script>
    <script src="{{asset('temp/vue-resource.min.js')}}"></script>

    <script type="text/javascript">
    socket.on('greetings', function (data) {
        console.log(data);
    });

    Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('value');

        new Vue({
            el : '#project_details',
            data : {
                newProject : { client : 1, type : 'Select Here', name : '', budget : '', timeline : 'Choose term', description : '', deliverables : [], termAndAgreements : [] },
                deliverable : '',
                termAndAgreement : '',
                submitted : false
            },
            computed : {
                errors : function () {
                    if (!this.newProject.deliverables.length > 0 || !this.newProject.termAndAgreements.length > 0) {
                        return true;
                    } else if (this.newProject.deliverables.length > 0 && this.newProject.termAndAgreements.length > 0) {
                        for (var key in this.newProject) {
                            if (this.newProject.type === 'Select Here' || this.newProject.timeline === 'Choose Term') {
                                return true;
                            } else if (!this.newProject[key]) {
                                return true;
                            } else {
                                return false;
                            }
                        }
                        return false;
                    } else {
                        return false;
                    }
                }
            },
            methods : {
                AddDeliverable : function () {
                    var value = this.deliverable && this.deliverable.trim();
                    if (!value) {
                        return;
                    }
                    this.newProject.deliverables.push({
                        name : value
                    });
                    this.deliverable = '';
                },
                RemoveDeliverable : function (deliverable) {
                    this.newProject.deliverables.splice(this.newProject.deliverables.indexOf(deliverable), 1);
                },
                AddTermAndAgreement : function () {
                    var value = this.termAndAgreement && this.termAndAgreement.trim();
                    if (!value) {
                        return;
                    }
                    this.newProject.termAndAgreements.push({
                        name : value
                    });
                    this.termAndAgreement = '';
                },
                RemoveTermAndAgreement : function (termAndAgreement) {
                    this.newProject.termAndAgreements.splice(this.newProject.termAndAgreements.indexOf(termAndAgreement), 1);
                },
                OnSubmitForm : function (e) {
                    e.preventDefault();
                    this.submitted = true;

                    this.$http.post('save', this.newProject).then(response => {
                        var dataToEmit = {
                            "details" : response.data.details,
                            "client" : response.data.client,
                            "hashed" : response.data.redirect
                        };
                        //socket.emit('new project published', dataToEmit);
                        window.location = "/client/projects/created/"+response.data.redirect;
                        //window.location = "/client";
                    }, response => {

                    });
                }
            }
        });
    </script>
@endsection
