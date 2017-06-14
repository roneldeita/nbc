
var published = new Vue({
    el : '#project',
    data : {
        updateProject : false,
        showApplicantProposal : false,
        applicantProposal : null,
        applicants : null,
        message : '',
        project : JSON.parse($("#p").val().replace(/&quot;/g,'"')),
    },
    computed : {
        emptyMessage : function () {
            if (/\S/.test(this.message)) {
                return false;
            }
            return true;
        }
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
                var dataToEmit = {
                    hPId : $("#hPId").val(),
                    message : this.message,
                    project : this.project,
                    role : "coordinator",
                    receiver : this.project.client_id
                }
                addMessageAsSeen(dataToEmit);
                Message.Send(dataToEmit);
                this.message = '';
            }

        },
        UpdateProjectStatus : function (project_id, status) {
            this.updateProject = true;
            var dataToEmit = {
                hPId : $("#hPId").val(),
                project : this.project,
                newStatus : response.data.projectStatus,
                type : 2
            };
            socket.emit('project update', dataToEmit);
            console.log(this.project);
            // this.$http.post("/coordinator/projects/status/update", {id : project_id, status : status}).then(response => {
            //     if (response.data.status == 200 || response.data.status == "200") {
            //         var dataToEmit = {
            //             hPId : $("#hPId").val(),
            //             project : this.project,
            //             newStatus : response.data.projectStatus,
            //             type : 2
            //         };
            //         socket.emit('project update', dataToEmit);
            //         toastr.success('Project Updated  Successfully!');
            //         setTimeout(function() {
            //             window.location = '/coordinator/projects/'+response.data.projectStatus+'/'+response.data.redirect;
            //         }, TIME_INTERVAL);
            //     }
            // }, response => {
            //
            // });
        }

    }
});
