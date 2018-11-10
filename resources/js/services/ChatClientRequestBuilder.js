export default class ChatClientRequestBuilder {
    constructor(websocket) {
        this.websocket = websocket;
        this.queryFields = {};
    }

    setField(key, value) {
        this.queryFields[key] = value;
    }

    login(username) {
        this.setField('type', 'login');
        this.setField('username', username);
        this.sendRequest();
    }

    sendMessage(message) {
        this.setField('type', 'message');
        this.setField('message', message);
        this.sendRequest();
    }

    sendRequest() {
        this.websocket.send(JSON.stringify(this.queryFields));
        return true;
    }
}