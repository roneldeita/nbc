var Notification = new Vue({
    methods : {
        Seen : function (dataToPost) {
        	// var notifications = $("#notificationsMenu > li .notif"+dataToPost.projectId);
        	// notifications.removeClass('unseen');
        	// var notificationCount = $("#notificationsBadge").text() - notifications.size();
        	// if (notificationCount > 0) {
        	// 	$("#notificationsBadge").text(notificationCount);
        	// } else {
        	// 	$("#notificationsBadge").text("");
        	// }

   			//notifications.find('*').removeClass('unseen');
   			//console.log(notifications.size());

            this.$http.post('/'+dataToPost.role+'/notification/read', dataToPost).then(response => {

            }, response => {

            });
        }
    }
});
