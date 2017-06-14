var progress = new Vue({
    el : '#project',
    data : {
        id : pId,
        textUpdate : null,
        selectedDeliverable : null,
        deliverables : null,
        comment : null,
        commented : false,
        textUpdated : false
    },
    computed : {
        DeliverablePercentage : function () {
            var completed = 0;
            if (this.deliverables != null) {
                for (var i = 0; i < this.deliverables.length; i++) {
                    if (this.deliverables[i].status) {
                        completed++;
                    }
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
