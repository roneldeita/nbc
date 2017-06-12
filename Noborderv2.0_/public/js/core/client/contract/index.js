var contract = new Vue({
    el : '#project',
    data : {
        approve : false
    },
    methods : {
        Approve : function () {
            this.$http.post("/client/contract/approve", {id : $("#pCId").val() }).then(response => {
                var dataToEmit = {
                    contract_id : $("#pCId").val(),
                    receiver : $("#receiver").val(),
                    project : $("#p").val(),
                    projectName : $("#pName").val(),
                    update : response.data.worker_approved,
                    by : "client"
                }
                socket.emit('contract approve', dataToEmit);
                toastr.info('You approved the contract!');
                setTimeout(function() {
                    location.reload();
                }, TIME_INTERVAL);
                this.approve = true;
            }, response => {

            });
        }
    }
});