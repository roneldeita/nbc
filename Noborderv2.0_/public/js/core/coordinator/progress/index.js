var progress = new Vue({
    el : '#project',
    data : {
        id : pId,
        user_id : $("#aId").val(),
        textUpdate : null,
        //selectedDeliverable : JSON.parse($("#deliverables").val().replace(/&quot;/g,'"'))[0],
        selectedDeliverable  : null,
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
        },
        CanAccessFinalFile : function () {
            var completed = 0;

            for (var i = 0; i < this.deliverables.length; i++) {
                if (this.deliverables[i].status) {
                    completed++;
                }
            }
            return completed == this.deliverables.length;
        }
    },
    methods : {
        SelectDeliverable : function (deliverable) {
            this.selectedDeliverable = deliverable;
        },
    }
});
