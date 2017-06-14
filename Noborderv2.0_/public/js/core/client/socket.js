if (!urlForContract()) {
    socket.on('new contract', function (details) {
        var contract = details.contract;
        var project = details.project;
    	if (contract.client_id == aId) {
    		toastr.info('You have new contract signing!', ''+project.name);
            addNotification(details);
    	}
    });
} else {
    var pId = document.getElementById("pId").value;
    socket.on('new contract', function (details) {
        var contract = details.contract;
        var project = details.project;

        if (project.id == pId && project.client_id == aId) {
            toastr.success('Youre Project Will Procceed to Contract Signing!');
            setTimeout(function() {
                window.location = '/client/projects/contract_signing/'+$("#hPId").val();
            }, TIME_INTERVAL);
        } else if (project.client_id == aId) {
            toastr.info('You have new contract signing!', ''+project.name);
            addNotification(details);
        }
    });
}
socket.on('contract approve', function (details) {
    var contract = details.contract;
    var project = details.project;

    if (contract.client_id == aId) {
        toastr.info('Worker approved to contract!', ''+project.name +'');
        addNotification(details);
    }
});

//
if (!urlForProjects()) {
    socket.on('new message', function (details) {
        var project = details.project;
        var receiver = details.receiver;
        if (receiver == aId) {
            toastr.info('You have new message!', ''+project.name);
            addMessage(details); // namDOM.js
        }
    });
    socket.on('project update', function (details) {
        var project = details.project;
        var hPId = details.hPId;
        var status = (!('newStatus' in details)) ? identifyStatus(project.status) : data.newStatus;
        if (project.client_id == aId) {
            toastr.success('Your project updated to '+ status +'!', ''+project.name);
            addNotification(details);
        }
        console.log(details);
    });
} else {
	var pId = document.getElementById("pId").value;

    socket.on('new message', function (details) {
        var project = details.project;
        var receiver = details.receiver;
        var message = details.message;

        if (receiver == aId && project.id == pId) {
            $('#message_container').append('<li class="left clearfix "><div class="chat_content clearfix"><p>'+message+'</p></div></li>');
            $('#message_parent').animate({scrollTop : $('#message_parent').prop('scrollHeight')});
            addMessageAsSeen(details); //namDOM.js
            Message.Seen({role : "client", projectId : pId}); // message.js
        } else if (receiver == aId) {
            toastr.info('You have new message!', ''+project.name);
            addMessage(details); // namDOM.js
        }
    });

	socket.on('project update', function (details) {
        var project = details.project;
        var hPId = details.hPId;
        var status = (!('newStatus' in details)) ? identifyStatus(project.status) : details.newStatus;
        if (project.id == pId) {
            toastr.success('Your project updated to Prescreening!');
            setTimeout(function() {
                window.location = '/client/projects/'+status+'/'+hPId;
            }, TIME_INTERVAL);
        } else if (project.client_id == aId) {
            toastr.success('Your project updated to '+ status +'!', ''+project.name);
            addNotification(details);
        }
    });
}


if (!urlForContract()) {
    socket.on('project development', function (details) {
        var project = details.project;

        if (project.client_id == aId) {
            toastr.success('Your project is now on development!', ''+project.name);
            addNotification(details);
        }
    });
} else {
	socket.on('project development', function (details) {
        var project = details.project;
        var hPId = details.hPId;
        if (project.client_id == aId) {
            toastr.success('Your project is now on development!', ''+project.name);
            addNotification(details);
             setTimeout(function() {
                window.location = "/client/projects/in_progress/"+hPId;
            }, TIME_INTERVAL);
        }
    });
}

if (!urlForPublished()) {
    socket.on('new applicant', function (details) {
        var project = details.project;
        var worker = details.worker;
        if (project.client_id == aId) {
            toastr.info('You have new applicant!', ''+project.name);
            addNotification(details);
        }
    });
} else {
    var pId = document.getElementById("pId").value;
    socket.on('new applicant', function (details) {
        var project = details.project;
        var worker = details.worker;
        if (project.id == pId) {
            var worker = JSON.parse(details.worker.replace(/&quot;/g,'"'));
            if (published.$data.applicants == null || published.$data.applicants == "") {
                published.$data.applicants = [];
                published.$data.applicants.push(worker);
            }
            toastr.info('You have new applicant!', ''+project.name);
        } else if (project.client_id == aId) {
            toastr.info('You have new applicant!', ''+project.name);
            addNotification(details);
        }
    });
}

if (!urlForProgress()) {
    socket.on('progress comment', function (details) {
        var project = details.project;
        if (project.client_id = aId) {
            toastr.success('Worker Commented', ''+project.name);
            addNotification(details);
        }
    });

    socket.on('progress update', function (details) {
        var project = details.project;
        if (project.client_id = aId) {
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
