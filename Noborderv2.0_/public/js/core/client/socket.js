if (!urlForContract()) {
    socket.on('new contract', function (details) {
    	if (details.clientId == aId) {
    		toastr.info('You have new contract signing!', ''+details.projectName);
            addNotification('<li><a href=""><strong>New Contract </strong>: '+ details.projectName +'</a></li>');
    	}
    });
} else {
    var pId = document.getElementById("pId").value;
    socket.on('new contract', function (details) {
        if (details.projectId == pId && details.clientId == aId) {
            toastr.success('Youre Project Will Procceed to Contract Signing!');
            setTimeout(function() {
                window.location = '/client/projects/contract_signing/'+$("#hPId").val();
            }, TIME_INTERVAL);
        } else if (details.clientId == aId) {
            toastr.info('You have new contract signing!', ''+details.projectName);
            addNotification('<li><a href=""><strong>New Contract </strong>: '+ details.projectName +'</a></li>');
        }
    });
}
socket.on('contract approve', function (details) {
    if (details.receiver == aId) {
        toastr.info('Worker approved to contract!', ''+details.projectName +'');
        addNotification('<li><a href=""><strong>Contract Approval </strong>: '+ details.projectName +'</a></li>');
    }
});

//
if (!urlForProjects()) {
    socket.on('new message', function (details) {
        if (details.receiver == aId) {
            toastr.info('You have new message!', ''+details.projectName);
            addMessage(details);
        }
    });
    socket.on('project update', function (details) {
        if (details.clientId == aId) {
            toastr.success('Your project updated to '+ details.status +'!', ''+details.projectName);
            addNotification('<li><a href=""><strong>Project Status Updated </strong>: '+ details.projectName +'</a></li>');
        }
    });
} else {
	var pId = document.getElementById("pId").value;
	socket.on('new message', function (details) {
		if (details.receiver == aId && details.projectId == pId) {
			$('#message_container').append('<li class="left clearfix "><div class="chat_content clearfix"><p>'+details.message+'</p></div></li>');
            $('#message_parent').animate({scrollTop : $('#message_parent').prop('scrollHeight')});
            Message.Seen({role : "client", projectId : pId});
		} else if (details.receiver == aId) {
			toastr.info('You have new message!', ''+details.projectName);
            addMessage(details);
		}
	});
	socket.on('project update', function (details) {
        if (details.projectId == pId) {
            toastr.success('Your project updated to Prescreening!');
            setTimeout(function() {
                window.location = '/client/projects/'+details.projectStatus+'/'+details.projectIdHashed;
            }, TIME_INTERVAL);
        } else if (details.clientId == aId) {
            toastr.success('Your project updated to '+ details.status +'!', ''+details.projectName);
            addNotification('<li><a href=""><strong>Project Status Updated </strong>: '+ details.projectName +'</a></li>');
        }
    });
}


if (!urlForContract()) {
    socket.on('project development', function (details) {
        if (details.clientId == aId) {
            toastr.success('Your project is now on development!', ''+details.projectName);
            addNotification('<li><a href=""><strong>Project Status Updated </strong>: '+ details.projectName +'</a></li>');
        }
    });
} else { 
	socket.on('project development', function (details) {
        if (details.clientId == aId) {
            toastr.success('Your project is now on development!', ''+details.projectName);
            addNotification('<li><a href=""><strong>Project Status Updated </strong>: '+ details.projectName +'</a></li>');
             setTimeout(function() {
                window.location = "/client/projects/in_progress/{{HELPERDoubleEncrypt($project->id)}}";
            }, TIME_INTERVAL);
        }
    });
}

if (!urlForPublished()) {
    socket.on('new applicant', function (details) {
        if (details.clientId == aId) {
            toastr.success('You have new Applicant!', ''+details.projectName);
            addNotification('<li><a href=""><strong>New Applicant </strong>: '+ details.projectName +'</a></li>');
        }
    });
} else {

socket.on('new applicant', function (details) {
    if (details.projectId == pId ) {
        toastr.success('New Applicant!');
        var applicant = JSON.parse(details.worker.replace(/&quot;/g,'"'));
        published.$data.applicants.push(applicant);
    } else if (details.clientId == aId) {
        toastr.success('You have new Applicant!', ''+details.projectName);
        addNotification('<li><a href=""><strong>New Applicant </strong>: '+ details.projectName +'</a></li>');
    }
});
}