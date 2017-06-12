
var published = new Vue({
    el : '#project',
    data : {
        showApplicantProposal : false,
        applicantProposal : null,
        applicants : null,
        message : '',
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
            this.$http.post("/client/applicant_proposal/view", {id : id}).then(response => {
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

                Message.Send({ "message" :this.message, "projectId" : $("#pId").val(), "projectName" : $("#pName").val(), "receiver": $("#receiver").val(), "role" : "client", "status" : "2"});
                this.message = '';
            }

        }
    }
});
