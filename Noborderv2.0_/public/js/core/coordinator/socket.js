socket.on('new project published', function (data) {
    var details = data.details;
    if (details.coordinator_id == aId) {
        addNotification('<li><a href=""><strong>New Project </strong>: '+ details.name +'</a></li>');
        toastr.info(''+details.name ,'New Project Created');
    }
});



if (!urlForProjects()) {
    socket.on('new message', function (details) {
        if (details.receiver == aId) {
            toastr.info('You have new message!', ''+details.projectName);
            addMessage(details);
        }
    });

} else {
    var pId = document.getElementById("pId").value;
    socket.on('new applicant', function (details) {
        if (details.projectId == pId ) {
            var worker = JSON.parse(details.worker.replace(/&quot;/g,'"'));
            if (published.$data.applicants == null || published.$data.applicants == "") {
                published.$data.applicants = [];
                published.$data.applicants.push(worker);
            }
            toastr.info('You have new applicant!', ''+details.projectName);
        } else if (details.receiver == aId) {
            toastr.info('You have new applicant!', ''+details.projectName);
        }
    });

    socket.on('new message', function (details) {
        if (details.receiver == aId && details.projectId == pId) {
            $('#message_container').append('<li class="left clearfix "><div class="chat_content clearfix"><p>'+details.message+'</p></div></li>');
            $('#message_parent').animate({scrollTop : $('#message_parent').prop('scrollHeight')});
            Message.Seen({role : "coordinator", projectId : pId});
        } else if (details.receiver == aId) {
            toastr.info('You have new message!', ''+details.projectName);
            addMessage(details);
        }
    });
}

if (urlForContract()) {
    var pCId = document.getElementById("pCId").value;
    socket.on('contract approve', function (details) {
        if (details.contract_id == pCId) {
            if (details.by == "worker") {
                toastr.info('Worker signed the contract', ''+details.projectName);
                $("#worker_approved").addClass("panel-success");
                $("#worker_approved_text").html('<i class="pe pe-7s-check" style="font-weight: bold; font-size: 35px"></i> Associate Approved the Contract');
                contract.$data.worker_approved = 1;
            } else {
                toastr.info('Client signed the contract', ''+details.projectName);
                $("#client_approved").addClass("panel-success");
                $('#client_approved_text').html('<i class="pe pe-7s-check" style="font-weight: bold; font-size: 35px"></i> Client Approved the Contract');
                contract.$data.client_approved = 1;
            }
        }
    });

}
