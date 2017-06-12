var Notification = new Vue({
    methods : {
        Seen : function (dataToPost) {
            this.$http.post('/'+dataToPost.role+'/notification/read', dataToPost).then(response => {
            	
            }, response => {

            });
        }
    }
});
