var contract = new Vue({
    el : '#project',
    data : {
        approve : false,
        contract : JSON.parse($("#c").val().replace(/&quot;/g,'"')),
        project : JSON.parse($("#p").val().replace(/&quot;/g,'"')),
    },
    methods : {
        Approve : function () {
            this.$http.post("/client/contract/approve", {id : this.contract.id }).then(response => {
                var dataToEmit = {
                    hPId : $("#hPId").val(),
                    project : this.project,
                    contract : this.contract,
                    update : response.data.worker_approved,
                    by : "client",
                    type : 4,
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
