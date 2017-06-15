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

            //console.log(dataToEmit);
            //this.deliverables[dataToEmit.index].comments.push(dataToEmit.comment);

            this.$http.post('/worker/progress/comment', dataToPost).then(response => {

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
                    index : this.deliverables.indexOf(this.selectedDeliverable)
                }
                socket.emit('progress comment', dataToEmit);

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

            this.$http.post('/worker/progress/content', dataToPost).then(response => {
                var dataToEmit = {
                    hPId : $('#hPId').val(),
                    project : this.project,
                    deliverable : this.selectedDeliverable,
                    text : this.textUpdate,
                    index : this.deliverables.indexOf(this.selectedDeliverable),
                    selectedDeliverable : this.selectedDeliverable
                }
                socket.emit('progress update', dataToEmit);
                location.reload();
            }, response => {


            });
        },
    }

});
