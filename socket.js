var app = require('express')();
var server = require('http').Server(app);
var io = require('socket.io')(server);
var Redis = require('ioredis');
var redis = new Redis();


redis.subscribe("neighbourApp:message", function (err, count) {
});
redis.subscribe("neighbourApp:notification", function (err, count) {
});


redis.on('message', function (channel, message) {
    message = JSON.parse(message);
    var newChannel = channel + ":" + message.data.type;
    io.emit(newChannel, message.data.message);
});


server.listen(3000, function () {
    console.log("Listening to *:3000");
});