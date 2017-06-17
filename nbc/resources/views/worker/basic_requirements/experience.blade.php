@extends('layouts/worker/template')

@section('styles')
<link rel="stylesheet" type="text/css" href="{{asset('public/css/multisteps/style.css')}}">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tour/0.11.0/css/bootstrap-tour-standalone.min.css">
<link rel="stylesheet" href="{{asset('public/css/select2/select2.min.css')}}">

<style type="text/css">
    .tour-step-backdrop.tour-tour-element {
       z-index: 4000;
       background-color: white;
    }
    .modal-backdrop {
        background-color: rgba(0, 0, 0, 0.5);
    }

</style>
@endsection

@section('content')
<div id="experience">
<div style="width: 100%; background-color: #bdbdbd; margin-top:-20px;">
    <div class="container" style="padding-top: 20px;">
         <h2 class="text-center">Build up your profile</h2>
            <nav>
                <ol class="cd-multi-steps text-bottom count">
                    <li class="visited"><a>Skills</a></li>
                    <li class="visited"><a>Personal</a></li>
                    <li class="visited"><a>Education</a></li>
                    <li class="current"><a>Experience</a></li>
                </ol>
            </nav>
    </div>
</div>

<div class="container"  style="padding: 20px 0px;">
    <div class="">
        <div class="col-md-12" id="stepOne" style="padding-bottom: 20px;">
            <h2 class="text-center">Experience (Optional)</h2>
            <p style="width: 600px; margin:auto;" class="text-center">
                Experience
                Whether you are new or experienced, is counted as an attainment
                on your starting freelance career.
                Whatever you have accomplished before you can double it today.
            </p>
        </div>
    </div>

    <div>
        <div class="col-md-12">
            <div style="width: 600px; margin:auto;">
                <h3>Employment History <span class="pull-right"><a href="#modal_" data-toggle="modal" class="btn btn-success" id="stepTwo">Add <i class="pe-7s-plus"></i></a></span></h3>
                <hr>
                <div v-for="exp in experience" v-cloak>
                    <h3><strong>@{{exp.position}}</strong> | @{{exp.company}}</h3>
                    <p><strong>@{{exp.from}} - @{{exp.to}}</strong></p>
                    <p>@{{exp.additional}}</p>
                    <hr>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12 text-center">
    <br>
        <button v-if="!save" @click="SaveExperience()" class="btn btn-lg btn-info" id="stepNine">Next</button>
        <button v-cloak v-if="save" class="btn btn-lg btn-info" disabled>Next <i class="fa fa fa-circle-o-notch fa-spin"></i></button>
    </div>
</div>


<div class="modal fade" id="modal_" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Add Employment History</h4>

            </div>

            <div class="modal-body">
                <label>Company Name
                    <span v-if="!experienceDetails.company" class="text-danger">*</span>
                </label>
                <input type="text" v-model="experienceDetails.company" class="form-control">
                <br>
                <label>Position
                    <span v-if="!experienceDetails.position" class="text-danger">*</span>
                </label>
                <input type="text" v-model="experienceDetails.position" class="form-control">
                <br>

                <label>Date Started - Date End
                    <span v-if ="!experienceDetails.from && !experienceDetails.to" class="text-danger">*</span>
                </label>
                <div class="row">
                    <div class="col-md-6">
                        <select v-select2-year="from" class="form-control" style="width: 100%;">
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
                        <select v-select2-year="to" class="form-control" style="width: 100%;">
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

                <label>Additional Information</label>
                <textarea class="form-control" rows="6" v-model="additional"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary"  @click="AddExperience()" v-bind="{disabled : errors}" >Add</button>
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
                console.log(select.val());
                Vue.set(v.$data.experienceDetails, key,select.val());
            });
        },
        unbind: function (el, binding, vnode) {
            var select = $(el);
            select.select2('destroy');
        },
    });


    var v = new Vue({
        el : '#experience',
        data : {
            experience : [],
            experienceDetails : { company : '', position : '', from : '', to : ''},
            from : null,
            to : null,
            additional : null,
            save : false

        },
        computed : {
            errors : function () {
                for (var key in this.experienceDetails) {
                     if (!this.experienceDetails[key]) {
                        return true;
                    }

                }
                return false;
            }
        },
        methods : {
            AddExperience : function () {
                var data = {
                    company : this.experienceDetails.company,
                    position : this.experienceDetails.position,
                    from : this.experienceDetails.from,
                    to : this.experienceDetails.to,
                    additional : this.additional
                }

                this.experience.push(data);
                this.experienceDetails.company = '';
                this.experienceDetails.position = '';
                this.experienceDetails.from = '';
                this.experienceDetails.to = '';
                this.additional = '';

                $('select').val('').trigger('change');
                $('#modal_').modal('hide');
            },
            SaveExperience : function () {
                this.save = true;
                this.$http.post('/worker/saveDetails', { experience : this.experience }).then(response => {
                    window.location = "/worker/";
                }, response => {

                });
            }
        }
    });
</script>

@endsection
