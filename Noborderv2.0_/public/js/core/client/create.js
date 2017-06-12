var create = new Vue({
    el : '#project',
    data : {
        newProject : { client : 1, type : 'Select Here', name : '', budget : '', link : '', timeline : 'Choose term', description : '', deliverables : [], termAndAgreements : [] },
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