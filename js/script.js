var socket = new WebSocket("ws:ws-chat.test/ws/");
var textbox = $('#textbox');
var chatbox = $('#chatbox');

socket.onopen = function () {
    console.log("Соединение установлено.");
};

socket.onclose = function (event) {
    if (event.wasClean) {
        console.log('Соединение закрыто чисто');
    } else {
        console.log('Обрыв соединения'); // например, "убит" процесс сервера
    }

    console.log('Код: ' + event.code + ' причина: ' + event.reason);
};

socket.onmessage = function (event) {
    console.log(event.data);
    data = JSON.parse(event.data);
    if (data.messages !== undefined) {
        data.messages.forEach(function (data) {
            chatbox.append(data.fd + ". " + data.message + "<br>");
        })
    }
};

socket.onerror = function (error) {
    console.log("Ошибка " + error.message);
};

function send() {
    socket.send(textbox.val());
    textbox.val('');
}