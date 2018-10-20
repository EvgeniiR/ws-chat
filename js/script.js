var host = window.location.host;
var socket;

function connectToServer() {
    socket = new WebSocket("ws:my_token@" + host + "/ws/");

    socket.keepalive = true;

    socket.onopen = function () {
        console.log("Соединение установлено.");
        client.login(username);
    };

    socket.onclose = function (event) {
        if (event.wasClean) {
            console.log('Соединение закрыто чисто');
        } else {
            alert('Обрыв соединения!'); // например, "убит" процесс сервера
        }

        console.log('Код: ' + event.code + ' причина: ' + event.reason);
        console.log('Trying to reconnect');
        connectToServer();
    };

    socket.onmessage = function (event) {
        console.log(event);
        parseData(JSON.parse(event.data));
    };

    socket.onerror = function (error) {
        console.log("Ошибка " + error.message);
    };
}

class socketClient {
    constructor() {
        this.queryFields = {};
    }

    setField(key, value) {
        this.queryFields[key] = value;
    }

    login(username) {
        if (username === undefined) {
            username = prompt('Введите ваше имя', 'new user');
        }

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

function sendMessage() {
    client.setField('type', 'message');
    client.setField('message', textbox.val());
    result = client.send();

    if (result)
        textbox.val('');
}

function getMessages(body) {
    if (body.messages !== undefined) {
        messagesArray = [];
        body.messages.forEach(function (data) {
            messagesArray.push(data);
        });
        messagesArray.sort(sortMessagesByDateTime);
        addMessages(messagesArray);
    }
}

function addMessages(messagesArray) {
    for (var i = 0; i < messagesArray.length; i++) {
        console.log(messagesArray[i]);
        addMessage(
            formatTimestamp(messagesArray[i].dateTime),
            messagesArray[i].username,
            messagesArray[i].message)
    }
}

function addMessage(dateTime, username, text) {
    chatbox.append(dateTime + ":" + username + ". " + text);
    chatbox.appendChild(document.createElement("br"));
    scrollChatboxDownIfUserWasAtTheBottom();
}

function scrollChatboxDownIfUserWasAtTheBottom() {
    scrollHeight = chatbox.scrollHeight;
    currentScrollPosition = chatbox.scrollTop;
    offsetHeight = chatbox.offsetHeight;

    userScrollMaxValue = scrollHeight - offsetHeight;

    let scrollProportion = (currentScrollPosition / userScrollMaxValue);
    if (scrollProportion > 0.8 || scrollProportion === 0) {
        chatbox.scrollTop = userScrollMaxValue;
    }
}

function parseData(data) {
    switch (data.type) {
        case 'login':
            if (data.body.result === true) {
                authenticated = true;
                username = data.body.username;
            }
            else {
                alert('authentication with username' + data.body.username + 'failed: ' + data.body.message + '. Try to refresh the page.');
            }
            break;
        case 'messages':
            getMessages(data.body);
            break;
        case 'error':
            alert('Error: ' + data.body.message);
            break;
    }
}

connectToServer();

var username;
var textbox = $('#textbox');
var chatbox = document.getElementById("chatbox");
let client = new socketClient();
let authenticated = false;