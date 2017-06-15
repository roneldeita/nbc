socket.on('new project published', function (details) {
    var project = details.project;
    if (project.coordinator_id == aId) {
        addNotification(details);
        toastr.info(''+project.name ,'New Project Created');
    }
});



if (!urlForProjects()) {
    socket.on('new message', function (details) {
        var project = details.project;
        var receiver = details.receiver;
        if (receiver == aId) {
            toastr.info('You have new message!', ''+project.name);
            addMessage(details); //namDOM.js
        }
    });

    socket.on('new applicant', function (details) {
        var project = details.project;
        var worker = details.worker;
        if (project.coordinator_id == aId) {
            toastr.info('You have new applicant!', ''+project.name);
            addNotification(details);
        }
    });

} else {
    var pId = document.getElementById("pId").value;
    socket.on('new applicant', function (details) {
        var project = details.project;
        var worker = details.worker;

        if (project.id == pId ) {
            var worker = JSON.parse(details.worker.replace(/&quot;/g,'"'));
            if (published.$data.applicants == null || published.$data.applicants == "") {
                published.$data.applicants = [];
                published.$data.applicants.push(worker);
            }
            toastr.info('You have new applicant!', ''+project.name);

        } else if (project.coordinator_id == aId) {
            toastr.info('You have new applicant!', ''+project.name);
            addNotification(details);

        }
    });

    socket.on('new message', function (details) {
        var project = details.project;
        var receiver = details.receiver;
        var message = details.message;

        if (receiver == aId && project.id == pId) {
            $('#message_container').append('<li class="left clearfix "><div class="chat_content clearfix"><p>'+message+'</p></div></li>');
            $('#message_parent').animate({scrollTop : $('#message_parent').prop('scrollHeight')});
            addMessageAsSeen(details); // namDOM.js
            Message.Seen({role : "coordinator", projectId : pId}); // message.js
        } else if (receiver == aId) {
            toastr.info('You have new message!', ''+project.name);
            addMessage(details); // namDOM.js
        }
    });
}

if (urlForContract()) {
    var pCId = document.getElementById("pCId").value;
    socket.on('contract approve', function (details) {
        var project = details.project;
        var contract = details.contract;
        var by = details.by;

        if (contract.id == pCId) {
            if (by == "worker") {
                toastr.info('Worker signed the contract', ''+project.name);
                $("#worker_approved").addClass("panel-success");
                $("#worker_approved_text").html('<i class="pe pe-7s-check" style="font-weight: bold; font-size: 35px"></i> Associate Approved the Contract');
                //contract.$data.worker_approved = 1;
            } else {
                toastr.info('Client signed the contract', ''+project.name);
                $("#client_approved").addClass("panel-success");
                $('#client_approved_text').html('<i class="pe pe-7s-check" style="font-weight: bold; font-size: 35px"></i> Client Approved the Contract');
                //contract.$data.client_approved = 1;
            }
        }
    });
} else {
    socket.on('contract approve', function (details) {
        var project = details.project;
        var contract = details.contract;
        var by = details.by;

        if (project.coordinator_id == aId) {
            if (by == "worker") {
                toastr.info('Worker signed the contract', ''+project.name);
                addNotification(details);
            } else {
                toastr.info('Client signed the contract', ''+project.name);
                addNotification(details);
            }
        }
    });
}

if (!urlForProgress()) {
    socket.on('progress comment', function (details) {
        var project = details.project;
        if (project.coordinator_id = aId) {
            toastr.success('Worker Commented', ''+project.name);
            addNotification(details);
        }
    });

    socket.on('progress update', function (details) {
        var project = details.project;
        if (project.coordinator_id_id = aId) {
            toastr.success('Worker Update', ''+project.name);
            addNotification(details);
        }
    });
} else {
    socket.on('progress comment', function (details) {
        var project = details.project;
        var deliverable = details.deliverable;
        var comment = details.comment;

        // else (project.client_id = aId) {
        //     toastr.success('Worker Commented', ''+project.name);
        //     addNotification(details);
        // }
    });

    socket.on('progress update', function (details) {
        var project = details.project;
        var deliverable = details.deliverable;
        var text = details.text;

        // else (project.client_id = aId) {
        //     toastr.success('Worker Update', ''+project.name);
        //     addNotification(details);
        // }
    });
}
