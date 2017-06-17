var contract = new Vue({
    el : '#project',
    data : {
        approve : false,
        contract : JSON.parse($("#c").val().replace(/&quot;/g,'"')),
        project : JSON.parse($("#p").val().replace(/&quot;/g,'"')),
    },
    methods : {
        Approve : function () {
            this.$http.post("/worker/contract/approve", {id : this.contract.id}).then(response => {
                var dataToEmit = {
                    hPId : $("#hPId").val(),
                    project : this.project,
                    contract : this.contract,
                    update : response.data.client_approved,
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
