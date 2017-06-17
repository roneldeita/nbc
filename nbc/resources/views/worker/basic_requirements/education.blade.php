@extends('layouts/worker/template')

@section('styles')
<link rel="stylesheet" href="{{asset('public/css/multisteps/style.css')}}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tour/0.11.0/css/bootstrap-tour-standalone.min.css">
<link rel="stylesheet" href="{{asset('public/css/select2/select2.min.css')}}">
<style type="text/css">
    .tour-step-backdrop.tour-tour-element {
       z-index: 4000;
       background-color: white;
     }
    .modal-backdrop {
         background-color: rgba(0, 0, 0, 0.5);
    }
    .select2-results__options {
       max-height: 500px;
    }
    .select2-selection__rendered {
      line-height: 32px !important;
    }
    .select2-selection {
      height: 34px !important;
    }

</style>

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
<div id="education">
<div style="width: 100%; background-color: #bdbdbd; margin-top:-20px;">
    <div class="container" style="padding-top: 20px;">
         <h2 class="text-center">Build up your profile</h2>
            <nav>
                <ol class="cd-multi-steps text-bottom count">
                    <li class="visited"><a>Skills</a></li>
                    <li class="visited"><a>Personal</a></li>
                    <li class="current"><a>Education</a></li>
                    <li><em>Experience </em></li>
                </ol>
            </nav>
    </div>
</div>

<div class="container"  style="padding: 20px 0px;">
    <div class="">
        <div class="col-md-12" id="stepOne" style="padding-bottom: 20px;">
            <h2 class="text-center">Education</h2>
            <p style="width: 600px; margin:auto;" class="text-center">
                Your educational background is vital. It will serve as a reference from the
                client upon starting a project.
            </p>
        </div>
        <div class="col-md-12">
            <div style="width: 600px; margin:auto;">
                <h3>Education History <span class="pull-right"><a href="#modal_" data-toggle="modal" class="btn btn-success" id="stepTwo">Add <i class="pe-7s-plus"></i></a></span></h3>
                <hr>
                <div v-for="edu in education" v-cloak>
                    <h3>@{{edu.institute}}</h3>
                    <p><strong>@{{edu.qualification}} @{{edu.field}}</strong></p>
                    <p><strong>@{{edu.from}} - @{{edu.to}}</strong></p>
                    <p>@{{edu.additional}}</p>
                    <hr>
                </div>
            </div>
        </div>
        <div class="col-md-12 text-center">
        <br>
            <!-- <a href="" v-bind:disabled="chosenSkills.length" class="btn btn-lg btn-info" id="stepNine">Next</a> -->
            <button v-if="!save" @click="SaveEducation()" v-bind:disabled="education.length < 1" class="btn btn-lg btn-info" id="stepNine">Next</button>
            <button v-cloak v-if="save" class="btn btn-lg btn-info"  disabled>Next <i class="fa fa fa-circle-o-notch fa-spin"></i></button>
        </div>
    </div>

</div>

