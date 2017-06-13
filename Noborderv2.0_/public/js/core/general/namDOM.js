function addNotification (data) {
    var project = data.project;
    var status = (!('newStatus' in data)) ? identifyStatus(project.status) : data.newStatus;
    var type = data.type;
    var hPId = data.hPId;

    var badge = parseInt($('#notificationsBadge').text());
    if (isNaN(badge)) {
        badge = 0;
    }
    var final = badge + 1;
    $('#notificationsBadge').text(""+final);
    //$('#notificationsMenu').prepend(data);
    if ($("#mr").val() != "worker") {
        $('#notificationsMenu').prepend('<li><a class="unseen" href="'+CURRENT_URL+'/'+$("#mr").val()+'/projects/'+status+'/'+hPId+'"><strong>'+identifyType(type)+'<br>'+project.name+'</strong></a></li>')
    }

}

function addMessage (data) {
    var project = data.project;
    var message = data.message;
    var role = data.role;
    var hPId = data.hPId;

    var messageProjectId = $("#messagesMenu > li#"+project.id);
    var messageRow = $("#messagesMenu > li#"+project.id+" > a");
    var messageCount = parseInt($("#messagesBadge").text());
    var finalCount = 0;


    if (isNaN(messageCount)) {
        messageCount = 0;
    }
    finalCount = messageCount + 1

    if (messageProjectId) {
        if(!messageRow.hasClass("unseen")) {
            $("#messagesBadge").text(finalCount);
        }
        $("#messagesMenu #"+project.id).remove();
        $("#messagesMenu").prepend('<li id="'+project.id+'"> '+
            '<a class="unseen" href="'+CURRENT_URL+'/'+$("#mr").val()+'/projects/'+identifyStatus(project.status)+'/'+hPId+'" > <strong>'+project.name+'</strong>'+
            '<br><span>'+message+'</span>'+
            '</li></a>');
    } else {
        $("#messagesMenu").prepend('<li id="'+project.id+'"> '+
            '<a class="unseen" href="'+CURRENT_URL+'/'+$("#mr").val()+'/projects/'+identifyStatus(project.status)+'/'+hPId+'" > <strong>'+project.name+'</strong>'+
            '<br><span>'+message+'</span>'+
            '</li></a>');
        $("#messagesBadge").text(finalCount);
    }
}

function addMessageAsSeen (data) {
    var project = data.project;
    var message = data.message;
    var role = data.role;
    var pHId = data.pHId;

    var messageProjectId = $("#messagesMenu > li#"+project.id);
    var messageRow = $("#messagesMenu > li#"+project.id+" > a");
    var messageCount = parseInt($("#messagesBadge").text());


    if (messageProjectId) {
        $("#messagesMenu #"+project.id).remove();
        $("#messagesMenu").prepend('<li id="'+project.id+'"> '+
            '<a href="'+CURRENT_URL+'/'+$("#mr").val()+'/projects/'+identifyStatus(project.status)+'/'+hPId+'" > <strong>'+project.name+'</strong>'+
            '<br><span>'+message+'</span>'+
            '</li></a>');
    } else {
        $("#messagesMenu").prepend('<li id="'+project.id+'"> '+
            '<a href="'+CURRENT_URL+'/'+$("#mr").val()+'/projects/'+identifyStatus(project.status)+'/'+hPId+'" > <strong>'+project.name+'</strong>'+
            '<br><span>'+message+'</span>'+
            '</li></a>');
    }
}
