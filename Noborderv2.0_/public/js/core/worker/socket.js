socket.on('new contract', function (details) {
    if (details.workerId == aId) {
        toastr.info('You have new contract signing!', ''+details.projectName);
        addNotification('<li><a href=""><strong>New Contract </strong>: '+ details.projectName +'</a></li>');
    }
});

socket.on('contract approve', function (details) {
    if (details.receiver == aId) {
        toastr.info('Client approved to contract!', ''+details.projectName);
        addNotification('<li><a href=""><strong>Contract Approval</strong>: '+ details.projectName +'</a></li>');
    }
})

if (!urlForProjects()) {
    socket.on('new message', function (details) {
        if (details.receiver == aId) {
            toastr.info('You have new message!', ''+details.projectName);
            addMessage('<li><a href="">'+ details.projectName +'</a></li>');
        }
    });
}

if (!urlForContract()) {
    socket.on('project development', function (details) {
        if (details.workerId == aId) {
            toastr.success('Your have new project assigned!', ''+details.projectName);
            addNotification('<li><a href=""><strong>Project Development </strong>: '+ details.projectName +'</a></li>');
        }
    });
} else {
    socket.on('project development', function (details) {
        if (details.workerId == aId) {
            toastr.success('Your have new project assigned!', ''+details.projectName);
            addNotification('<li><a href=""><strong>Project Development </strong>: '+ details.projectName +'</a></li>');
            // setTimeout(function() {

            // }, TIMEINTERVAL);
            this.approve = true;
        }
    });
}