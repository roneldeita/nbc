socket.on('new contract', function (details) {
    var project = details.project;
    var contract = details.contract;

    if (contract.worker_id == aId) {
        toastr.info('You have new contract signing!', ''+project.name);
        addNotification(details);
    }
});
socket.on('contract approve', function (details) {
    var project = details.project;
    var contract = details.contract;

    if (contract.worker_id == aId) {
        toastr.info('You have new contract signing!', ''+project.name);
        addNotification(details);
    }
})

if (!urlForProjects()) {
    socket.on('new message', function (details) {
        if (details.receiver == aId) {
            toastr.info('You have new message!', ''+details.projectName);
            //addMessage('<li><a href="">'+ details.projectName +'</a></li>');
        }
    });
}

if (!urlForContractWorker()) {
    socket.on('project development', function (details) {
        var project = details.project;
        var contract = details.contract;

        if (contract.worker_id == aId) {
            toastr.success('Your have new project assigned!', ''+project.name);
            //addNotification('<li><a href=""><strong>Project Development </strong>: '+ details.projectName +'</a></li>');
            console.log('asd');
        }
    });
} else {
    socket.on('project development', function (details) {
        var project = details.project;
        var contract = details.contract;

        if (contract.worker_id == aId && project.id == $("#pId").val()) {
            toastr.success('Your have new project assigned!', ''+project.name);
            //addNotification('<li><a href=""><strong>Project Development </strong>: '+ details.projectName +'</a></li>');
            setTimeout(function() {
                window.location = '/worker/contract_signing/'+details.hCId;
            }, TIME_INTERVAL);
            //this.approve = true;
        }
    });
}

if (!urlForProgress()) {
    socket.on('progress comment', function (details) {
        var project = details.project;
        if (contract.worker_id = aId) {
            toastr.success('Worker Commented', ''+project.name);
            addNotification(details);
        }
    });

    socket.on('progress update', function (details) {
        var project = details.project;
        if (contract.worker_id = aId) {
            toastr.success('Worker Update', ''+project.name);
            addNotification(details);
        }
    });
} else {
    socket.on('progress comment', function (details) {
        var project = details.project;
        var deliverable = details.deliverable;
        var comment = details.comment;

        if (details.worker_id == aId && project.id == $("#pId").val()) {

            // toastr.success('Worker Commented', ''+project.name);
            // addNotification(details);
            //console.log(deliverables[details.index]);
            deliverables[details.index].comments.push(comment);
        }
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
