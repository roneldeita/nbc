var progress = new Vue({
    el : '#project',
    data : {
        id : pId,
        textUpdate : null,
        selectedDeliverable : null,
        deliverables : null,
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

            var dataToEmit = {
                hPId : $('#hPId').val(),
                project : this.project,
                deliverable : this.selectedDeliverable,
                comment : this.comment
            }
            socket.emit('progress comment', dataToEmit);


            this.$http.post('/worker/progress/comment', dataToPost).then(response => {

                location.reload();

            }, response => {


            });
        },
        SaveText : function (textId) {
            this.textUpdated = true;

            var dataToPost = {
                deliverable_id : this.selectedDeliverable.id,
                content : this.textUpdate
            }

            var dataToEmit = {
                hPId : $('#hPId').val(),
                project : this.project,
                deliverable : this.selectedDeliverable,
                text : this.textUpdate
            }
            socket.emit('progress update', dataToEmit);

            this.$http.post('/worker/progress/content', dataToPost).then(response => {
                location.reload();
            }, response => {


            });
        },
    }

});
