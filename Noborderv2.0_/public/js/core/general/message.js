var Message = new Vue({
    methods : {
        Send : function (data) {
            var message = data.message;
            var project = data.project;
            var receiver = data.receiver;
            var role = data.role;

            var dataToPost = {
                message : message,
                project_id : project.id,
                project_status : project.status,
                receiver : receiver
            };

        	socket.emit("new message", data);

        	this.$http.post("/"+role+"/message/send", dataToPost).then(response => {

            }, response => {

            });
        },
        Seen : function (data) {
            // DOM -- it will make the unseen chat as seen and -1 from badge
            var message = $("#messagesMenu > li#"+data.projectId+" > a");
            var messageCount = $("#messagesBadge").text() - 1;
            if (message.hasClass("unseen")) {
                message.removeClass("unseen");
                if (messageCount > 0) {
                    $("#messagesBadge").text(messageCount);
                } else {
                    $("#messagesBadge").text("");
                }
            }

            // AJAX
            this.$http.post("/"+data.role+"/message/read", data).then(response => {
                console.log(data);
            }, response => {

            });
        }
    }
});
