var vm = new Vue({
    methods : {
        SeenNotification : function (dataToPost) {
            this.$http.post('/'+dataToPost.role+'/notification/read', dataToPost).then(response => {

            }, response => {

            });
        }
    }
});
