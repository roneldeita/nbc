function addNotification (data) {
    var badge = parseInt($('#notificationsBadge').text());
    if (isNaN(badge)) {
        badge = 0;
    }
    var final = badge + 1;
    $('#notificationsBadge').text(""+final);
    //$('#notificationsMenu').prepend(data);
}

function addMessage (data) {
    var messageProjectId = $("#messagesMenu > li #"+data.projectId);
    var messageRow = $("#messagesMenu > li#"+data.projectId+" > a");
    var messageCount = parseInt($("#messagesBadge").text());
    var finalCount = 0;


    if (isNaN(messageCount)) {
        messageCount = 0;
    }
    finalCount = messageCount + 1
   
   
    if (messageProjectId) {
        if(messageRow.hasClass("unseen")) {
            $("#messagesMenu > li#"+data.projectId+"> a > span").text(""+data.message);
        } else { 
            $("#messagesMenu > li#"+data.projectId+" > a").addClass("unseen");
            $("#messagesMenu > li#"+data.projectId+" > a > span").text(""+data.message);
            $("#messagesBadge").text(finalCount);
        }
    } else {
        $("#messagesMenu").prepend('<li id="'+data.projectId+'"> '+
            '<strong>'+data.projectName+'</strong>'+
            '<span>'+data.message+'</span>'+
            '</li>');
    }

}