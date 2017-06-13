
var published = new Vue({
    el : '#project',
    data : {
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
            this.$http.post("/client/applicant_proposal/view", {id : id}).then(response => {
                this.showApplicantProposal = true;
                this.applicantProposl = null;
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
                    hPId : $("#pHId").val(),
                    message : this.message,
                    project : this.project,
                    role : "client",
                    receiver : this.project.coordinator_id
                }
                addMessageAsSeen(dataToEmit); // namDOM.js
                Message.Send(dataToEmit); // messsage.js
                this.message = '';
            }

        }
    }
});
