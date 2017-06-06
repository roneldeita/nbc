var app = require('express')();
var http = require('http').Server(app);
var io = require('socket.io')(http);
var port = process.env.PORT || 3000;
var connected = 0;


io.on('connection', function (socket) {
    connected++;
    console.log('a user connected. User connected : '+connected);
    socket.emit('greetings', 'Hi clients');


    socket.on('new project published', function (details) {
        console.log(details);
        io.emit('new project published', details);
    });

    socket.on('new message', function (details) {
        console.log(details);
        io.emit('new message', details);
    });

    socket.on('new applicant', function (details) {
        io.emit('new applicant', details);
    });

    socket.on('project update', function (details) {
        console.log(details);
        io.emit('project update', details);
    });

    socket.on('new contract', function (details) {
        console.log(details);
        io.emit('new contract', details);
    });

    socket.on('contract approve', function (details) {
        console.log(details);
        io.emit('contract approve',details);
    });

    socket.on('project development', function (details) {
        io.emit('project development', details);
    });
});


http.listen(port, function() {
    console.log('our server running on '+port);
});

setInterval(() => io.emit('time', new Date().toTimeString()), 1000);
