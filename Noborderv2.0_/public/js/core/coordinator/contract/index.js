var contract = new Vue({
    el : "#project",
    data : {
        updateProject : false,
        worker_approved : null,
        client_approved : null,
        contract : JSON.parse($("#c").val().replace(/&quot;/g,'"')),
        project : JSON.parse($("#p").val().replace(/&quot;/g,'"')),
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

            this.$http.post("/coordinator/projects/worker/assign", {id : this.project.id, worker_id : this.contract.worker_id}).then(response => {
                var dataToEmit = {
                    hPId : $("#hPId").val(),
                    hCId : $("#hCId").val(),
                    contract : this.contract,
                    project : this.project,
                    type : 2
                };
                socket.emit('project development', dataToEmit);
                toastr.success('Project Updated  Successfully!');


                setTimeout(function() {
                    window.location = '/coordinator/projects/in_progress/'+$("#hPId").val();
                }, 5000);
            }, response => {

            });
        }
    }
});
