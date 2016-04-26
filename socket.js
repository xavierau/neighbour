var app = require('express')();
var server = require('http').Server(app);
var io = require('socket.io')(server);
var Redis = require('ioredis');
var redis = new Redis();


redis.subscribe("neighbourApp", function (error, count) {

});

io.on('connection', function (socket) {

    redis.on('message', function(channel, data){
        data = JSON.parse(data);
        console.log(data.data);
        console.log(data.data.type);
        console.log(data.data.data.type);
        console.log(data.data.data.data);

        var newChannel = channel+":"+data.data.data.type;
        console.log(newChannel);

        io.emit(newChannel, data.data.data.data);
    });

    console.log('new connection');

    socket.on('disconnect', function () {
        console.log('disconnect')
    })
});


server.listen(3000, function(){
    console.log("Listening to *:3000");
});