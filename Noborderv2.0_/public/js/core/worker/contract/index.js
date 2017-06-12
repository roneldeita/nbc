var contract = new Vue({
    el : '#project',
    data : {
        approve : false
    },
    methods : {
        Approve : function () {
            this.$http.post("/worker/contract/approve", {id : $("#cId").val()}).then(response => {
                var dataToEmit = {
                    contract_id : $("#cId").val(),
                    receiver : $("#receiver").val(),
                    project : $("#p").val(),
                    projectName : $("#pName").val(),
                    update : response.data.worker_approved,
                    by : "worker"
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
