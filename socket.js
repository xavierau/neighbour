var app = require('express')();
var server = require('http').Server(app);
var io = require('socket.io')(server);
var Redis = require('ioredis');
var redis = new Redis();


redis.subscribe("neighbourApp:message", function (err, count) {
});
redis.subscribe("neighbourApp:notification", function (err, count) {
});

var connectionCounter = 0;

redis.on('message', function (channel, message) {
    message = JSON.parse(message);
    console.log('get redis pub');
    console.log(channel);
    var newChannel = channel + ":" + message.data.type;
    console.log(newChannel);
    io.emit(newChannel, message.data.message);
});

io.on('connection', function (socket) {
    console.log('new Connection')
    connectionCounter++;
    console.log(connectionCounter)

    socket.on('disconnect', function () {
        console.log("disconnected")
        connectionCounter--;
        console.log(connectionCounter)
    })
});


server.listen(3000, function () {
    console.log(server);
    console.log("Listening to *:3000");
});