
var published = new Vue({
    el : '#project',
    data : {
        updateProject : false,
        showApplicantProposal : false,
        applicantProposal : null,
        applicants : null,
        message : '',
    },
    methods : {
        ShowApplicantProposal : function (id) {
            this.$http.post("/coordinator/applicant_proposal/view", {id : id}).then(response => {
                this.showApplicantProposal = true;
                this.applicantProposal = null;
                this.applicantProposal = response.data;
            }, response => {

            });
        },
        SendMessage : function (event) {
            event.preventDefault();
            if (/\S/.test(this.message)) {

                $('#message_container').append('<li class="left clearfix admin_chat"><div class="chat_content clearfix"><p>'+this.message+'</p></div></li>');
                $('#message_parent').animate({scrollTop : $('#message_parent').prop('scrollHeight')});

                Message.Send({ "message" :this.message, "projectId" : $("#pId").val(), "projectName" : $("#pName").val(), "receiver": $("#receiver").val(), "role" : "coordinator", "status" : "2"});
                this.message = null;
            }

        },
        UpdateProjectStatus : function (project_id, status) {
            this.updateProject = true;

            this.$http.post("/coordinator/projects/status/update", {id : project_id, status : status}).then(response => {
                if (response.data.status == 200 || response.data.status == "200") {
                    var dataToEmit = {
                        clientId : $("#receiver").val(),
                        projectName : $("#pName").val(),
                        projectId : $("#pId").val(),
                        projectIdHashed : response.data.redirect,
                        projectStatus : response.data.projectStatus,
                        redirect : response.data.redirect
                    };
                    socket.emit('project update', dataToEmit);
                    toastr.success('Project Updated  Successfully!');
                    setTimeout(function() {
                        window.location = '/coordinator/projects/'+response.data.projectStatus+'/'+response.data.redirect;
                    }, TIME_INTERVAL);
                }
            }, response => {

            });
        }

    }
});