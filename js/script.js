var host = window.location.host;
var socket = new WebSocket("ws:my_token@" + host + "/ws/");

socket.onopen = function () {
    console.log("Соединение установлено.");
    client.login();
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
    console.log(event);
    parseData(JSON.parse(event.data));
};

socket.onerror = function (error) {
    console.log("Ошибка " + error.message);
};

class socketClient {
    constructor() {
        this.queryFields = {};
    }

    setField(key, value) {
        this.queryFields[key] = value;
    }

    login() {
        let username = undefined;

        username = prompt('Введите ваше имя', 'new user');

        if (username === undefined) return false;

        this.setField('type', 'login');
        this.setField('username', username);

        socket.send(JSON.stringify(this.queryFields));
    }

    send() {
        if (authenticated) {
            socket.send(JSON.stringify(this.queryFields));
            return true;
        }
        else {
            this.login();
            return false;
        }
    }
}

function isEmpty(str) {
    if (str === undefined) return true;
    if (str === null) return true;
    return str.trim() == '';
}

function sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}

function send() {
    client.setField('type', 'message');
    client.setField('message', textbox.val());
    result = client.send();

    if (result)
        textbox.val('');
}

function getMessages(data) {
    if (data.messages !== undefined) {
        data.messages.forEach(function (data) {
            chatbox.append(data.value.username + ". " + data.value.message + "<br>");
        })
    }
}

function parseData(data) {
    switch (data.type) {
        case 'login':
            if (data.login_result == true)
                authenticated = true
            else {
                alert('authentication failed: ' + data.message + '. Try to refresh the page.')
            }
            break;
        case 'messages':
            getMessages(data);
            break;
    }
}

var textbox = $('#textbox');
var chatbox = $('#chatbox');
let client = new socketClient();
let authenticated = false;