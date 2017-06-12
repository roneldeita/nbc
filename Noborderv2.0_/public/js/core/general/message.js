var Message = new Vue({
    methods : {
        Send : function (data) {
            

            // EMIT
        	socket.emit("new message", data);

            // AJAX 
        	this.$http.post("/"+data.role+"/message/send", data).then(response => {

            }, response => {

            });
        }, 
        Seen : function (data) {
            // DOM -- it will make the unseen chat as seen and -1 from badge
            var message = $("#messagesMenu > li#"+data.projectId+" > a");
            var messageCount = $("#messagesBadge").text() - 1;
            if (message.hasClass("unseen")) {
                message.removeClass("unseen");
                if (messageCount > 1) {
                    $("#messagesBadge").text(messageCount);
                } else {
                    $("#messagesBadge").text("");
                }
            }

            // AJAX
            this.$http.post("/"+data.role+"/message/read", data).then(response => {

            }, response => {

            });
        }
    }
});
