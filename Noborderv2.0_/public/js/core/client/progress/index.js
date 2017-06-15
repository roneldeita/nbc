var progress = new Vue({
    el : '#project',
    data : {
        id : pId,
        user_id : $("#aId").val(),
        textUpdate : null,
        selectedDeliverable : null,
        comment : null,
        commented : false,
        textUpdated : false,
        project : JSON.parse($("#p").val().replace(/&quot;/g,'"')),
        deliverables : JSON.parse($("#deliverables").val().replace(/&quot;/g,'"')),
    },
    computed : {
        DeliverablePercentage : function () {
            var completed = 0;

            for (var i = 0; i < this.deliverables.length; i++) {
                if (this.deliverables[i].status) {
                    completed++;
                }
            }

            return Math.floor((100 / this.deliverables.length) * completed);
        }
    },
    methods : {
        SelectDeliverable : function (deliverable) {
            this.selectedDeliverable = deliverable;
        },
        SaveComment : function () {
            this.commented = true;

            var dataToPost = {
                deliverable_id : this.selectedDeliverable.id,
                content : this.comment
            }



            this.$http.post('/client/progress/comment', dataToPost).then(response => {
                var dataToEmit = {
                    hPId : $('#hPId').val(),
                    project : this.project,
                    deliverable : this.selectedDeliverable,
                    comment : {
                        by : {
                            name : $('#aName').val()
                        },
                        user_id : aId,
                        content : this.comment
                    },
                    index : this.deliverables.indexOf(this.selectedDeliverable),
                    worker_id : this.project.contract.worker_id
                }
                socket.emit('progress comment', dataToEmit);

                location.reload();

            }, response => {


            });
        },
        CheckDeliverable : function (id) {

            this.$http.post('/client/progress/deliverable/completed', {deliverable_id : id}).then(response => {

                location.reload();

            }, response => {


            });
        }
    }

});
