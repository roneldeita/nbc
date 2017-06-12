var prescreening = new Vue({
    el : '#project',
    data : {
        contract : {cost : '', days : '', worker_id : ''},
        deliverables : null,
        terms : null,
        worker : null,
        submit : false
    },
    computed : {
        errors : function () {
            for (var key in this.contract) {
                 if (!this.contract[key]) {
                    return true;
                }
            }
            return false;
        }
    },
    methods : {
        ChooseWorker : function (id) {
            this.worker = id;
            this.contract.worker_id = this.worker;
        },
        CreateContract : function () {
            this.submit = true;

            this.$http.post('/coordinator/projects/contract', { id : $("#pId").val(), contract : this.contract, deliverables : this.deliverables, terms : this.termsAndConditions}).then(response => {

                var dataToEmit = {
                projectName : $("#pName").val(),
                projectId : $("#pId").val(),
                clientId : $("#cId").val(),
                workerId : this.contract.worker_id
                }

                socket.emit('new contract', dataToEmit);
                toastr.success('Contract Successfully Created!');
                window.location = "/coordinator/projects/contract_signing/"+$("#hPId").val();

            }, response => {

            });
        }
    }
});