<div class="modal fade" id="modal_" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Add Education History</h4>

            </div>

            <div class="modal-body">
                <label>Institute/University
                    <span v-if ="!educationDetails.institute" class="text-danger">*</span>
                </label>
                <input v-model="educationDetails.institute" type="text" class="form-control">
                <br>
                <label>Shool Year
                    <span v-if ="!educationDetails.from && !educationDetails.to" class="text-danger">*</span>
                </label>
                <div class="row">
                    <div class="col-md-6">
                        <select v-select2-year="from" class="form-control year" style="width: 100%;">
                            <option></option>
                            <option>1990</option>
                            <option>1991</option>
                            <option>1992</option>
                            <option>1993</option>
                            <option>1994</option>
                            <option>1995</option>
                            <option>1996</option>
                            <option>1997</option>
                            <option>1998</option>
                            <option>1999</option>
                            <option>2000</option>
                            <option>2001</option>
                            <option>2002</option>
                            <option>2003</option>
                            <option>2004</option>
                            <option>2005</option>
                            <option>2006</option>
                            <option>2007</option>
                            <option>2008</option>
                            <option>2009</option>
                            <option>2010</option>
                            <option>2011</option>
                            <option>2012</option>
                            <option>2013</option>
                            <option>2014</option>
                            <option>2015</option>
                            <option>2016</option>
                            <option>2017</option>
                            <option>2018</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <select v-select2-year="to" class="form-control year" style="width: 100%;">
                            <option></option>
                            <option>1990</option>
                            <option>1991</option>
                            <option>1992</option>
                            <option>1993</option>
                            <option>1994</option>
                            <option>1995</option>
                            <option>1996</option>
                            <option>1997</option>
                            <option>1998</option>
                            <option>1999</option>
                            <option>2000</option>
                            <option>2001</option>
                            <option>2002</option>
                            <option>2003</option>
                            <option>2004</option>
                            <option>2005</option>
                            <option>2006</option>
                            <option>2007</option>
                            <option>2008</option>
                            <option>2009</option>
                            <option>2010</option>
                            <option>2011</option>
                            <option>2012</option>
                            <option>2013</option>
                            <option>2014</option>
                            <option>2015</option>
                            <option>2016</option>
                            <option>2017</option>
                            <option>2018</option>
                        </select>
                    </div>
                </div>
                <br>

                <label>Qualification
                    <span v-if ="!educationDetails.qualification" class="text-danger">*</span>
                </label>
                <select  v-select2="qualification" class="form-control" style="width: 100%;">
                    <option></option>
                    <option>High School Diploma</option>
                    <option>Vocational Diploma / Short Course Certificate</option>
                    <option>Bachelor's / College Degree</option>
                    <option>Post Graduate Diploma / Master's Degree</option>
                    <option>Professional License (Passed Board / Bar / Professional License Exam)</option>
                </select>
                <br><br>

                <label>Field of Study
                    <span v-if ="!educationDetails.field" class="text-danger">*</span>
                </label>
                <select v-select2="field"  class="form-control" style="width: 100%;">
                    <option></option>
                    <option>Advertising / Media</option>
                    <option>Agriculture / Aquaculture / Forestry</option>
                    <option>Airline Operation / Airport Management</option>
                    <option>Architecture</option>
                    <option>Art / Design / Creative Multimedia</option>
                    <option>Biology</option>
                    <option>Bio Technology</option>
                    <option>Business Studies / Administration / Management</option>
                    <option>Chemistry</option>
                    <option>Commerce</option>
                    <option>Computer Science / Information Techonology</option>
                    <option>Dentistry</option>
                    <option>Economics</option>
                    <option>Journalism</option>
                    <option>Education / Teaching / Training</option>
                    <option>Engineering (Aviation / Aeronautics / Astronautics)</option>
                    <option>Engineering (Bioengineering / Biomedical)</option>
                    <option>Engineering (Chemical)</option>
                </select>
                <br><br>

                <label>Additional Information</label>
                <textarea class="form-control" rows="6" v-model="additional"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" @click="AddEducation()" v-bind="{disabled : errors}" >Add</button>
                </div>
            </div>
    </div>
</div>


</div>



@endsection

@section('scripts')
<script src="{{asset('public/js/select2/select2.full.min.js')}}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tour/0.11.0/js/bootstrap-tour.min.js"></script>

<script src="{{asset('public/temp/vue.js')}}"></script>
<script src="{{asset('public/temp/vue-resource.min.js')}}"></script>

<script type="text/javascript">
    Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('value');

    Vue.directive('select2-year', {
        inserted: function (el, binding, vnode) {
            var key = binding.expression;

            var select = $(el);

            select.select2({
                placeholder: 'Year'
            });
            select.on('select2:select', function () {
                Vue.set(v.$data.educationDetails, key,select.val());
            });
        },
        unbind: function (el, binding, vnode) {
            var select = $(el);
            select.select2('destroy');
        },
    });


    Vue.directive('select2', {
        inserted: function (el, binding, vnode) {
            var key = binding.expression;

            var select = $(el);

            select.select2({
                placeholder: 'Select Here'
            });
            select.on('select2:select', function () {
                Vue.set(v.$data.educationDetails, key,select.val());
            });
        },
        unbind: function (el, binding, vnode) {
            var select = $(el);
            select.select2('destroy');
        },
    });
    var v = new Vue({
        el : '#education',
        data : {
            education : [],
            educationDetails : { institute : '', from : '', to : '', qualification : '', field : ''},
            institute : null,
            from : null,
            to : null,
            qualification : null,
            field : null,
            additional : null,
            save : false,
        },
        computed : {
            errors : function () {
                for (var key in this.educationDetails) {
                     if (!this.educationDetails[key]) {
                        return true;
                    }

                }
                return false;
            }
        },
        methods : {
            AddEducation : function () {
                var data = {
                    institute : this.educationDetails.institute,
                    from : this.educationDetails.from,
                    to : this.educationDetails.to,
                    qualification : this.educationDetails.qualification,
                    field : this.educationDetails.field,
                    additional : this.additional
                }

                this.education.push(data);
                this.educationDetails.institute = '';
                this.educationDetails.from = '';
                this.educationDetails.to = '';
                this.educationDetails.qualification = '';
                this.educationDetails.field = '';
                this.additional = '';

                $('select').val('').trigger('change');
                $('#modal_').modal('hide');
            },
            SaveEducation : function () {
                this.save = true;
                this.$http.post('/worker/cache', { key : 'education', value : this.education}).then(response => {
                    window.location = "/worker/experience";
                }, response => {

                });
            }
        }
    });
</script>

@endsection
