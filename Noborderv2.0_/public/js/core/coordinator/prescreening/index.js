var prescreening = new Vue({
    el : '#project',
    data : {
        contract : {cost : '', days : '', worker_id : ''},
        deliverables : null,
        terms : null,
        worker : null,
        submit : false,
        project : JSON.parse($("#p").val().replace(/&quot;/g,'"')),
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
        ChooseWorker : function (id, days, amount) {
            this.worker = id;
            this.contract.worker_id = this.worker;
            this.contract.cost = amount;
            this.contract.days = days;
        },
        CreateContract : function () {
            this.submit = true;

            this.$http.post('/coordinator/projects/contract', { id : this.project.id, contract : this.contract, deliverables : this.deliverables, terms : this.termsAndConditions}).then(response => {

                var dataToEmit = {
                    hPId : $("#pHId").val(),
                    project : this.project,
                    contract : this.contract,
                    type : 3
                }
                socket.emit('new contract', dataToEmit);
                toastr.success('Contract Successfully Created!');
                window.location = "/coordinator/projects/contract_signing/"+$("#hPId").val();

            }, response => {

            });
        }
    }
});
