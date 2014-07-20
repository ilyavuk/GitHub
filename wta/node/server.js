/**
	walltoall.com 
*/
var io = require('socket.io'),
  connect = require('connect');

var app = connect().use(connect.static('public')).listen(3000);
var wallflow = io.listen(app);

wallflow.sockets.on('connection', function (socket) {
  socket.emit('entrance', {message: 'Welcome to the chat room!'});

  socket.on('disconnect', function  () {
    wallflow.sockets.emit('exit', {message: 'A chatter has disconnected.'});
  });

  socket.on('chat', function  (data) {
    wallflow.sockets.emit('chat', {message: data.message});
  });
  
  socket.on('deleteComment', function  (data) {
    wallflow.sockets.emit('deleteComment', {message: data.message});
  });
  
  socket.on('rateEvent', function  (data) {
    wallflow.sockets.emit('rateEvent', {message: data.message});
  });
  
  socket.on('likeComment', function  (data) {
    wallflow.sockets.emit('likeComment', {message: data.message});
  });
  
  socket.on('Attending', function  (data) {
    wallflow.sockets.emit('Attending', {message: data.message});
  });

  wallflow.sockets.emit('entrance', {message: 'A new chatter is online.'});
});