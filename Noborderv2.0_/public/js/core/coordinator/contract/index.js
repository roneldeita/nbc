var contract = new Vue({
    el : "#project",
    data : {
        updateProject : false,
        worker_approved : null,
        client_approved : null,
    },
    computed : {
        canUpdate : function () {
            if (this.worker_approved == 1 && this.client_approved == 1) {
                return false;
            }
            return true;
        }
    },
    methods : {
        UpdateProjectStatus : function () {
            this.updateProject = true;

            this.$http.post("/coordinator/projects/worker/assign", {id : $("#pId").val(), worker_id : ("#wId").val()}).then(response => {
                var dataToEmit = {
                        clientId : $("#cId").val(),
                        workerId : $("#wId").val(),
                        projectName : $("#pName").val(),
                        projectId : $("#pId").val()
                    };
                socket.emit('project development', dataToEmit);
                toastr.success('Project Updated  Successfully!');


                setTimeout(function() {
                    window.location = '/coordinator/projects/in_progress/'+$("hPId").val();
                }, 5000);
            }, response => {

            });
        }
    }
});
