const WebSocket = require('ws');

const ws = new WebSocket('ws://baitmah.com:6001?user_id=1');

ws.on('open', function open() {
	console.log("SOCKET IS OPENED");
});

ws.on('message', function incoming(data) {
  	console.log(data);
});
